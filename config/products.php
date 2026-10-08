<?php

/*
|--------------------------------------------------------------------------
| Products Rachel arranges
|--------------------------------------------------------------------------
| Drawn from the Trinidad and Tobago product pages on myguardiangroup.com.
| Motor, cyber and home insurance are deliberately left out. Plan names are
| Guardian's; the "fit" lines are Rachel's positioning for each line.
*/

return [

    'groups' => [
        'protect' => ['name' => 'Protect', 'blurb' => 'Cover for the people and income that depend on you.'],
        'grow' => ['name' => 'Grow', 'blurb' => 'Save and invest for retirement, education and the long term.'],
        'business' => ['name' => 'Business & lifestyle', 'blurb' => 'Guardian General covers Rachel can also arrange through Guardian Group, for companies, travellers and boat owners.'],
    ],

    'items' => [

        'life-insurance' => [
            'name' => 'Life Insurance',
            'group' => 'protect',
            'company' => 'Guardian Life of the Caribbean',
            'icon' => 'heart-handshake',
            'eyebrow' => 'Whole life and term',
            'summary' => 'A monetary safety net that lets your family keep their home and lifestyle if you are no longer there to provide.',
            'fit' => 'Parents, new homeowners, business partners and anyone with people who rely on their income.',
            'intro' => [
                'A life insurance policy is a critical part of prudent financial planning. In the event of your death, life insurance provides a monetary safety net for your family, enabling them to maintain their lifestyle in a dignified manner.',
                'Guardian Life offers whole life policies, which cover you for the whole of your life and build cash value, and term policies, which cover a fixed period at a lower premium and can be renewed. Rachel will show you both, priced for your age and health, so you can see the trade-off clearly.',
            ],
            'plans' => [
                ['name' => 'Xpress Life', 'blurb' => 'Simplified-issue life cover with a fast application and limited medical questions, for people who want protection in place quickly.'],
                ['name' => 'Life Evolution Series', 'blurb' => 'Flexible whole life cover with investment-linked cash value and optional riders, built to evolve as your responsibilities change.'],
                ['name' => 'Term Life', 'blurb' => 'High cover for a fixed term at the lowest cost, ideal for mortgages, young families and key-person protection.'],
            ],
            'benefits' => [
                'Lump sum paid to the people you choose, outside of probate delays',
                'Whole life options that build cash value you can borrow against',
                'Critical illness and waiver-of-premium riders available',
                'Premiums fixed at entry age, so starting younger costs less for life',
            ],
            'calculator' => 'life-cover',
            'seo' => [
                'title' => 'Life Insurance in Trinidad & Tobago with Rachel Agostini, Guardian Life',
                'description' => 'Whole life, term and Life Evolution policies from Guardian Life of the Caribbean, arranged by Rachel Agostini. Use the free life cover calculator and request a same-day quote.',
            ],
        ],

        'critical-illness' => [
            'name' => 'Critical Illness Cover',
            'group' => 'protect',
            'company' => 'Guardian Life of the Caribbean',
            'icon' => 'heart-pulse',
            'eyebrow' => 'The Phoenix Plan',
            'summary' => 'A tax-free lump sum paid directly to you on diagnosis of cancer, stroke, heart attack and other major illnesses, so you can focus on recovery.',
            'fit' => 'Anyone whose income would stop if they fell seriously ill, especially the self-employed.',
            'intro' => [
                'Critical illness insurance provides financial support following the diagnosis of a covered critical illness, like a heart attack, cancer or stroke. The lump sum benefit is paid to you, not to a hospital, so you decide how to use it: treatment overseas, replacing lost income, clearing a mortgage or paying for help at home.',
                'Rachel describes it as a living benefit. Life insurance looks after the people you leave behind; critical illness cover looks after you while you are still here. The two work best together.',
            ],
            'plans' => [
                ['name' => 'Phoenix Plan', 'blurb' => 'Guardian Life\'s standalone critical illness plan. Cover available up to age 80, with the benefit paid directly to you on diagnosis of a covered condition.'],
                ['name' => 'Critical illness rider', 'blurb' => 'Add critical illness cover to a Life Evolution or term policy for a single, simpler premium.'],
            ],
            'benefits' => [
                'Pays you directly, tax free, on diagnosis of a covered illness',
                'Cover available up to age 80',
                'Protects your income while you recover, independent of health insurance',
                'No restriction on how the money is spent',
            ],
            'calculator' => 'critical-illness',
            'seo' => [
                'title' => 'Critical Illness Insurance Trinidad: Guardian Phoenix Plan with Rachel Agostini',
                'description' => 'Guardian Life Phoenix Plan critical illness cover arranged by Rachel Agostini. A tax-free lump sum on diagnosis of cancer, stroke, heart attack and more. Calculate how much cover you need.',
            ],
        ],

        'health-insurance' => [
            'name' => 'Health Insurance',
            'group' => 'protect',
            'company' => 'Guardian Life of the Caribbean',
            'icon' => 'stethoscope',
            'eyebrow' => 'LifeCare and Global Care',
            'summary' => 'Individual and family health plans that make the highest standard of medical care accessible, at home and abroad.',
            'fit' => 'Families, self-employed professionals and anyone without employer health cover.',
            'intro' => [
                'Everyone gets sick, but some times are worse than others. Guardian Life designed the LifeCare and Rejuvenator Living Assurance plans so that at those times you can focus on recovery, not bills.',
                'Plans range from local hospitalisation and doctor visits to Global Care, which extends cover to treatment overseas. Claims can be submitted digitally through Guardian\'s easiClaim service.',
            ],
            'plans' => [
                ['name' => 'LifeCare Plans', 'blurb' => 'Individual and family medical plans covering hospitalisation, surgery, doctor visits, diagnostics and prescriptions.'],
                ['name' => 'Global Care', 'blurb' => 'International medical cover for treatment outside Trinidad and Tobago, including specialist and tertiary care.'],
                ['name' => 'Rejuvenator Living Assurance', 'blurb' => 'Living assurance that supports recovery costs and wellbeing after serious illness.'],
            ],
            'benefits' => [
                'Access to Guardian\'s network of preferred providers',
                'Options for overseas treatment through Global Care',
                'Digital claims with easiClaim and easiConnect',
                'Cover for spouse and children on one plan',
            ],
            'calculator' => null,
            'seo' => [
                'title' => 'Health Insurance Trinidad & Tobago: Guardian LifeCare Plans via Rachel Agostini',
                'description' => 'Guardian Life LifeCare and Global Care health plans for individuals and families in Trinidad and Tobago, arranged by Rachel Agostini. Compare options and request a quote.',
            ],
        ],

        'personal-accident' => [
            'name' => 'Personal Accident',
            'group' => 'protect',
            'company' => 'Guardian Life of the Caribbean',
            'icon' => 'bandage',
            'eyebrow' => 'Praesidia',
            'summary' => 'Income protection if an accident or illness stops you working, for a few weeks or for good.',
            'fit' => 'Tradespeople, drivers, contractors and anyone paid only when they show up.',
            'intro' => [
                'Accidents can happen at any time and can significantly affect the quality of life that people enjoy. How would you pay your bills and look after your family if you could not work because you were badly injured?',
                'Praesidia, Guardian Life\'s personal accident product, gives prime protection in the event of a serious incident, accident or illness, which may result in loss of income temporarily or for a longer period of time.',
            ],
            'plans' => [
                ['name' => 'Praesidia', 'blurb' => 'Benefits for accidental death, permanent and temporary disablement, and medical expenses following an accident.'],
            ],
            'benefits' => [
                'Weekly benefit while you are unable to work',
                'Lump sum for permanent disablement',
                'Accidental medical expense reimbursement',
                'Simple application with no medical exam for most ages',
            ],
            'calculator' => null,
            'seo' => [
                'title' => 'Personal Accident Insurance Trinidad: Guardian Praesidia with Rachel Agostini',
                'description' => 'Guardian Life Praesidia personal accident cover arranged by Rachel Agostini. Protect your income against accidents and disablement in Trinidad and Tobago.',
            ],
        ],

        'pensions-annuities' => [
            'name' => 'Pensions & Annuities',
            'group' => 'grow',
            'company' => 'Guardian Life of the Caribbean',
            'icon' => 'piggy-bank',
            'eyebrow' => 'Lifestyle Pensions and registered annuities',
            'summary' => 'Registered annuity and pension plans that keep the lifestyle you have earned after work, with contributions that reduce your income tax today.',
            'fit' => 'Anyone from their first job to their fifties who wants a tax break now and an income later.',
            'intro' => [
                'Do you remember your first job? The hours were long and the money was not all you had dreamed of, but you kept at it. Guardian Life annuities and pension plans allow you to live the lifestyle you have become accustomed to, even after you have retired, without sacrifices that affect your current quality of life.',
                'Contributions to approved annuities are deductible against income tax in Trinidad and Tobago within the statutory limit, which makes a registered annuity one of the few savings plans that pays you back every year on the way in.',
            ],
            'plans' => [
                ['name' => 'Lifestyle Pensions', 'blurb' => 'Flexible, investment-linked deferred annuities (Lifestyle Privilege 10 and 20) that fund a pension starting at any age from 52 to 70.'],
                ['name' => 'Individual Personal Investor', 'blurb' => 'A US-dollar plan that protects you from local market volatility and builds savings in a globally accepted currency.'],
                ['name' => 'Top Hat Pensions', 'blurb' => 'Employer-sponsored pensions for executives, with retirement between ages 50 and 70.'],
                ['name' => 'Group Pensions', 'blurb' => 'Company pension schemes designed to help employees plan for early retirement.'],
            ],
            'benefits' => [
                'Tax-deductible contributions within the Board of Inland Revenue limit',
                'Choose your retirement age between 52 and 70',
                'TT-dollar and US-dollar options',
                'Guaranteed income options at retirement',
            ],
            'calculator' => 'retirement',
            'seo' => [
                'title' => 'Pension & Annuity Plans Trinidad: Tax-Deductible Guardian Life Plans via Rachel Agostini',
                'description' => 'Guardian Life Lifestyle Pensions and registered annuities arranged by Rachel Agostini. Reduce your income tax and build a retirement income in Trinidad and Tobago. Try the retirement calculator.',
            ],
        ],

        'education-savings' => [
            'name' => 'Education Savings',
            'group' => 'grow',
            'company' => 'Guardian Life of the Caribbean',
            'icon' => 'graduation-cap',
            'eyebrow' => 'Student Opportunity Saver and LEAP',
            'summary' => 'Give your child a financial head start with a plan that is funded even if something happens to you.',
            'fit' => 'Parents and grandparents planning for secondary school, university or study abroad.',
            'intro' => [
                'Starting a family is a thrilling time, and making preparations can be just as exciting, including both short-term and long-term arrangements. Parents who value education and want to give their child a financial and academic head start want to prepare for all possible opportunities.',
                'An education plan combines disciplined saving with insurance: if the parent dies or is disabled, the plan continues to be funded so the child\'s education is still paid for.',
            ],
            'plans' => [
                ['name' => 'Student Opportunity Saver', 'blurb' => 'Guardian Life\'s education savings plan with built-in life cover on the parent.'],
                ['name' => 'LEAP, Legacy Education Achievement Plan', 'blurb' => 'Guardian Asset Management\'s investment-based education plan for families who want market growth.'],
            ],
            'benefits' => [
                'Plan continues to be funded if the parent dies or is disabled',
                'Flexible monthly contributions',
                'Choose the payout age to match secondary school or university',
                'TT$ and US$ options for study abroad',
            ],
            'calculator' => 'education',
            'seo' => [
                'title' => 'Education Savings Plans Trinidad: Student Opportunity Saver with Rachel Agostini',
                'description' => 'Guardian Life Student Opportunity Saver and LEAP education plans arranged by Rachel Agostini. Work out what university will cost with the education calculator.',
            ],
        ],

        'investments' => [
            'name' => 'Investments',
            'group' => 'grow',
            'company' => 'Guardian Asset Management',
            'icon' => 'trending-up',
            'eyebrow' => 'Mutual funds and private wealth',
            'summary' => 'Access local, regional and international markets through the Guardian Asset Management family of mutual funds, from TT$10,000.',
            'fit' => 'Savers ready to move beyond a bank account, and families building a legacy.',
            'intro' => [
                'The Guardian Asset Management series of mutual funds is a unique family of funds designed to exceed your performance expectations. The funds give you access to local, regional and international markets to help you build your optimal portfolio.',
                'With a minimum of TT$10,000 or US$1,500 you are on your way to a wide range of investment opportunities, and Rachel can pair a fund with your insurance plan so protection and growth are managed together.',
            ],
            'plans' => [
                ['name' => 'Mutual Funds', 'blurb' => 'TT$ and US$ income and growth funds managed by Guardian Asset Management.'],
                ['name' => 'Private Wealth Services', 'blurb' => 'Discretionary portfolio management for larger balances.'],
                ['name' => 'My Dream Home', 'blurb' => 'A structured savings plan towards a house deposit.'],
            ],
            'benefits' => [
                'Minimum investment of TT$10,000 or US$1,500',
                'Access to regional and international markets',
                'Regular contributions by salary deduction or standing order',
                'Online access through G Trade and Genius',
            ],
            'calculator' => null,
            'seo' => [
                'title' => 'Investments & Mutual Funds Trinidad: Guardian Asset Management via Rachel Agostini',
                'description' => 'Guardian Asset Management mutual funds and private wealth services arranged by Rachel Agostini. Start investing from TT$10,000 in Trinidad and Tobago.',
            ],
        ],

        'employee-benefits' => [
            'name' => 'Employee Benefits',
            'group' => 'business',
            'company' => 'Guardian Life of the Caribbean',
            'icon' => 'users',
            'eyebrow' => 'Group life, health and pensions',
            'summary' => 'Group life, health and pension packages that help you attract and keep the people your business depends on.',
            'fit' => 'Owners and HR managers of businesses with five or more staff.',
            'intro' => [
                'Most employers today, whether large organisations or small businesses, recognise the value of their human resources. The ability to attract and retain high quality employees requires organisations to recognise employees\' needs, not least through employee benefit packages.',
                'Guardian Life has crafted plans that are flexible and easily customised to meet the needs of you and your employees, and Rachel coordinates enrolment and renewals so HR does not have to.',
            ],
            'plans' => [
                ['name' => 'Group Life', 'blurb' => 'Life and accidental death cover for all staff, with no individual medicals for most groups.'],
                ['name' => 'Group Health', 'blurb' => 'Medical, dental and vision plans with Guardian\'s easiClaim service.'],
                ['name' => 'Group Pensions', 'blurb' => 'Defined contribution pension schemes with employer and employee contributions.'],
            ],
            'benefits' => [
                'Premiums are a deductible business expense',
                'Simple enrolment with minimal medical underwriting',
                'One renewal date and one point of contact',
                'Scales from five staff upwards',
            ],
            'calculator' => null,
            'seo' => [
                'title' => 'Employee Benefits Trinidad: Group Life, Health & Pensions with Rachel Agostini',
                'description' => 'Guardian Life group life, health and pension plans for Trinidad and Tobago businesses, arranged by Rachel Agostini. Request a group quote.',
            ],
        ],

        'business-insurance' => [
            'name' => 'Business Insurance',
            'group' => 'business',
            'company' => 'Guardian General Insurance',
            'icon' => 'building-2',
            'eyebrow' => 'FireGuard, liability, money and contract works',
            'summary' => 'Guardian General covers for fire, liability, cash in transit and contract works, so one bad day does not end the business.',
            'fit' => 'Shops, offices, contractors, restaurants and professional practices.',
            'intro' => [
                'Protecting your business interests is a critical part of what you do every day. Guardian General Insurance Limited can help protect you from business risks including fire, liability, contract works and more.',
                'Rachel reviews your premises, stock, staff and contracts, then packages the covers you actually need from Guardian General, the largest indigenous property and casualty insurer in the region.',
            ],
            'plans' => [
                ['name' => 'FireGuard® Insurance', 'blurb' => 'Buildings, contents and stock against fire, flood, hurricane and allied perils.'],
                ['name' => 'Liability Insurance', 'blurb' => 'Public and products liability for injury or damage to third parties.'],
                ['name' => 'Money Insurance', 'blurb' => 'Cash on premises, in transit and in safes.'],
                ['name' => 'Contract Works Insurance', 'blurb' => 'Cover for construction projects, materials and plant while work is under way.'],
            ],
            'benefits' => [
                'Underwritten by Guardian General Insurance Limited',
                'Claims submitted online through myGG',
                'Premium financing available for larger policies',
                'Annual review as the business grows',
            ],
            'calculator' => null,
            'seo' => [
                'title' => 'Business Insurance Trinidad: Guardian General FireGuard & Liability via Rachel Agostini',
                'description' => 'Guardian General Insurance business covers in Trinidad and Tobago arranged by Rachel Agostini: FireGuard, liability, money and contract works. Request a quote.',
            ],
        ],

        'travel-insurance' => [
            'name' => 'Travel Insurance',
            'group' => 'business',
            'company' => 'Guardian General Insurance',
            'icon' => 'plane',
            'eyebrow' => 'Single trip and annual',
            'summary' => 'Medical expenses, baggage, cancellation and personal accident cover for every trip, with medical cover up to age 75.',
            'fit' => 'Families on holiday, students going abroad and frequent business travellers.',
            'intro' => [
                'Guardian General travel insurance provides cover during your trip for baggage and personal effects, medical and other expenses including hospital fees and additional accommodation for someone who needs to stay with you, personal accident benefits, lost money and tickets, cancellation and loss of deposits, and compensation for hijacking.',
                'Rachel can issue cover for a single trip or for a year of travel, and most policies are confirmed the same day.',
            ],
            'plans' => [
                ['name' => 'Single Trip', 'blurb' => 'Cover for one journey, priced by destination and length of stay.'],
                ['name' => 'Annual Multi-Trip', 'blurb' => 'Unlimited trips in a year for frequent travellers, usually cheaper from the third trip.'],
            ],
            'benefits' => [
                'Medical and hospital expenses abroad (age limit 75)',
                'Baggage, money and travel documents',
                'Cancellation and loss of deposits',
                'Personal accident benefits from age 5 to 75',
            ],
            'calculator' => null,
            'seo' => [
                'title' => 'Travel Insurance Trinidad & Tobago: Guardian General Cover via Rachel Agostini',
                'description' => 'Guardian General travel insurance arranged by Rachel Agostini. Medical, baggage, cancellation and personal accident cover for travellers from Trinidad and Tobago, confirmed same day.',
            ],
        ],

        'marine-insurance' => [
            'name' => 'Marine Insurance',
            'group' => 'business',
            'company' => 'Guardian General Insurance',
            'icon' => 'sailboat',
            'eyebrow' => 'MarineGuard® yacht, pleasure craft and cargo',
            'summary' => 'Cover for your boat, its engines and your liability to others, plus marine cargo for goods in transit.',
            'fit' => 'Pleasure craft and fishing boat owners, and importers moving goods by sea or air.',
            'intro' => [
                'Your boat is one of your most prized possessions and should be properly protected against unforeseen circumstances. Guardian General\'s Yacht and Pleasure Craft Policy covers loss or damage to your boat, outboard motors and accessories from collision, fire, theft or sinking, and sums you become legally liable to pay for injury to others or damage to other vessels and property.',
                'Marine Cargo cover protects goods being transported to and from various countries by approved vessels or by air, warehouse to warehouse.',
            ],
            'plans' => [
                ['name' => 'MarineGuard® Yacht & Pleasure Craft', 'blurb' => 'Hull, machinery, accessories and third-party liability for private vessels.'],
                ['name' => 'Marine Cargo', 'blurb' => 'Warehouse-to-warehouse cover for imported and exported goods.'],
            ],
            'benefits' => [
                'Collision, fire, theft and sinking',
                'Third-party injury and property damage liability',
                'Outboard motors and accessories included',
                'Cargo cover by sea and air',
            ],
            'calculator' => null,
            'seo' => [
                'title' => 'Marine & Boat Insurance Trinidad: Guardian General MarineGuard via Rachel Agostini',
                'description' => 'Guardian General MarineGuard yacht, pleasure craft and marine cargo insurance arranged by Rachel Agostini in Trinidad and Tobago.',
            ],
        ],

        'pet-insurance' => [
            'name' => 'Pet Insurance',
            'group' => 'business',
            'company' => 'Guardian General Insurance',
            'icon' => 'paw-print',
            'eyebrow' => 'Pet Guard',
            'summary' => 'Guardian General\'s Pet Guard helps with vet bills for your dog or cat, in standard and premium packages.',
            'fit' => 'Dog and cat owners who would rather not choose between treatment and the bill.',
            'intro' => [
                'Pet Guard is Guardian General\'s insurance for dogs and cats. It reimburses eligible veterinary costs for accidents and illness, with standard and premium packages to suit different budgets.',
                'Rachel has promoted Pet Guard since its launch and can confirm eligibility, waiting periods and limits for your pet.',
            ],
            'plans' => [
                ['name' => 'Standard Package', 'blurb' => 'Core accident and illness cover with annual limits.'],
                ['name' => 'Premium Package', 'blurb' => 'Higher limits and broader cover for owners who want maximum protection.'],
            ],
            'benefits' => [
                'Covers dogs and cats',
                'Accident and illness veterinary costs',
                'Two package levels',
                'Underwritten by Guardian General',
            ],
            'calculator' => null,
            'seo' => [
                'title' => 'Pet Insurance Trinidad: Guardian General Pet Guard via Rachel Agostini',
                'description' => 'Guardian General Pet Guard insurance for dogs and cats in Trinidad and Tobago, arranged by Rachel Agostini.',
            ],
        ],
    ],

    // Lines Rachel does not write. Used to answer the question cleanly, not hide it.
    'excluded' => ['Motor', 'Cyber', 'Home'],
];
