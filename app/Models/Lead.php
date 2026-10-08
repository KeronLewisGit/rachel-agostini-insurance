<?php

namespace App\Models;

use Database\Factories\LeadFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Lead extends Model
{
    /** @use HasFactory<LeadFactory> */
    use HasFactory;

    public const TYPES = [
        'quote' => ['label' => 'Quote request', 'prefix' => 'QTE', 'icon' => 'file-text'],
        'calculator' => ['label' => 'Calculator estimate', 'prefix' => 'CAL', 'icon' => 'calculator'],
        'callback' => ['label' => 'Call-back request', 'prefix' => 'CBK', 'icon' => 'phone'],
        'contact' => ['label' => 'Message', 'prefix' => 'MSG', 'icon' => 'message-square'],
    ];

    public const STATUSES = [
        'new' => ['label' => 'New', 'tone' => 'brand'],
        'contacted' => ['label' => 'Contacted', 'tone' => 'sky'],
        'quoted' => ['label' => 'Quoted', 'tone' => 'amber'],
        'won' => ['label' => 'Policy issued', 'tone' => 'emerald'],
        'lost' => ['label' => 'Closed, no sale', 'tone' => 'slate'],
    ];

    public const OPEN_STATUSES = ['new', 'contacted', 'quoted'];

    protected $fillable = [
        'type', 'reference', 'status', 'name', 'email', 'phone', 'preferred_contact', 'product',
        'summary', 'message', 'data', 'source', 'score', 'estimated_premium', 'notes',
        'contacted_at', 'closed_at', 'is_sample',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'source' => 'array',
            'is_sample' => 'boolean',
            'contacted_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (Lead $lead) {
            $prefix = self::TYPES[$lead->type]['prefix'] ?? 'RA';
            $lead->updateQuietly(['reference' => sprintf('%s-%05d', $prefix, 1000 + $lead->id)]);
        });
    }

    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class)->latest();
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereIn('status', self::OPEN_STATUSES);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%")
                ->orWhere('reference', 'like', "%{$term}%")
                ->orWhere('summary', 'like', "%{$term}%");
        });
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->type]['label'] ?? Str::headline($this->type);
    }

    public function typeIcon(): string
    {
        return self::TYPES[$this->type]['icon'] ?? 'inbox';
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status]['label'] ?? Str::headline($this->status);
    }

    public function statusTone(): string
    {
        return self::STATUSES[$this->status]['tone'] ?? 'slate';
    }

    public function productName(): ?string
    {
        return $this->product ? (config("products.items.{$this->product}.name") ?? Str::headline($this->product)) : null;
    }

    public function isOpen(): bool
    {
        return in_array($this->status, self::OPEN_STATUSES, true);
    }

    /** Where the visitor came from, in one short phrase for lists. */
    public function sourceLabel(): string
    {
        $source = $this->source ?? [];

        if (! empty($source['utm_source'])) {
            return Str::headline($source['utm_source']).(! empty($source['utm_medium']) ? ' / '.$source['utm_medium'] : '');
        }

        if (! empty($source['referrer_host'])) {
            return $source['referrer_host'];
        }

        return 'Direct';
    }

    /** A wa.me link for replying on WhatsApp. */
    public function whatsappUrl(): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $this->phone);

        if (strlen($digits) < 7) {
            return null;
        }

        return 'https://wa.me/'.(strlen($digits) === 7 ? '1868'.$digits : $digits);
    }

    /** Move the lead along the pipeline and record it. */
    public function transitionTo(string $status, ?int $userId = null): void
    {
        if ($status === $this->status) {
            return;
        }

        $from = $this->statusLabel();
        $this->status = $status;

        if ($status === 'contacted' && ! $this->contacted_at) {
            $this->contacted_at = now();
        }

        $this->closed_at = in_array($status, ['won', 'lost'], true) ? now() : null;
        $this->save();

        $this->activities()->create([
            'user_id' => $userId,
            'type' => 'status',
            'body' => "Moved from {$from} to {$this->statusLabel()}",
        ]);
    }

    /**
     * A 0-100 priority score so the hottest leads sit at the top of the list.
     *
     * @param  array<string, mixed>  $data
     */
    public static function scoreFor(string $type, ?string $product, array $data): int
    {
        $score = match ($type) {
            'quote' => 55,
            'callback' => 50,
            'calculator' => 40,
            default => 25,
        };

        $score += match ($product) {
            'life-insurance', 'critical-illness', 'pensions-annuities' => 15,
            'employee-benefits', 'business-insurance' => 20,
            null => 0,
            default => 10,
        };

        $score += match ($data['timeframe'] ?? null) {
            'now' => 20,
            'month' => 10,
            'quarter' => 5,
            default => 0,
        };

        if (! empty($data['phone_ok']) || ($data['preferred_contact'] ?? null) === 'whatsapp') {
            $score += 5;
        }

        return min(100, $score);
    }
}
