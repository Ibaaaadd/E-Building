<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    use HasFactory;

    protected $table = 'indikator'; // Sesuaikan dengan nama tabel di database jika berbeda

    protected $fillable = ['id_aspek', 'nama_indikator']; // Kolom yang dapat diisi secara massal

    public function aspek()
    {
        return $this->belongsTo(Aspek::class, 'id_aspek');
    }
    public function detail_penilaian(){
        return $this->hasMany(DetailPenilaian::class);
    }
}
