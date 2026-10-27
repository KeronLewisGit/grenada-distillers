<?php

namespace App\Support;

/**
 * The rum range from config gdl.rums: every fact on a product page is sourced there.
 */
final class Rums
{
    /** @return array<string, array<string, mixed>> */
    public static function all(): array
    {
        return (array) config('gdl.rums', []);
    }

    /** @return array<string, mixed>|null */
    public static function get(string $key): ?array
    {
        $rum = self::all()[$key] ?? null;

        return is_array($rum) ? $rum : null;
    }

    /** @return array<string, string> key => name, for form checkboxes */
    public static function options(): array
    {
        return array_map(fn (array $r) => (string) $r['name'], self::all());
    }

    /**
     * Grouped by family, in config order.
     *
     * @return array<string, array<string, array<string, mixed>>>
     */
    public static function byFamily(): array
    {
        $out = [];
        foreach (self::all() as $key => $rum) {
            $out[(string) $rum['family']][$key] = $rum;
        }

        return $out;
    }

    /** @return array<string, array<string, mixed>> other rums, same family first */
    public static function related(string $key, int $limit = 3): array
    {
        $rum = self::get($key);
        $others = array_filter(self::all(), fn ($k) => $k !== $key, ARRAY_FILTER_USE_KEY);
        uasort($others, fn (array $a, array $b) => (int) (($b['family'] ?? '') === ($rum['family'] ?? '')) <=> (int) (($a['family'] ?? '') === ($rum['family'] ?? '')));

        return array_slice($others, 0, $limit, true);
    }
}
