<?php

if (!function_exists('is_digit')) {
    /**
     * Deal with normal (and irritating) PHP behavior to determine if
     * a value is a non-float positive integer.
     */
    function is_digit(mixed $value): bool
    {
        return !is_bool($value) && ctype_digit(strval($value));
    }
}

if (!function_exists('is_ip')) {
    function is_ip(?string $address): bool
    {
        return $address !== null && filter_var($address, FILTER_VALIDATE_IP) !== false;
    }
}

if (!function_exists('convert_bytes_to_readable')) {
    function convert_bytes_to_readable(int $bytes, int $decimals = 2, ?int $base = null): string
    {
        $conversionUnit = config('panel.use_binary_prefix') ? 1024 : 1000;
        $suffix = config('panel.use_binary_prefix') ? ['Bytes', 'KiB', 'MiB', 'GiB', 'TiB'] : ['Bytes', 'KB', 'MB', 'GB', 'TB'];

        if ($bytes <= 0) {
            return '0 ' . $suffix[0];
        }

        $fromBase = log($bytes) / log($conversionUnit);
        $base ??= floor($fromBase);

        return round(pow($conversionUnit, $fromBase - $base), $decimals) . ' ' . $suffix[$base];
    }
}

if (!function_exists('join_paths')) {
    function join_paths(string $base, string ...$paths): string
    {
        if ($base === '/') {
            return str_replace('//', '', implode('/', $paths));
        }

        return str_replace('//', '', $base . '/' . implode('/', $paths));
    }
}

if (!function_exists('resolve_path')) {
    function resolve_path(string $path): string
    {
        // @phpstan-ignore-next-line
        $parts = array_filter(explode('/', $path), 'strlen');

        $absolutes = [];
        foreach ($parts as $part) {
            if ($part == '.') {
                continue;
            }

            if ($part == '..') {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }

        return implode('/', $absolutes);
    }
}
