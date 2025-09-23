<?php

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
