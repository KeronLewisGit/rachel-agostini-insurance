<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * First-touch attribution for lead tracking. Captures UTM tags, the referrer
 * and the landing page the first time a visitor arrives, keeps them in the
 * session, and records a lightweight page view for the admin dashboard.
 */
class TrackVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET') && ! $request->is('admin*', 'sitemap.xml', 'robots.txt', 'up')) {
            $this->captureAttribution($request);
            $this->recordPageView($request);
        }

        return $next($request);
    }

    protected function captureAttribution(Request $request): void
    {
        $session = $request->session();

        if (! $session->has('attribution')) {
            $referrer = (string) $request->headers->get('referer', '');
            $host = $referrer ? parse_url($referrer, PHP_URL_HOST) : null;

            $session->put('attribution', [
                'utm_source' => Str::limit((string) $request->query('utm_source', ''), 80, ''),
                'utm_medium' => Str::limit((string) $request->query('utm_medium', ''), 80, ''),
                'utm_campaign' => Str::limit((string) $request->query('utm_campaign', ''), 120, ''),
                'utm_content' => Str::limit((string) $request->query('utm_content', ''), 120, ''),
                'referrer_host' => $host && $host !== $request->getHost() ? $host : null,
                'landing_page' => $request->path(),
                'first_seen' => now()->toIso8601String(),
            ]);
        }

        if (! $session->has('visitor_id')) {
            $session->put('visitor_id', (string) Str::uuid());
        }

        $session->put('pages_viewed', ($session->get('pages_viewed', 0)) + 1);
        $session->put('last_page', $request->path());
    }

    protected function recordPageView(Request $request): void
    {
        $attribution = $request->session()->get('attribution', []);

        try {
            PageView::create([
                'path' => Str::limit($request->path(), 255, ''),
                'route' => $request->route()?->getName(),
                'visitor' => $request->session()->get('visitor_id', 'unknown'),
                'utm_source' => $attribution['utm_source'] ?: null,
                'utm_medium' => $attribution['utm_medium'] ?: null,
                'utm_campaign' => $attribution['utm_campaign'] ?: null,
                'referrer_host' => $attribution['referrer_host'] ?? null,
                'viewed_at' => now(),
            ]);
        } catch (\Throwable) {
            // Analytics must never break a page.
        }
    }
}
