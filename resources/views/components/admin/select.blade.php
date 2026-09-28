@props(['name', 'label', 'options' => [], 'value' => null, 'placeholder' => null, 'required' => false])

<div>
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-semibold text-espresso">
        {{ $label }}@if ($required)<span class="text-mahogany" aria-hidden="true"> *</span>@endif
    </label>
    <select id="{{ $name }}" name="{{ $name }}" @required($required)
            @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
            {{ $attributes->class(['min-h-12 w-full rounded-xl border bg-white px-3 text-base focus:border-mahogany focus:outline-none focus:ring-2 focus:ring-mahogany/30',
                                   'border-espresso/20' => ! $errors->has($name), 'border-red-600' => $errors->has($name)]) }}>
        @if ($placeholder)<option value="">{{ $placeholder }}</option>@endif
        @foreach ($options as $key => $text)
            <option value="{{ $key }}" @selected((string) old($name, $value) === (string) $key)>{{ $text }}</option>
        @endforeach
    </select>
    @error($name)<p id="{{ $name }}-error" class="mt-1.5 text-sm text-red-700">{{ $message }}</p>@enderror
</div>