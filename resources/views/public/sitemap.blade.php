<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($staticRoutes as $route)
        <url>
            <loc>{{ $route['url'] }}</loc>
            <changefreq>weekly</changefreq>
            <priority>{{ $route['priority'] }}</priority>
        </url>
    @endforeach
    @foreach ($news as $item)
        <url>
            <loc>{{ route('berita.show', $item->slug) }}</loc>
            <lastmod>{{ $item->updated_at?->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
