@props(['name', 'label', 'value' => null, 'required' => false])

<div>
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-semibold text-espresso">
        {{ $label }}@if ($required)<span class="text-mahogany" aria-hidden="true"> *</span>@endif
    </label>
    <input id="{{ $name }}" type="datetime-local" name="{{ $name }}" value="{{ old($name, $value?->format('Y-m-d\TH:i')) }}"
           @required($required)
           {{ $attributes->class(['min-h-12 w-full rounded-xl border bg-white px-4 py-3 focus:border-mahogany focus:outline-none focus:ring-2 focus:ring-mahogany/30',
                                  'border-espresso/20' => ! $errors->has($name), 'border-red-600' => $errors->has($name)]) }}>
    @error($name)<p class="mt-1.5 text-sm text-red-700">{{ $message }}</p>@enderror
</div>