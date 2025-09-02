<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_rumah_sakit',
        'alamat',
        'email',
        'telepon',
    ];

    /**
     * Get the pasiens for the rumah sakit.
     */
    public function pasiens()
    {
        return $this->hasMany(Pasien::class, 'id_rumah_sakit');
    }
}
