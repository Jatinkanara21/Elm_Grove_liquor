@props(['name', 'label', 'checked' => false, 'hint' => null])

<label class="flex min-h-11 cursor-pointer items-start gap-3">
    <input type="checkbox" name="{{ $name }}" value="1"
           @checked(session()->hasOldInput() ? old($name) : $checked)
           class="mt-1 size-5 rounded border-espresso/30 text-mahogany focus:ring-mahogany">
    <span>
        <span class="text-sm font-semibold text-espresso">{{ $label }}</span>
        @if ($hint)<span class="block text-xs text-ink/60">{{ $hint }}</span>@endif
    </span>
</label>