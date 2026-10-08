<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Lead> */
class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['quote', 'quote', 'calculator', 'callback', 'contact']);
        $product = $this->faker->randomElement(array_keys(config('products.items')));
        $sources = [
            ['utm_source' => 'instagram', 'utm_medium' => 'social', 'utm_campaign' => 'past-pink', 'referrer_host' => 'l.instagram.com'],
            ['utm_source' => 'instagram', 'utm_medium' => 'bio', 'utm_campaign' => '', 'referrer_host' => 'l.instagram.com'],
            ['utm_source' => 'whatsapp', 'utm_medium' => 'share', 'utm_campaign' => '', 'referrer_host' => null],
            ['utm_source' => '', 'utm_medium' => '', 'utm_campaign' => '', 'referrer_host' => 'www.google.com'],
            ['utm_source' => '', 'utm_medium' => '', 'utm_campaign' => '', 'referrer_host' => null],
            ['utm_source' => 'facebook', 'utm_medium' => 'social', 'utm_campaign' => 'annuity-tax', 'referrer_host' => 'm.facebook.com'],
        ];
        $data = ['timeframe' => $this->faker->randomElement(['now', 'month', 'quarter', 'exploring'])];

        if ($type === 'quote') {
            $data += ['age' => $this->faker->numberBetween(24, 58), 'dependants' => $this->faker->numberBetween(0, 4), 'budget' => $this->faker->randomElement(['under-300', '300-600', '600-1200', 'unsure'])];
        }

        return [
            'type' => $type,
            'status' => $this->faker->randomElement(['new', 'new', 'contacted', 'quoted', 'won', 'lost']),
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone' => '(868) '.$this->faker->numberBetween(290, 799).'-'.$this->faker->numberBetween(1000, 9999),
            'preferred_contact' => $this->faker->randomElement(['whatsapp', 'whatsapp', 'phone', 'email']),
            'product' => $type === 'contact' ? null : $product,
            'summary' => config("products.items.{$product}.name").' enquiry',
            'message' => $this->faker->optional(0.4)->sentence(14),
            'data' => $data,
            'source' => array_merge($this->faker->randomElement($sources), ['landing_page' => '/', 'pages_viewed' => $this->faker->numberBetween(1, 7), 'device' => $this->faker->randomElement(['mobile', 'mobile', 'desktop'])]),
            'score' => Lead::scoreFor($type, $type === 'contact' ? null : $product, $data),
            'is_sample' => true,
            'created_at' => $this->faker->dateTimeBetween('-45 days', 'now'),
        ];
    }
}
