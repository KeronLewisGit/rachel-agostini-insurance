/**
 * Insurance calculators. Pure functions first, Alpine wrappers second, so the
 * maths can be read (and checked) without the UI.
 *
 * All amounts are TT$. Assumptions arrive from config/calculators.php.
 */

const money = (n) => 'TT$' + Math.round(Math.max(0, n)).toLocaleString('en-TT');
const roundUp = (n, step) => Math.ceil(Math.max(0, n) / step) * step;

const futureValue = (principal, rate, years) => principal * Math.pow(1 + rate, years);

const futureValueOfMonthly = (monthly, rate, years) => {
    const r = rate / 12;
    const n = Math.round(years * 12);
    if (n <= 0) return 0;
    if (r === 0) return monthly * n;
    return monthly * ((Math.pow(1 + r, n) - 1) / r) * (1 + r);
};

const monthlyToReach = (target, rate, years) => {
    const r = rate / 12;
    const n = Math.round(years * 12);
    if (n <= 0 || target <= 0) return 0;
    if (r === 0) return target / n;
    return target / (((Math.pow(1 + r, n) - 1) / r) * (1 + r));
};

const monthlyIncomeFromPot = (pot, rate, years) => {
    const r = rate / 12;
    const n = years * 12;
    if (pot <= 0) return 0;
    if (r === 0) return pot / n;
    return (pot * r) / (1 - Math.pow(1 + r, -n));
};

/** Illustrative term-life rate per TT$1,000 of cover per year, by age band. */
const termRatePerThousand = (age, smoker) => {
    const base = age < 30 ? 1.2 : age < 40 ? 1.6 : age < 50 ? 3.0 : age < 60 ? 6.5 : 12;
    return base * (smoker ? 1.8 : 1);
};

export const compute = {
    'life-cover'(s, a) {
        const incomeNeed = s.income * 12 * s.years * (s.replacement / 100);
        const education = s.dependants * s.educationPerChild;
        const need = incomeNeed + s.debts + a.funeral_cost + education;
        const offsets = s.savings + s.existingCover;
        const gap = roundUp(need - offsets, 25000);
        const yearly = (gap / 1000) * termRatePerThousand(s.age, s.smoker === 'yes');
        return {
            incomeNeed,
            education,
            finalExpenses: a.funeral_cost,
            totalNeed: need,
            offsets,
            recommendedCover: gap,
            premiumLow: (yearly / 12) * 0.8,
            premiumHigh: (yearly / 12) * 1.2,
            breakdown: [
                ['Income replacement', incomeNeed],
                ['Debts cleared', s.debts],
                ['Education', education],
                ['Final expenses', a.funeral_cost],
            ],
        };
    },

    'critical-illness'(s) {
        const incomeLoss = s.income * s.monthsOff;
        const housing = s.housing * s.monthsOff;
        const total = incomeLoss + housing + s.treatment;
        const gap = roundUp(total - s.savings, 25000);
        return {
            incomeLoss,
            housing,
            treatment: s.treatment,
            totalNeed: total,
            recommendedCover: gap,
            breakdown: [
                ['Income while off work', incomeLoss],
                ['Mortgage or rent', housing],
                ['Treatment and travel', s.treatment],
            ],
        };
    },

    retirement(s, a) {
        const rate = a['growth_' + s.growth];
        const years = Math.max(0, s.retireAge - s.age);
        const fromSavings = futureValue(s.savings, rate, years);
        const fromContributions = futureValueOfMonthly(s.monthly, rate, years);
        const pot = fromSavings + fromContributions;
        const income = monthlyIncomeFromPot(pot, a.growth_conservative, 25);
        const potToday = pot / Math.pow(1 + a.inflation, years);
        const incomeToday = income / Math.pow(1 + a.inflation, years);
        const deductible = Math.min(s.monthly * 12, a.annuity_deduction_limit);
        const taxable = Math.max(0, s.annualIncome - 90000);
        const taxSaving = Math.min(deductible, taxable) * a.tax_rate;
        const target = s.targetIncome * Math.pow(1 + a.inflation, years);
        const targetPot = target * 12 * 25 * 0.72;
        const shortfallMonthly = Math.max(0, monthlyToReach(Math.max(0, targetPot - fromSavings), rate, years) - s.monthly);
        return {
            years,
            pot,
            fromSavings,
            fromContributions,
            monthlyIncome: income,
            potToday,
            incomeToday,
            taxSaving,
            netMonthlyCost: s.monthly - taxSaving / 12,
            targetIncomeFuture: target,
            extraMonthlyNeeded: shortfallMonthly,
            onTrack: shortfallMonthly <= 0,
        };
    },

    education(s, a) {
        const rate = a['growth_' + s.growth];
        const costToday = a['education_cost_' + s.option];
        const yearsUntil = Math.max(0, s.startAge - s.childAge);
        const annualFuture = costToday * Math.pow(1 + a.inflation, yearsUntil);
        const total = annualFuture * s.courseYears;
        const savingsFuture = futureValue(s.savings, rate, yearsUntil);
        const needed = Math.max(0, total - savingsFuture);
        return {
            yearsUntil,
            costToday,
            annualFuture,
            totalCost: total,
            savingsFuture,
            needed,
            monthly: monthlyToReach(needed, rate, yearsUntil),
            lumpSumToday: needed / Math.pow(1 + rate, yearsUntil),
        };
    },
};

export const defaults = {
    'life-cover': { age: 35, smoker: 'no', income: 12000, replacement: 70, years: 15, debts: 350000, dependants: 2, educationPerChild: 90000, savings: 60000, existingCover: 0 },
    'critical-illness': { income: 12000, monthsOff: 12, housing: 5500, treatment: 150000, savings: 30000 },
    retirement: { age: 35, retireAge: 60, savings: 50000, monthly: 1500, growth: 'balanced', annualIncome: 180000, targetIncome: 9000 },
    education: { childAge: 3, startAge: 18, option: 'regional', courseYears: 3, growth: 'balanced', savings: 10000 },
};

export function registerCalculators(Alpine) {
    Alpine.data('calculator', (slug, assumptions) => ({
        slug,
        a: assumptions,
        s: { ...defaults[slug] },
        money,
        get r() {
            return compute[slug](this.s, this.a);
        },
        reset() {
            this.s = { ...defaults[slug] };
        },
        pct(part, whole) {
            return whole > 0 ? Math.max(2, Math.round((part / whole) * 100)) : 0;
        },
        get inputsJson() {
            return JSON.stringify(this.s);
        },
        get resultsJson() {
            const out = {};
            Object.entries(this.r).forEach(([k, v]) => {
                if (typeof v === 'number') out[k] = Math.round(v);
                else if (typeof v === 'boolean' || typeof v === 'string') out[k] = v;
            });
            return JSON.stringify(out);
        },
    }));
}
