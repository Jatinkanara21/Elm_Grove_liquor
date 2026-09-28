@props(['name', 'label', 'value' => null])

<div>
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-semibold text-espresso">{{ $label }}</label>
    <div class="flex gap-3">
        <input id="{{ $name }}" type="color" name="{{ $name }}" value="{{ old($name, $value ?? '#8B4513') }}"
               class="size-12 cursor-pointer rounded-xl border border-espresso/20">
        <input type="text" value="{{ old($name, $value ?? '#8B4513') }}"
               placeholder="#8B4513"
               class="flex-1 rounded-xl border border-espresso/20 bg-white px-3 text-sm"
               readonly>
    </div>
    @error($name)<p class="mt-1.5 text-sm text-red-700">{{ $message }}</p>@enderror
</div>