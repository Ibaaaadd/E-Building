<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    use HasFactory;

    protected $table = 'gedung';

    protected $fillable = [
        'id_user',
        'id_dinas',
        'id_jenis',
        'nama_gedung',
        'alamat_gedung',
        'foto_gedung',
        'luas_gedung',
        'luas_tanah',
        'longitude',
        'latitude',
    ];

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas');
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'id_jenis');
    }

    public function pelaporan()
    {
        return $this->hasOne(Pelaporan::class, 'id_gedung');
    }
}
