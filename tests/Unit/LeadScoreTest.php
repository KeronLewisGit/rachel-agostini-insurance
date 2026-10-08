<?php

namespace Tests\Unit;

use App\Models\Lead;
use PHPUnit\Framework\TestCase;

class LeadScoreTest extends TestCase
{
    public function test_hot_quote_scores_highest(): void
    {
        $this->assertSame(95, Lead::scoreFor('quote', 'employee-benefits', ['timeframe' => 'now']));
    }

    public function test_general_message_scores_lowest(): void
    {
        $this->assertSame(25, Lead::scoreFor('contact', null, []));
    }

    public function test_score_is_capped_at_one_hundred(): void
    {
        $this->assertSame(100, Lead::scoreFor('quote', 'business-insurance', ['timeframe' => 'now', 'preferred_contact' => 'whatsapp']));
    }
}
