@props(['name', 'label', 'required' => false, 'rows' => 5, 'value' => null])

<div>
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-semibold text-espresso">
        {{ $label }}@if ($required)<span class="text-mahogany" aria-hidden="true"> *</span>@endif
    </label>
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" @required($required)
              @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
              {{ $attributes->class(['w-full rounded-xl border bg-white px-4 py-3 text-base text-ink placeholder:text-ink/40 focus:border-mahogany focus:outline-none focus:ring-2 focus:ring-mahogany/30',
                                     'border-espresso/20' => ! $errors->has($name), 'border-red-600' => $errors->has($name)]) }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <p id="{{ $name }}-error" class="mt-1.5 text-sm text-red-700">{{ $message }}</p>
    @enderror
</div>