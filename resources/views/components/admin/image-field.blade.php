@props(['name' => 'image', 'label' => 'Image', 'current' => null, 'hint' => 'JPG, PNG or WEBP. Max 5 MB.'])

<div>
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-semibold text-espresso">{{ $label }}</label>
    @if ($current)
        <img src="{{ asset('storage/' . $current) }}" alt="Current image" class="mb-3 h-24 rounded-xl object-cover">
    @endif
    <input id="{{ $name }}" type="file" name="{{ $name }}" accept="image/jpeg,image/png,image/webp"
           class="block w-full rounded-xl border border-espresso/20 bg-white text-sm file:mr-4 file:min-h-12 file:cursor-pointer file:border-0 file:bg-mahogany file:px-5 file:font-semibold file:text-cream hover:file:bg-espresso">
    <p class="mt-1.5 text-xs text-ink/60">{{ $hint }}@if ($current) Leave empty to keep the current image.@endif</p>
    @error($name)<p class="mt-1.5 text-sm text-red-700">{{ $message }}</p>@enderror
</div>