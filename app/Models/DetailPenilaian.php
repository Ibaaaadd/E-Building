<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenilaian extends Model
{
    use HasFactory;

    protected $table = 'detail_penilaian';
    
    protected $fillable = [
        'id_detail',
        'id_indikator',
        'id_surveyor',
        'nilai_indikator',
        'gambar_sebelum',
        'nilai_survey',
        'gambar_survey',
        'nilai_sesudah',
        'gambar_sesudah',
    ];

    public function detail()
    {
        return $this->belongsTo(Detail::class, 'id_detail');
    }

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'id_indikator');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_surveyor');
    }
}
