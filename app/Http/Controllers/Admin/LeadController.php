<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'type', 'product', 'q', 'sort']);

        $leads = $this->query($filters)->paginate(20)->withQueryString();

        $counts = Lead::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('admin.leads', [
            'leads' => $leads,
            'filters' => $filters,
            'counts' => $counts,
            'products' => collect(config('products.items'))->map(fn ($item) => $item['name']),
        ]);
    }

    public function show(Lead $lead): View
    {
        return view('admin.lead', [
            'lead' => $lead->load('activities.user'),
            'calculator' => ($lead->data['calculator'] ?? null) ? config("calculators.items.{$lead->data['calculator']}") : null,
        ]);
    }

    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['nullable', Rule::in(array_keys(Lead::STATUSES))],
            'notes' => ['nullable', 'string', 'max:5000'],
            'estimated_premium' => ['nullable', 'integer', 'min:0', 'max:10000000'],
            'activity' => ['nullable', 'string', 'max:2000'],
            'activity_type' => ['nullable', Rule::in(['note', 'call', 'whatsapp', 'email', 'meeting'])],
        ]);

        if (array_key_exists('notes', $data)) {
            $lead->notes = $data['notes'];
        }

        if (array_key_exists('estimated_premium', $data)) {
            $lead->estimated_premium = $data['estimated_premium'];
        }

        $lead->save();

        if (! empty($data['activity'])) {
            $lead->activities()->create([
                'user_id' => $request->user()->id,
                'type' => $data['activity_type'] ?? 'note',
                'body' => $data['activity'],
            ]);

            if ($lead->status === 'new' && in_array($data['activity_type'] ?? 'note', ['call', 'whatsapp', 'email', 'meeting'], true)) {
                $lead->transitionTo('contacted', $request->user()->id);
            }
        }

        if (! empty($data['status'])) {
            $lead->transitionTo($data['status'], $request->user()->id);
        }

        return back()->with('saved', true);
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return redirect()->route('admin.leads')->with('saved', true);
    }

    public function export(Request $request): StreamedResponse
    {
        $leads = $this->query($request->only(['status', 'type', 'product', 'q']))->get();

        return response()->streamDownload(function () use ($leads) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Reference', 'Received', 'Type', 'Status', 'Name', 'Email', 'Phone', 'Preferred contact', 'Product', 'Summary', 'Score', 'Source', 'Landing page', 'Estimated premium', 'Notes']);

            foreach ($leads as $lead) {
                fputcsv($out, [
                    $lead->reference, $lead->created_at->toDateTimeString(), $lead->typeLabel(), $lead->statusLabel(),
                    $lead->name, $lead->email, $lead->phone, $lead->preferred_contact, $lead->productName(), $lead->summary,
                    $lead->score, $lead->sourceLabel(), $lead->source['landing_page'] ?? '', $lead->estimated_premium, $lead->notes,
                ]);
            }

            fclose($out);
        }, 'leads-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv']);
    }

    /** @param  array<string, mixed>  $filters */
    protected function query(array $filters): Builder
    {
        return Lead::query()
            ->when($filters['status'] ?? null, fn ($q, $status) => $status === 'open' ? $q->open() : $q->where('status', $status))
            ->when($filters['type'] ?? null, fn ($q, $type) => $q->where('type', $type))
            ->when($filters['product'] ?? null, fn ($q, $product) => $q->where('product', $product))
            ->search($filters['q'] ?? null)
            ->when(($filters['sort'] ?? null) === 'score', fn ($q) => $q->orderByDesc('score')->latest(), fn ($q) => $q->latest());
    }
}
