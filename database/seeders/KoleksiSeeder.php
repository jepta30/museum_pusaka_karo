<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Koleksi;

class KoleksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonPath = base_path('koleksi_data.json');
        
        if (!file_exists($jsonPath)) {
            $this->command->error("File koleksi_data.json tidak ditemukan!");
            return;
        }

        $json = file_get_contents($jsonPath);
        $data = json_decode($json, true);

        if (!$data) {
            $this->command->error("Gagal membaca atau mengurai koleksi_data.json");
            return;
        }

        $this->command->info("Menyiapkan import " . count($data) . " data koleksi...");

        // Kosongkan tabel sebelum diisi ulang
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Koleksi::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $chunks = array_chunk($data, 200);
        
        foreach ($chunks as $chunk) {
            $insertData = [];
            foreach ($chunk as $item) {
                // Pastikan panjang string tidak melebihi batas
                $insertData[] = [
                    'nomor_koleksi'    => substr($item['nomor_koleksi'] ?? '-', 0, 50), // changed to 50 just in case it exceeds 20
                    'nama_koleksi'     => substr($item['nama_koleksi'] ?? '-', 0, 255),
                    'jenis_koleksi'    => substr($item['jenis_koleksi'] ?? '-', 0, 255),
                    'nama_pemilik'     => substr($item['nama_pemilik'] ?? '-', 0, 255),
                    'cara_perolehan'   => substr($item['cara_perolehan'] ?? '-', 0, 255),
                    'tempat_perolehan' => substr($item['tempat_perolehan'] ?? '-', 0, 255),
                    'tanggal_masuk'    => substr($item['tanggal_masuk'] ?? '-', 0, 255),
                    'keterangan'       => $item['keterangan'] ?? '-',
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ];
            }
            Koleksi::insertOrIgnore($insertData);
        }

        $this->command->info("Berhasil melakukan seeding " . count($data) . " data buku induk koleksi!");
    }
}
