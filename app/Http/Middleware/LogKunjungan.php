<?php

namespace App\Http\Middleware;

use App\Models\Kunjungan;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogKunjungan
{
    /**
     * Mencatat setiap kunjungan halaman publik (Beranda, Katalog, Detail Budaya)
     * ke tabel `kunjungans` untuk keperluan Laporan Statistik Kunjungan Website
     * (BAB IV.4 poin 11 - Output Statistik Kunjungan Website).
     *
     * Catatan: kolom `kota` diisi "Tidak Diketahui" karena mendeteksi kota asal
     * pengunjung secara akurat butuh layanan geolokasi IP pihak ketiga (butuh
     * koneksi internet real-time & IP publik yang valid — tidak akan berfungsi
     * saat diakses dari localhost/127.0.0.1 seperti pada lingkungan development).
     * Kolom ini sengaja disiapkan agar mudah dihubungkan ke layanan geolokasi
     * (mis. ip-api.com) saat sistem sudah di-deploy ke server publik.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            $userAgent = (string) $request->userAgent();
            $perangkat = 'Desktop';
            if (preg_match('/iPad|Tablet/i', $userAgent)) {
                $perangkat = 'Tablet';
            } elseif (preg_match('/Mobile|Android|iPhone/i', $userAgent)) {
                $perangkat = 'Mobile';
            }

            $warisanId = $request->routeIs('katalog.show') ? $request->route('id') : null;

            Kunjungan::create([
                'halaman' => '/' . ltrim($request->path(), '/'),
                'warisan_budaya_id' => $warisanId,
                'tanggal' => now()->toDateString(),
                'waktu' => now()->toTimeString(),
                'perangkat' => $perangkat,
                'kota' => 'Tidak Diketahui',
                'ip' => (string) $request->ip(),
            ]);
        } catch (\Throwable $e) {
            // Jangan sampai kegagalan logging mengganggu tampilan halaman utama
            report($e);
        }

        return $response;
    }
}
