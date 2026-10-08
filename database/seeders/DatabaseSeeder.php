<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\PageView;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $rachel = User::firstOrCreate(
            ['email' => config('site.email')],
            ['name' => 'Rachel Agostini', 'password' => 'password']
        );

        if (Lead::count() === 0) {
            Lead::factory()->count(28)->create()->each(function (Lead $lead) use ($rachel) {
                $lead->activities()->create(['type' => 'created', 'body' => 'Lead captured from the website ('.$lead->sourceLabel().').', 'created_at' => $lead->created_at]);

                if ($lead->status !== 'new') {
                    $lead->forceFill(['contacted_at' => $lead->created_at->addHours(rand(1, 20))])->saveQuietly();
                    $lead->activities()->create(['user_id' => $rachel->id, 'type' => 'whatsapp', 'body' => 'Sent an introduction on WhatsApp and booked a call.', 'created_at' => $lead->contacted_at]);
                }

                if (in_array($lead->status, ['won', 'lost'], true)) {
                    $lead->forceFill(['closed_at' => $lead->created_at->addDays(rand(3, 14))])->saveQuietly();
                }
            });
        }

        if (PageView::count() === 0) {
            $paths = ['/', '/', '/', '/insurance/life-insurance', '/insurance/critical-illness', '/calculators/life-cover', '/calculators/retirement', '/insurance/pensions-annuities', '/get-a-quote', '/about-rachel-agostini', '/faq', '/calculators/critical-illness'];

            for ($day = 29; $day >= 0; $day--) {
                $visitors = rand(6, 22);

                for ($v = 0; $v < $visitors; $v++) {
                    $visitor = (string) Str::uuid();
                    $utm = rand(1, 10) > 6 ? 'instagram' : null;

                    foreach (collect($paths)->random(rand(1, 3)) as $path) {
                        PageView::create([
                            'path' => ltrim($path, '/') ?: '/',
                            'visitor' => $visitor,
                            'utm_source' => $utm,
                            'utm_medium' => $utm ? 'social' : null,
                            'referrer_host' => $utm ? 'l.instagram.com' : (rand(0, 1) ? 'www.google.com' : null),
                            'viewed_at' => now()->subDays($day)->setTime(rand(7, 22), rand(0, 59)),
                        ]);
                    }
                }
            }
        }
    }
}
