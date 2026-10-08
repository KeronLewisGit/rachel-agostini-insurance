<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\PageView;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $since = now()->subDays(29)->startOfDay();

        $byStatus = Lead::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $byType = Lead::selectRaw('type, count(*) as total')->groupBy('type')->pluck('total', 'type');
        $byProduct = Lead::whereNotNull('product')->selectRaw('product, count(*) as total')->groupBy('product')->orderByDesc('total')->limit(6)->pluck('total', 'product');

        $leadsByDay = Lead::where('created_at', '>=', $since)->get(['created_at'])->groupBy(fn ($lead) => $lead->created_at->toDateString())->map->count();
        $viewsByDay = PageView::where('viewed_at', '>=', $since)->get(['viewed_at'])->groupBy(fn ($view) => $view->viewed_at->toDateString())->map->count();

        $days = collect(range(29, 0))->map(function ($offset) use ($leadsByDay, $viewsByDay) {
            $date = now()->subDays($offset)->toDateString();

            return ['date' => $date, 'leads' => $leadsByDay[$date] ?? 0, 'views' => $viewsByDay[$date] ?? 0];
        });

        $won = (int) ($byStatus['won'] ?? 0);
        $closed = $won + (int) ($byStatus['lost'] ?? 0);

        $sources = Lead::get(['source'])->groupBy(fn ($lead) => $lead->sourceLabel())->map->count()->sortDesc()->take(6);

        $topPages = PageView::where('viewed_at', '>=', $since)
            ->selectRaw('path, count(*) as total, count(distinct visitor) as visitors')
            ->groupBy('path')->orderByDesc('total')->limit(8)->get();

        $responseHours = Lead::whereNotNull('contacted_at')->get(['created_at', 'contacted_at'])
            ->map(fn ($lead) => $lead->created_at->diffInMinutes($lead->contacted_at) / 60)
            ->avg();

        return view('admin.dashboard', [
            'total' => $byStatus->sum(),
            'open' => Lead::open()->count(),
            'newCount' => (int) ($byStatus['new'] ?? 0),
            'won' => $won,
            'conversion' => $closed ? round($won / $closed * 100) : null,
            'thisMonth' => Lead::where('created_at', '>=', now()->startOfMonth())->count(),
            'lastMonth' => Lead::whereBetween('created_at', [now()->subMonthNoOverflow()->startOfMonth(), now()->subMonthNoOverflow()->endOfMonth()])->count(),
            'byStatus' => $byStatus,
            'byType' => $byType,
            'byProduct' => $byProduct,
            'sources' => $sources,
            'days' => $days,
            'topPages' => $topPages,
            'responseHours' => $responseHours,
            'visitors30' => PageView::where('viewed_at', '>=', $since)->distinct('visitor')->count('visitor'),
            'views30' => PageView::where('viewed_at', '>=', $since)->count(),
            'hot' => Lead::open()->orderByDesc('score')->orderByDesc('created_at')->limit(6)->get(),
            'recent' => Lead::latest()->limit(8)->get(),
            'stale' => Lead::where('status', 'new')->where('created_at', '<', Carbon::now()->subDay())->count(),
        ]);
    }
}
