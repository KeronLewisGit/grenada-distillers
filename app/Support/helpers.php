<?php

if (! function_exists('gdl')) {
    /** A Grenada Distillers fact from config/gdl.php: gdl('phone'), gdl('address.street'). */
    function gdl(string $key, mixed $default = null): mixed
    {
        return config('gdl.'.$key, $default);
    }
}

if (! function_exists('us_digits')) {
    /** E.164 digits for a North American Numbering Plan number (+1, incl. Grenada 473) written any common way, or null. */
    function us_digits(?string $number): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $number) ?? '';
        if (strlen($digits) === 10) {
            $digits = '1'.$digits;
        }

        return strlen($digits) === 11 && $digits[0] === '1' ? $digits : null;
    }
}

if (! function_exists('tel_href')) {
    function tel_href(?string $number): string
    {
        $digits = us_digits($number);

        return $digits ? 'tel:+'.$digits : 'tel:'.preg_replace('/[^\d+]/', '', (string) $number);
    }
}

if (! function_exists('format_phone')) {
    /** (473) 444-5196 style for +1 numbers, the way Grenadians write them; the input unchanged otherwise. */
    function format_phone(?string $number): string
    {
        $digits = us_digits($number);
        if (! $digits) {
            return (string) $number;
        }

        return sprintf('(%s) %s-%s', substr($digits, 1, 3), substr($digits, 4, 3), substr($digits, 7));
    }
}

if (! function_exists('input_string')) {
    /** A request value as a string. Arrays (?type[]=x) and other junk become ''. */
    function input_string(mixed $value): string
    {
        return is_scalar($value) ? trim((string) $value) : '';
    }
}

if (! function_exists('old_string')) {
    /** Old form input as a string. A tampered array (name[]=x) becomes '' instead of crashing the form it is shown in. */
    function old_string(string $key, mixed $default = null): string
    {
        $value = old($key, $default);

        return is_scalar($value) ? (string) $value : '';
    }
}

if (! function_exists('lines_to_array')) {
    /**
     * Textarea with one item per line, bullets optional, to a clean list.
     *
     * @return list<string>
     */
    function lines_to_array(?string $text): array
    {
        $lines = preg_split('/\r\n|\r|\n/', (string) $text) ?: [];
        $clean = array_map(fn (string $l) => trim((string) preg_replace('/^(?:[-*]|•)\s*/u', '', $l)), $lines);

        return array_values(array_filter($clean, fn (string $l) => $l !== ''));
    }
}

if (! function_exists('compact_number')) {
    /** 1,284 → 1.3K, used on stat tiles. */
    function compact_number(int|float $n): string
    {
        return match (true) {
            abs($n) >= 1_000_000 => round($n / 1_000_000, 1).'M',
            abs($n) >= 10_000 => round($n / 1_000).'K',
            default => number_format($n),
        };
    }
}

if (! function_exists('photo')) {
    /**
     * Responsive <img> attributes for a photo in public/img (WebP at 480/960/1920 wide).
     *
     * @return array{src: string, srcset: string, width: int, height: int}
     */
    function photo(string $key): array
    {
        $meta = config('gdl.photos.'.$key) ?? ['w' => 1920, 'h' => 1280];
        $url = fn (int $w) => asset("img/{$key}-{$w}.webp");
        // Small originals (the archived site's photos) are never upscaled: the larger files are
        // the original size, so the srcset states their real width and stops there.
        $srcset = [];
        foreach ([480, 960, 1920] as $size) {
            $srcset[] = $url($size).' '.min($size, (int) $meta['w']).'w';
            if ($size >= (int) $meta['w']) {
                break;
            }
        }

        return [
            'src' => $url(960),
            'srcset' => implode(', ', $srcset),
            'width' => (int) $meta['w'],
            'height' => (int) $meta['h'],
        ];
    }
}

if (! function_exists('wa_href')) {
    /** WhatsApp click-to-chat link, optionally with a prefilled message. */
    function wa_href(?string $number = null, ?string $text = null): string
    {
        $digits = us_digits($number ?? (string) gdl('whatsapp')) ?? preg_replace('/\D+/', '', (string) $number);

        return 'https://wa.me/'.$digits.($text ? '?text='.rawurlencode($text) : '');
    }
}
