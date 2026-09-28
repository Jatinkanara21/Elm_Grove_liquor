@props(['rating' => 0, 'size' => 'text-lg'])

@php $r = (int) round($rating); @endphp

<span role="img" aria-label="{{ $r }} out of 5 stars"
      {{ $attributes->class(['inline-flex gap-0.5 leading-none', $size]) }}>
    @for ($i = 1; $i <= 5; $i++)
        <span aria-hidden="true" class="{{ $i <= $r ? 'text-gold' : 'text-[#D8C6A3]' }}">★</span>
    @endfor
</span>