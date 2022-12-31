<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">


    @foreach ($pages as $page)

        @switch( $page['type'] )
            @case('page')
            @case('tool')
            @case('contact')
            @case('report')

                 @foreach($page['translations'] as $key => $value)
                     <url>
                        <loc>{{ localization()->getLocalizedURL($value['locale'], route('home') . '/' . $page['slug'], [], false) }}</loc>
                        <lastmod>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::parse($page['updated_at']))->tz('UTC')->toAtomString() }}</lastmod>
                        <priority>1.00</priority>
                    </url>
                 @endforeach

            @break

            @case('post')

                 @foreach($page['translations'] as $key => $value)
                     <url>
                        <loc>{{ localization()->getLocalizedURL($value['locale'], route('home') . '/blog/' . $page['slug'], [], false) }}</loc>
                        <lastmod>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::parse($page['updated_at']))->tz('UTC')->toAtomString() }}</lastmod>
                        <priority>1.00</priority>
                    </url>
                 @endforeach

            @break

            @case('home')

                 @foreach($page['translations'] as $key => $value)
                     <url>
                        <loc>{{ localization()->getLocalizedURL($value['locale'], route('home'), [], false) }}</loc>
                        <lastmod>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::parse($page['updated_at']))->tz('UTC')->toAtomString() }}</lastmod>
                        <priority>1.00</priority>
                    </url>
                 @endforeach

            @break

            @default
        @endswitch

    @endforeach
</urlset>