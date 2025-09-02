<?php

namespace Database\Seeders;

use App\Models\RumahSakit;
use Illuminate\Database\Seeder;

class RumahSakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RumahSakit::create([
            'nama_rumah_sakit' => 'Rumah Sakit Bunda',
            'alamat' => 'Jl. Merdeka No. 10',
            'email' => 'bunda@email.com',
            'telepon' => '021123456'
        ]);

        RumahSakit::create([
            'nama_rumah_sakit' => 'RSUD Kota Bandung',
            'alamat' => 'Jl. Asia Afrika No. 5',
            'email' => 'rsud@email.com',
            'telepon' => '022987654'
        ]);
    }
}
