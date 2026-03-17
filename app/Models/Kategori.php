<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori'; 

    protected $fillable = ['nama_kategori', 'sub_kategori']; 

    public function gedung() {
        return $this->hasMany(Indikator::class,'id_kategori');
    }
}
