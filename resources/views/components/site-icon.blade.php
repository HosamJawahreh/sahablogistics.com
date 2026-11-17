@props(['name' => 'check'])
@php
    $map = [
        'map-pin' => 'coverage',
        'location' => 'location',
        'ship' => 'port',
        'tag' => 'pricing',
        'shield' => 'reliable',
        'arrows' => 'two-way',
        'truck' => 'truck',
        'eye' => 'eye',
        'target' => 'target',
        'clipboard' => 'clipboard',
        'cog' => 'route',
        'flag' => 'check',
        'check' => 'check',
        'check-mark' => 'check-mark',
        'chat' => 'user',
        'quote' => 'quote',
        'phone' => 'phone',
        'mail' => 'email',
        'cpu' => 'building',
        'globe' => 'globe',
        'play' => 'play',
        'route' => 'route',
        'clipboard' => 'clipboard',
        'two-way' => 'two-way',
        'pricing' => 'pricing',
        'layers' => 'layers',
        'coverage' => 'coverage',
        'port' => 'port',
        'reliable' => 'reliable',
        'send' => 'send',
        'user' => 'user',
        'email' => 'email',
        'external-link' => 'external-link',
    ];
    $id = $map[$name] ?? 'check';
@endphp
<svg {{ $attributes->merge(['class' => 'icon']) }} viewBox="0 0 24 24" aria-hidden="true">
    <use href="{{ asset('assets/icons/sprite.svg#'.$id) }}"></use>
</svg>
