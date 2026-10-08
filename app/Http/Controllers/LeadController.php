<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request, string $type): RedirectResponse
    {
        abort_unless(isset(Lead::TYPES[$type]), 404);

        $back = url()->previous(route('contact')).'#form-'.$type;

        // Honeypot: bots fill the hidden "website" field. Pretend it worked.
        if ($request->isSpam()) {
            return redirect()->to($back)->with('lead_success', ['type' => $type, 'reference' => null]);
        }

        $data = $request->validated();
        $extra = Arr::except($data, ['name', 'email', 'phone', 'preferred_contact', 'product', 'message', 'consent', 'website']);

        if ($type === 'calculator') {
            $extra['inputs'] = json_decode($data['inputs'], true) ?: [];
            $extra['results'] = json_decode($data['results'], true) ?: [];
            $data['product'] = config("calculators.items.{$data['calculator']}.product");
        }

        $extra['preferred_contact'] = $data['preferred_contact'] ?? null;

        $lead = Lead::create([
            'type' => $type,
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'preferred_contact' => $data['preferred_contact'] ?? null,
            'product' => $data['product'] ?? null,
            'message' => $data['message'] ?? null,
            'summary' => $this->summary($type, $data, $extra),
            'data' => $extra,
            'source' => $this->source($request),
            'score' => Lead::scoreFor($type, $data['product'] ?? null, $extra),
        ]);

        $lead->activities()->create(['type' => 'created', 'body' => 'Lead captured from the website ('.$lead->sourceLabel().').']);

        $this->notify($lead);

        return redirect()->to($back)->with('lead_success', [
            'type' => $type,
            'reference' => $lead->reference,
            'name' => Str::before($lead->name, ' '),
            'channel' => $lead->preferred_contact,
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $extra
     */
    protected function summary(string $type, array $data, array $extra): string
    {
        $product = isset($data['product']) ? config("products.items.{$data['product']}.name") : null;

        return match ($type) {
            'quote' => trim(implode(' · ', array_filter([
                $product,
                isset($extra['age']) ? "Age {$extra['age']}" : null,
                isset($extra['dependants']) ? $extra['dependants'].' '.Str::plural('dependant', (int) $extra['dependants']) : null,
                isset($extra['budget']) ? 'Budget '.str_replace(['-plus', '-'], ['+', ' to '], $extra['budget']).'/month' : null,
                isset($extra['timeframe']) ? match ($extra['timeframe']) {
                    'now' => 'Ready now',
                    'month' => 'Within a month',
                    'quarter' => 'Next three months',
                    default => 'Exploring',
                } : null,
            ]))),
            'calculator' => sprintf(
                '%s estimate: %s',
                config("calculators.items.{$extra['calculator']}.name"),
                collect($extra['results'])->map(fn ($value, $key) => Str::headline($key).' '.(is_numeric($value) ? 'TT$'.number_format((float) $value) : $value))->implode(', ')
            ),
            'callback' => 'Call back'.(isset($extra['best_time']) ? ' in the '.$extra['best_time'] : '').($product ? " about {$product}" : ''),
            default => Str::limit($data['message'] ?? 'Message', 140),
        };
    }

    /** @return array<string, mixed> */
    protected function source(StoreLeadRequest $request): array
    {
        $attribution = $request->session()->get('attribution', []);

        return array_merge($attribution, [
            'form_page' => Str::limit(parse_url(url()->previous(), PHP_URL_PATH) ?: '/', 255, ''),
            'pages_viewed' => $request->session()->get('pages_viewed', 1),
            'user_agent' => Str::limit((string) $request->userAgent(), 255, ''),
            'device' => preg_match('/Mobile|Android|iPhone/i', (string) $request->userAgent()) ? 'mobile' : 'desktop',
        ]);
    }

    protected function notify(Lead $lead): void
    {
        $recipient = User::first();

        if ($recipient) {
            $recipient->notify(new NewLeadNotification($lead));
        }
    }
}
