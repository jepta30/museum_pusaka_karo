<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\WarisanBudaya;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_zero_points_when_no_coordinates_are_available(): void
    {
        Kategori::create([
            'nama' => 'Test Kategori',
            'deskripsi' => 'Deskripsi test',
            'icon' => 'icon-test',
        ]);

        WarisanBudaya::create([
            'kategori_id' => 1,
            'judul' => 'Warisan Test',
            'lokasi' => 'Berastagi',
            'asal' => 'Suku Karo',
            'kondisi' => 'Baik',
            'deskripsi' => 'Deskripsi',
            'sejarah' => 'Sejarah',
            'gambar' => 'warisan_images/test.jpg',
            'status' => 'aktif',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertViewHas('totalTitik', 0);
    }
}
