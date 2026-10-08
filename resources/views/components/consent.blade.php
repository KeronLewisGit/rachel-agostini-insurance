@props(['bag'])
@php($error = $errors->getBag($bag)->first('consent'))
<div>
    <label class="flex items-start gap-3 text-sm text-muted">
        <input type="checkbox" name="consent" value="1" class="mt-0.5 size-4 rounded border-line text-brand-600 focus:ring-brand-600" @checked(old('consent')) required>
        <span>I am happy for Rachel Agostini to contact me about Guardian Group products. Details are handled as described in the <a href="{{ route('privacy') }}" class="link">privacy note</a>.</span>
    </label>
    @if ($error)
        <p class="field-error">{{ $error }}</p>
    @endif
</div>
<div class="hidden" aria-hidden="true">
    <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
</div>
