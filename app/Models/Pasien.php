<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;


    protected $fillable = [
        'nama_pasien',
        'alamat',
        'no_telepon',
        'id_rumah_sakit',
    ];

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class, 'id_rumah_sakit');
    }
}
