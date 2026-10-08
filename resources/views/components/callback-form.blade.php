@props(['product' => null, 'dark' => false])
@php($times = ['morning' => 'Morning (8 to 11)', 'midday' => 'Midday (11 to 2)', 'afternoon' => 'Afternoon (2 to 5)', 'evening' => 'Evening (after 5)', 'saturday' => 'Saturday'])
<div id="form-callback" {{ $attributes }}>
    <x-form-status type="callback" title="Rachel will call you." message="Keep your phone handy at the time you chose." />
    <form method="POST" action="{{ route('leads.store', 'callback') }}" class="space-y-4">
        @csrf
        @if ($product)
            <input type="hidden" name="product" value="{{ $product }}">
        @endif
        <div class="grid gap-4 sm:grid-cols-2">
            <x-field name="name" label="Your name" bag="callback" required autocomplete="name" />
            <x-field name="phone" label="Phone or WhatsApp" type="tel" bag="callback" required autocomplete="tel" placeholder="(868) 000-0000" />
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <x-field name="best_time" label="Best time to call" type="select" bag="callback" :options="$times" placeholder="Any time" />
            <x-field name="preferred_contact" label="Reach me by" type="select" bag="callback" :options="['whatsapp' => 'WhatsApp', 'phone' => 'Phone call', 'email' => 'Email']" value="whatsapp" />
        </div>
        <x-consent bag="callback" />
        <button class="btn btn-gold w-full sm:w-auto">Request a call back <x-icon name="arrow-right" class="size-4" /></button>
    </form>
</div>
