{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach ($urls as $url)
    <url>
        <loc>{{ $url['loc'] }}</loc>
        <changefreq>weekly</changefreq>
        @foreach ($urls as $alternate)
            <xhtml:link rel="alternate" hreflang="{{ $alternate['hreflang'] }}" href="{{ $alternate['loc'] }}" />
        @endforeach
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $urls->firstWhere('default', true)['loc'] ?? url('/') }}" />
    </url>
@endforeach
</urlset>
