@props(['name' => 'check'])
@php
    $icons = [
        'map-pin' => '<path d="M12 21s7-6.2 7-11.2A7 7 0 0 0 5 9.8C5 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.4"/>',
        'ship' => '<path d="M4 17.5 12 8l8 9.5"/><path d="M3 20h18"/><path d="M7 11V8h3"/><path d="M14 8h3v3"/>',
        'tag' => '<path d="M20 13.2 12.7 5.9A2 2 0 0 0 11.3 5H5v6.3a2 2 0 0 0 .6 1.4L13.2 20a2 2 0 0 0 2.8 0L20 16a2 2 0 0 0 0-2.8Z"/><circle cx="8.2" cy="8.2" r=".8"/>',
        'shield' => '<path d="M12 3 5 6v6c0 4.5 3 7.4 7 9 4-1.6 7-4.5 7-9V6l-7-3Z"/>',
        'cpu' => '<rect x="7" y="7" width="10" height="10" rx="2"/><path d="M9 3v4M15 3v4M9 17v4M15 17v4M3 9h4M3 15h4M17 9h4M17 15h4"/>',
        'leaf' => '<path d="M5 19c8 0 14-8 14-14-6 0-14 6-14 14Z"/><path d="M9 15c2-2 5-4 9-5"/>',
        'heart' => '<path d="M12 20s-7-4.4-9-8.7C1.4 7.8 4 4.8 7.2 5.2 9 5.4 10.4 6.5 12 8c1.6-1.5 3-2.6 4.8-2.8C20 4.8 22.6 7.8 21 11.3 19 15.6 12 20 12 20Z"/>',
        'arrows' => '<path d="M7 8h13M16 4l4 4-4 4M17 16H4M8 12l-4 4 4 4"/>',
        'truck' => '<path d="M3 7h11v10H3z"/><path d="M14 10h5l2 3v4h-7"/><circle cx="7.5" cy="18" r="1.7"/><circle cx="17" cy="18" r="1.7"/>',
        'chat' => '<path d="M5 6h14v10H8l-3 3V6Z"/>',
        'clipboard' => '<rect x="7" y="5" width="10" height="14" rx="2"/><path d="M9 5.5h6V4h-6z"/><path d="M9 10h6M9 13h6"/>',
        'cog' => '<circle cx="12" cy="12" r="3"/><path d="M19 12a7 7 0 0 0-.2-1.5l2-1.2-2-3.4-2.2.8A7 7 0 0 0 15 5.4L14.6 3h-5.2L9 5.4A7 7 0 0 0 7.4 7l-2.2-.8-2 3.4 2 1.2A7 7 0 0 0 5 12c0 .5.1 1 .2 1.5l-2 1.2 2 3.4 2.2-.8A7 7 0 0 0 9 18.6l.4 2.4h5.2l.4-2.4a7 7 0 0 0 1.6-1.2l2.2.8 2-3.4-2-1.2c.1-.5.2-1 .2-1.6Z"/>',
        'flag' => '<path d="M6 4v16"/><path d="M6 5h11l-2 3 2 3H6"/>',
        'eye' => '<path d="M2.5 12S6 6.5 12 6.5 21.5 12 21.5 12 18 17.5 12 17.5 2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="2.6"/>',
        'target' => '<circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="4"/><path d="M12 4v2M12 18v2M4 12h2M18 12h2"/>',
        'globe' => '<circle cx="12" cy="12" r="8"/><path d="M4 12h16M12 4c2.5 2.8 3.8 5.5 3.8 8S14.5 17.2 12 20c-2.5-2.8-3.8-5.5-3.8-8S9.5 6.8 12 4Z"/>',
        'check' => '<path d="M5 13.2 9.2 17 19 7"/>',
        'quote' => '<path d="M8 17H4l2-8h4L8 17Zm10 0h-4l2-8h4l-2 8Z"/>',
        'phone' => '<path d="M7 3h4l1 4-2.2 1.4a12 12 0 0 0 5.8 5.8L17.2 12l4 1v4a2 2 0 0 1-2.2 2A16 16 0 0 1 5 6.2 2 2 0 0 1 7 3Z"/>',
        'mail' => '<rect x="3.5" y="6" width="17" height="12" rx="2"/><path d="m4 7 8 6 8-6"/>',
        'location' => '<path d="M12 21s7-6.2 7-11.2A7 7 0 0 0 5 9.8C5 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.4"/>',
    ];
    $path = $icons[$name] ?? $icons['check'];
@endphp
<svg {{ $attributes->merge(['class' => 'icon', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'aria-hidden' => 'true']) }} stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
    {!! $path !!}
</svg>
