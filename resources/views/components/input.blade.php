@props(['name', 'label', 'type' => 'text', 'required' => false, 'value' => null])

<div>
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-semibold text-espresso">
        {{ $label }}@if ($required)<span class="text-mahogany" aria-hidden="true"> *</span>@endif
    </label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}"
           @required($required)
           @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
           {{ $attributes->class(['min-h-12 w-full rounded-xl border bg-white px-4 py-3 text-base text-ink placeholder:text-ink/40 focus:border-mahogany focus:outline-none focus:ring-2 focus:ring-mahogany/30',
                                  'border-espresso/20' => ! $errors->has($name), 'border-red-600' => $errors->has($name)]) }}>
    @error($name)
        <p id="{{ $name }}-error" class="mt-1.5 text-sm text-red-700">{{ $message }}</p>
    @enderror
</div>