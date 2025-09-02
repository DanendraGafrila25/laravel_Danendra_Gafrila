<?php

namespace Database\Seeders;

use App\Models\Pasien;
use App\Models\RumahSakit;
use Illuminate\Database\Seeder;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rs1 = RumahSakit::where('nama_rumah_sakit', 'Rumah Sakit Bunda')->first();
        $rs2 = RumahSakit::where('nama_rumah_sakit', 'RSUD Kota Bandung')->first();


        Pasien::create([
            'nama_pasien' => 'Sari',
            'alamat' => 'Jl. Pahlawan No. 2',
            'no_telepon' => '081234567890',
            'id_rumah_sakit' => $rs1->id
        ]);

        Pasien::create([
            'nama_pasien' => 'Budi',
            'alamat' => 'Jl. Sudirman No. 5',
            'no_telepon' => '082198765432',
            'id_rumah_sakit' => $rs1->id
        ]);

        Pasien::create([
            'nama_pasien' => 'Yudi',
            'alamat' => 'Jl. Dago No. 8',
            'no_telepon' => '083112233445',
            'id_rumah_sakit' => $rs2->id
        ]);
    }
}
