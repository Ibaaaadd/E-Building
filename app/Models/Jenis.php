<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;

    protected $table = 'jenis';

    protected $fillable = [
        'id_sektor',
        'nama',
        'detail',
        'foto',
    ];

    public function sektor()
    {
        return $this->belongsTo(Sektor::class, 'id_sektor');
    }

    public function gedung()
    {
        return $this->hasMany(Gedung::class, 'id_jenis');
    }
}
