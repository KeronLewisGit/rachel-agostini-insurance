<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    public static function publicPages(): array
    {
        return [
            'home' => ['/', 'Protection planned'],
            'products' => ['/insurance', 'Twelve ways to protect'],
            'life insurance' => ['/insurance/life-insurance', 'Xpress Life'],
            'critical illness' => ['/insurance/critical-illness', 'Phoenix Plan'],
            'pensions' => ['/insurance/pensions-annuities', 'Lifestyle Pensions'],
            'calculators' => ['/calculators', 'Life Cover Calculator'],
            'life calculator' => ['/calculators/life-cover', 'Recommended life cover'],
            'retirement calculator' => ['/calculators/retirement', 'Tax saved this year'],
            'quote' => ['/get-a-quote', 'Real Guardian premiums'],
            'about' => ['/about-rachel-agostini', 'TTAIFA'],
            'faq' => ['/faq', 'licensed insurance agent'],
            'contact' => ['/contact', 'rachel.agostini@myguardiangroup.com'],
            'privacy' => ['/privacy', 'How your details are handled'],
        ];
    }

    #[DataProvider('publicPages')]
    public function test_public_page_renders(string $url, string $expected): void
    {
        $this->get($url)->assertOk()->assertSee($expected);
    }

    public function test_home_page_is_optimised_for_rachel_agostini_guardian_life_of_the_caribbean(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('<title>Rachel Agostini · Guardian Life of the Caribbean Sales Representative, Trinidad &amp; Tobago</title>', false)
            ->assertSee('Rachel Agostini Guardian Life of the Caribbean')
            ->assertSee('"@type":"InsuranceAgency"', false)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('rel="canonical"', false)
            ->assertSee('property="og:image"', false);
    }

    public function test_excluded_lines_are_not_offered_as_products(): void
    {
        $this->get('/insurance/motor')->assertNotFound();
        $this->get('/insurance/home')->assertNotFound();
        $this->get('/insurance/cyber')->assertNotFound();
        $this->get('/insurance')->assertSee('does not write Motor, Cyber or Home insurance');
    }

    public function test_sitemap_and_robots_are_served(): void
    {
        $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml')
            ->assertSee(url('/insurance/life-insurance'))
            ->assertSee(url('/calculators/retirement'));

        $this->get('/robots.txt')->assertOk()->assertSee('Disallow: /admin')->assertSee('Sitemap: '.url('/sitemap.xml'));
    }

    public function test_unknown_page_returns_not_found(): void
    {
        $this->get('/no-such-page')->assertNotFound()->assertSee('That page is not covered.');
    }

    public function test_quote_request_creates_a_scored_lead_with_attribution_and_notifies_rachel(): void
    {
        Notification::fake();
        $rachel = User::factory()->create();

        $this->get('/?utm_source=instagram&utm_medium=social&utm_campaign=past-pink', ['HTTP_REFERER' => 'https://l.instagram.com/']);

        $response = $this->from('/insurance/critical-illness')->post('/leads/quote', [
            'name' => 'Keisha Ramkissoon',
            'phone' => '(868) 555-0101',
            'email' => 'keisha@example.com',
            'preferred_contact' => 'whatsapp',
            'product' => 'critical-illness',
            'age' => 34,
            'dependants' => 2,
            'budget' => '300-600',
            'timeframe' => 'now',
            'consent' => '1',
        ]);

        $response->assertRedirect('/insurance/critical-illness#form-quote')->assertSessionHas('lead_success');

        $lead = Lead::firstOrFail();

        $this->assertSame('quote', $lead->type);
        $this->assertSame('new', $lead->status);
        $this->assertSame('QTE-01001', $lead->reference);
        $this->assertSame('critical-illness', $lead->product);
        $this->assertSame('instagram', $lead->source['utm_source']);
        $this->assertSame('past-pink', $lead->source['utm_campaign']);
        $this->assertSame('/insurance/critical-illness', $lead->source['form_page']);
        $this->assertSame(95, $lead->score);
        $this->assertStringContainsString('Critical Illness Cover', $lead->summary);
        $this->assertStringContainsString('Ready now', $lead->summary);
        $this->assertSame('created', $lead->activities()->first()->type);

        Notification::assertSentTo($rachel, NewLeadNotification::class);
    }

    public function test_calculator_estimate_is_stored_with_inputs_and_results(): void
    {
        $this->from('/calculators/life-cover')->post('/leads/calculator', [
            'name' => 'Marlon Baptiste',
            'phone' => '3475555',
            'calculator' => 'life-cover',
            'inputs' => json_encode(['income' => 12000, 'years' => 15]),
            'results' => json_encode(['recommendedCover' => 1500000]),
            'consent' => '1',
        ])->assertRedirect('/calculators/life-cover#form-calculator');

        $lead = Lead::firstOrFail();

        $this->assertSame('calculator', $lead->type);
        $this->assertSame('life-insurance', $lead->product);
        $this->assertSame(1500000, $lead->data['results']['recommendedCover']);
        $this->assertStringContainsString('TT$1,500,000', $lead->summary);
        $this->assertSame('https://wa.me/18683475555', $lead->whatsappUrl());
    }

    public function test_quote_requires_product_phone_and_consent(): void
    {
        $this->from('/get-a-quote')->post('/leads/quote', ['name' => 'No Details'])
            ->assertRedirect('/get-a-quote#form-quote')
            ->assertSessionHasErrors(['product', 'phone', 'consent'], null, 'quote');

        $this->assertSame(0, Lead::count());
    }

    public function test_honeypot_submissions_are_dropped_silently(): void
    {
        $this->from('/contact')->post('/leads/contact', [
            'name' => 'Bot', 'email' => 'bot@example.com', 'message' => 'Buy now', 'consent' => '1', 'website' => 'http://spam.example',
        ])->assertRedirect('/contact#form-contact')->assertSessionHas('lead_success');

        $this->assertSame(0, Lead::count());
    }

    public function test_unknown_lead_type_is_rejected(): void
    {
        $this->post('/leads/bogus', ['name' => 'X', 'consent' => '1'])->assertNotFound();
    }

    public function test_admin_requires_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/leads')->assertRedirect('/admin/login');
    }

    public function test_admin_can_log_in_view_dashboard_and_work_a_lead(): void
    {
        $rachel = User::factory()->create(['password' => 'secret-pass']);
        $lead = Lead::factory()->create(['status' => 'new', 'name' => 'Avinash Maharaj', 'product' => 'life-insurance']);

        $this->post('/admin/login', ['email' => $rachel->email, 'password' => 'secret-pass'])->assertRedirect('/admin');

        $this->get('/admin')->assertOk()->assertSee('Pipeline')->assertSee('Avinash Maharaj');
        $this->get('/admin/leads?status=new')->assertOk()->assertSee('Avinash Maharaj');
        $this->get('/admin/leads?q=Avinash')->assertOk()->assertSee('Avinash Maharaj');
        $this->get("/admin/leads/{$lead->id}")->assertOk()->assertSee('Where this lead came from');

        $this->patch("/admin/leads/{$lead->id}", ['activity' => 'Called, left a message.', 'activity_type' => 'call'])->assertRedirect();
        $this->assertSame('contacted', $lead->fresh()->status);
        $this->assertNotNull($lead->fresh()->contacted_at);

        $this->patch("/admin/leads/{$lead->id}", ['status' => 'won', 'notes' => 'Term life, TT$1.5m', 'estimated_premium' => 3600])->assertRedirect();
        $lead->refresh();
        $this->assertSame('won', $lead->status);
        $this->assertNotNull($lead->closed_at);
        $this->assertSame(3600, $lead->estimated_premium);
        $this->assertCount(2, $lead->activities()->where('type', 'status')->get());

        $export = $this->get('/admin/leads/export')->assertOk()->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Avinash Maharaj', $export->streamedContent());

        $this->delete("/admin/leads/{$lead->id}")->assertRedirect('/admin/leads');
        $this->assertSame(0, Lead::count());
    }

    public function test_page_views_are_recorded_for_public_pages_only(): void
    {
        $this->get('/');
        $this->get('/calculators');
        $this->get('/sitemap.xml');

        $this->assertDatabaseCount('page_views', 2);
    }
}
