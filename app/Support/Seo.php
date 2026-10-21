<?php

namespace App\Support;

use App\Models\Berita;
use App\Models\Jurusan;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Penyusun metadata SEO dan structured data (JSON-LD).
 *
 * Semua data dibersihkan dari nilai kosong agar schema.org tidak menerima
 * properti yang tidak valid. JSON di-encode dengan flag HEX_* sehingga aman
 * ditempatkan di dalam tag <script>.
 */
final class Seo
{
    public static function json(array $data): string
    {
        return json_encode(
            $data,
            JSON_UNESCAPED_SLASHES
            | JSON_UNESCAPED_UNICODE
            | JSON_HEX_TAG
            | JSON_HEX_AMP
            | JSON_HEX_APOS
            | JSON_HEX_QUOT
            | JSON_THROW_ON_ERROR,
        );
    }

    public static function imageUrl(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        if (Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        if (Str::startsWith($value, '/')) {
            return url($value);
        }

        return url(Storage::disk(config('filesystems.uploads_disk', 'public'))->url($value));
    }

    public static function organization(?SiteSetting $site): array
    {
        $name = self::schoolName($site);

        return self::clean([
            '@context' => 'https://schema.org',
            '@type' => 'EducationalOrganization',
            '@id' => self::organizationId(),
            'name' => $name,
            'url' => url('/'),
            'description' => $site?->meta_description,
            'logo' => self::imageUrl($site?->logo_path),
            'image' => self::imageUrl($site?->logo_path),
            'telephone' => self::confirmed($site?->phone),
            'email' => self::confirmed($site?->email),
            'sameAs' => array_map(fn (array $link) => $link['url'], $site?->socialLinks() ?? []),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $site?->address ?: config('school.fallback.address'),
                'addressCountry' => 'ID',
            ],
        ]);
    }

    public static function website(?SiteSetting $site): array
    {
        return self::clean([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/').'#website',
            'url' => url('/'),
            'name' => self::schoolName($site),
            'inLanguage' => 'id-ID',
            'publisher' => ['@id' => self::organizationId()],
        ]);
    }

    public static function webpage(string $name, ?string $description = null, ?string $url = null): array
    {
        return self::clean([
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => ($url ?: url()->current()).'#webpage',
            'url' => $url ?: url()->current(),
            'name' => $name,
            'description' => $description,
            'isPartOf' => ['@id' => url('/').'#website'],
            'inLanguage' => 'id-ID',
        ]);
    }

    public static function article(Berita $berita, ?SiteSetting $site): array
    {
        $url = route('berita.show', $berita->slug);
        $description = $berita->excerpt ?: Str::limit(strip_tags($berita->body), 160);
        $image = self::imageUrl($berita->image_path);

        return self::clean([
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $url],
            'headline' => $berita->title,
            'description' => $description,
            'image' => $image ? [$image] : null,
            'datePublished' => $berita->published_at?->toAtomString(),
            'dateModified' => $berita->updated_at?->toAtomString(),
            'author' => ['@type' => 'Organization', 'name' => self::schoolName($site), '@id' => self::organizationId()],
            'publisher' => ['@id' => self::organizationId()],
            'inLanguage' => 'id-ID',
            'url' => $url,
        ]);
    }

    public static function course(Jurusan $jurusan, ?SiteSetting $site): array
    {
        $description = $jurusan->ringkasan ?: Str::limit(strip_tags((string) $jurusan->deskripsi), 160);
        $image = self::imageUrl($jurusan->gambar);

        return self::clean([
            '@context' => 'https://schema.org',
            '@type' => 'Course',
            'name' => $jurusan->nama,
            'description' => $description,
            'url' => route('jurusan.show', $jurusan->slug),
            'image' => $image,
            'provider' => ['@id' => self::organizationId()],
            'inLanguage' => 'id-ID',
        ]);
    }

    /**
     * @param  array<int, array{name: string, url: string}>  $items
     */
    public static function itemList(array $items, string $name): array
    {
        return self::clean([
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => $name,
            'itemListElement' => array_map(
                fn (array $item, int $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['name'],
                    'url' => $item['url'],
                ],
                array_values($items),
                array_keys(array_values($items)),
            ),
        ]);
    }

    /**
     * @param  array<int, array{name: string, url: string}>  $items
     */
    public static function breadcrumb(array $items): array
    {
        return self::clean([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_map(
                fn (array $item, int $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['name'],
                    'item' => $item['url'],
                ],
                array_values($items),
                array_keys(array_values($items)),
            ),
        ]);
    }

    public static function schoolName(?SiteSetting $site): string
    {
        return $site?->school_name ?: config('school.fallback.school_name');
    }

    private static function organizationId(): string
    {
        return url('/').'#organization';
    }

    private static function confirmed(?string $value): ?string
    {
        if (blank($value) || Str::contains($value, 'BELUM DIKONFIRMASI')) {
            return null;
        }

        return $value;
    }

    /**
     * Buang properti null, string kosong, dan array kosong secara rekursif.
     */
    private static function clean(array $data): array
    {
        $cleaned = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = self::clean($value);
            }

            if ($value === null || $value === '' || $value === []) {
                continue;
            }

            $cleaned[$key] = $value;
        }

        return $cleaned;
    }
}
