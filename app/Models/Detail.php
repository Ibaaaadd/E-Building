<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $table = 'detail';

    protected $fillable = [
        'id_user',
        'id_pelaporan',
        'status',
        'bidang',
        'id_survey_at',
        'survey_at',
        'id_acc_at',
        'acc_at',
        'id_tolak_at',
        'tolak_at',
        'id_selesai_at',
        'selesai_at',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke tabel pelaporan
    public function pelaporan()
    {
        return $this->belongsTo(Pelaporan::class, 'id_pelaporan');
    }

    // Relasi ke tabel users untuk survey_at
    public function surveyUser()
    {
        return $this->belongsTo(User::class, 'id_survey_at');
    }

    // Relasi ke tabel users untuk acc_at
    public function accUser()
    {
        return $this->belongsTo(User::class, 'id_acc_at');
    }

    // Relasi ke tabel users untuk tolak_at
    public function tolakUser()
    {
        return $this->belongsTo(User::class, 'id_tolak_at');
    }

    // Relasi ke tabel users untuk selesai_at
    public function selesaiUser()
    {
        return $this->belongsTo(User::class, 'id_selesai_at');
    }

    public function detail_penilaian()
    {
        return $this->hasMany(DetailPenilaian::class, 'id_detail');
    }

}
