@props(['products', 'preselected' => null, 'compact' => false])
@php
    $budgets = ['under-300' => 'Under TT$300 a month', '300-600' => 'TT$300 to 600', '600-1200' => 'TT$600 to 1,200', '1200-plus' => 'Over TT$1,200', 'unsure' => 'Not sure yet'];
    $timeframes = ['now' => 'As soon as possible', 'month' => 'Within a month', 'quarter' => 'In the next three months', 'exploring' => 'Just exploring'];
    $existing = ['none' => 'No cover yet', 'some' => 'Some cover, want more', 'reviewing' => 'Reviewing what I have'];
@endphp
<div id="form-quote" {{ $attributes }}>
    <x-form-status type="quote" title="Quote request received." message="Rachel will prepare real Guardian premiums and send them to you within one working day." />
    <form method="POST" action="{{ route('leads.store', 'quote') }}" class="space-y-5">
        @csrf
        @if ($compact)
            <x-field name="product" label="Cover you need" type="select" bag="quote" :options="$products" :value="$preselected" placeholder="Choose a product" required />
        @else
            <fieldset>
                <legend class="label">What would you like a quote for? <span class="text-gold-600" aria-hidden="true">*</span></legend>
                <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($products as $slug => $name)
                        <label class="option">
                            <input type="radio" name="product" value="{{ $slug }}" class="peer sr-only" @checked(old('product', $preselected) === $slug)>
                            <span><x-icon :name="config('products.items.'.$slug.'.icon')" class="size-4 text-brand-700" /> {{ $name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('product', 'quote')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </fieldset>
        @endif
        <div class="grid gap-4 sm:grid-cols-2">
            <x-field name="name" label="Your name" bag="quote" required autocomplete="name" />
            <x-field name="phone" label="Phone or WhatsApp" type="tel" bag="quote" required autocomplete="tel" placeholder="(868) 000-0000" />
            <x-field name="email" label="Email" type="email" bag="quote" autocomplete="email" hint="Optional, for the written summary." />
            <x-field name="preferred_contact" label="Reach me by" type="select" bag="quote" :options="['whatsapp' => 'WhatsApp', 'phone' => 'Phone call', 'email' => 'Email']" value="whatsapp" />
        </div>
        <div class="grid gap-4 sm:grid-cols-2 {{ $compact ? '' : 'lg:grid-cols-3' }}">
            <x-field name="age" label="Your age" type="number" bag="quote" min="16" max="90" inputmode="numeric" />
            <x-field name="dependants" label="People who depend on you" type="number" bag="quote" min="0" max="20" inputmode="numeric" />
            <x-field name="smoker" label="Do you smoke?" type="select" bag="quote" :options="['no' => 'No', 'yes' => 'Yes']" />
            <x-field name="budget" label="Monthly budget" type="select" bag="quote" :options="$budgets" placeholder="Choose" />
            <x-field name="timeframe" label="When do you want cover in place?" type="select" bag="quote" :options="$timeframes" placeholder="Choose" />
            <x-field name="existing_cover" label="Existing cover" type="select" bag="quote" :options="$existing" placeholder="Choose" />
        </div>
        <x-field name="message" label="Anything Rachel should know?" type="textarea" bag="quote" placeholder="Health, travel plans, a mortgage, a business, a deadline…" />
        <x-consent bag="quote" />
        <button class="btn btn-primary w-full sm:w-auto">Send my quote request <x-icon name="arrow-right" class="size-4" /></button>
    </form>
</div>
