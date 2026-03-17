<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    use HasFactory;

    protected $table = 'pelaporan';
    
    protected $fillable = [
        'id_user',
        'id_gedung',
        'id_dinas',
        'tanggal_laporan',
        'deskripsi_laporan',
        'surat',
        'status', 
        'survey_at',
        'menunggu_at',
        'acc_at',
        'tolak_at',
        'survey_user_id',
        'selesai_user_id',
        'acc_user_id',
        'tolak_user_id',

    ];

    public function detail()
    {
        return $this->hasMany(Detail::class, 'id_pelaporan');
    }

    public function tolak_user()
    {
        return $this->belongsTo(User::class, 'tolak_user_id');
    }
    
    public function acc_user()
    {
        return $this->belongsTo(User::class, 'acc_user_id');
    }

    public function selesai_user()
    {
        return $this->belongsTo(User::class, 'selesai_user_id');
    }

    public function survey_user()
    {
        return $this->belongsTo(User::class, 'survey_user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'id_gedung');
    }

    public function dinas()
    {
        return $this->belongsTo(dinas::class, 'id_dinas');
    }
}
