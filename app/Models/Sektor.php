<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sektor extends Model
{
    use HasFactory;

    protected $table = 'sektor';

    protected $fillable = [
        'nama',
        'detail',
        'foto',
    ];

    public function jenises() 
    {
        return $this->hasMany(Jenis::class, 'id_sektor');
    }
    public function gedung()
    {
        return $this->hasMany(Gedung::class, 'id_sektor');
    }
}
