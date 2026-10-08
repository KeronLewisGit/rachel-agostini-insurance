<?php

/*
|--------------------------------------------------------------------------
| Calculators
|--------------------------------------------------------------------------
| The maths lives in resources/js/calculators.js (Alpine components keyed by
| slug). Assumptions below are shown to visitors and sent with the lead so
| Rachel can see what the estimate was based on.
*/

return [

    'assumptions' => [
        'inflation' => 0.03,
        'growth_conservative' => 0.04,
        'growth_balanced' => 0.06,
        'growth_growth' => 0.08,
        'tax_rate' => 0.25,
        'annuity_deduction_limit' => 60000,
        'funeral_cost' => 45000,
        'education_cost_local' => 28000,
        'education_cost_regional' => 95000,
        'education_cost_abroad' => 220000,
    ],

    'items' => [
        'life-cover' => [
            'name' => 'Life Cover Calculator',
            'short' => 'How much life insurance do I need?',
            'icon' => 'heart-handshake',
            'product' => 'life-insurance',
            'summary' => 'Work out the lump sum your family would need to clear debts, replace your income and keep their plans on track.',
            'description' => 'Free life insurance calculator for Trinidad and Tobago. Enter your income, debts and dependants to see how much life cover your family would need, then send the estimate to Rachel Agostini for a Guardian Life quote.',
            'method' => 'Debts and final expenses, plus the income your household would need to replace until your youngest dependant is independent, plus education, less savings and existing cover.',
        ],
        'critical-illness' => [
            'name' => 'Critical Illness Calculator',
            'short' => 'How much would a serious illness cost me?',
            'icon' => 'heart-pulse',
            'product' => 'critical-illness',
            'summary' => 'Estimate the lump sum that would cover lost income, treatment and household costs while you recover.',
            'description' => 'Critical illness cover calculator for Trinidad and Tobago. Estimate the lump sum you would need for income, treatment and expenses during recovery, and request a Guardian Phoenix Plan quote from Rachel Agostini.',
            'method' => 'Months of income you want replaced, plus expected treatment and travel costs, plus mortgage or rent during recovery, less emergency savings.',
        ],
        'retirement' => [
            'name' => 'Retirement & Annuity Calculator',
            'short' => 'Will my pension be enough?',
            'icon' => 'piggy-bank',
            'product' => 'pensions-annuities',
            'summary' => 'Project your retirement pot, the monthly income it could pay, and the income tax a registered annuity could save you this year.',
            'description' => 'Retirement and annuity calculator for Trinidad and Tobago. Project your pension savings, monthly retirement income and the tax deduction from a Guardian Life registered annuity. Built by Rachel Agostini.',
            'method' => 'Current savings and monthly contributions grown at your chosen rate until retirement, converted to a 25-year monthly income. Tax saving is your contribution within the annual deduction limit multiplied by the 25% rate.',
        ],
        'education' => [
            'name' => 'Education Savings Calculator',
            'short' => 'What will university cost, and what should I save?',
            'icon' => 'graduation-cap',
            'product' => 'education-savings',
            'summary' => 'See the future cost of your child\'s education and the monthly saving that gets you there.',
            'description' => 'Education savings calculator for Trinidad and Tobago parents. Estimate the future cost of university locally, regionally or abroad and the monthly contribution needed. By Rachel Agostini, Guardian Life.',
            'method' => 'Today\'s annual cost for your chosen study option inflated to the year your child starts, multiplied by the course length, then solved for the monthly saving at your chosen growth rate.',
        ],
    ],
];
