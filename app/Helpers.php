<?php

use Carbon\Carbon;

if (! function_exists('remaining_credit')) {
    function remaining_credit($hargaPaket, $totalHari, $tanggalMulai, $tanggalAkhir)
    {
        $today = now();

        // hitung sisa hari
        $sisaHari = $today->diffInDays($tanggalAkhir, false);
        if ($sisaHari <= 0) {
            return 0;
        }

        // hitung prorata
        $nilaiSisa = ($hargaPaket / $totalHari) * $sisaHari;

        return round($nilaiSisa);
    }
}

if (! function_exists('make_url')) {
    /**
     * Buat URL dengan subdomain dinamis
     */
    function make_url(string $subdomain, ?string $path = null, ?bool $secure = null): string
    {
        $baseUrl = config('app.url'); // contoh: http://domain.test atau https://domain.com

        // parse base url
        $parsed = parse_url($baseUrl);

        $scheme = $secure === null
            ? ($parsed['scheme'] ?? 'http')
            : ($secure ? 'https' : 'http');

        $host = $parsed['host'] ?? 'localhost';

        // gabungkan subdomain + domain utama
        $fullHost = $subdomain . '.' . $host;

        // kalau ada port di base url, tambahkan juga
        if (isset($parsed['port'])) {
            $fullHost .= ':' . $parsed['port'];
        }

        // path opsional
        $path = $path ? '/' . ltrim($path, '/') : '';

        return "{$scheme}://{$fullHost}{$path}";
    }
}

if (!function_exists('indo_date')) {
    function indo_date($date, $format = 'D MMMM Y'): string
    {
        return Carbon::parse($date)->isoFormat($format);
    }
}
