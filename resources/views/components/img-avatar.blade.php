@props([
'src',
'alt' => 'img-avatar',
'w' => 16,
'h' => null,
])

<img src="{{ $src }}" alt="{{ $alt }}" class="
        w-{{ $w }}
        h-{{ $h ?? $w }}
        rounded-full
        border
        object-cover
        transition
        duration-200
        ease-in-out
        hover:scale-110
    " />