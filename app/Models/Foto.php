<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $fillable = ['id_user', 'id_album', 'lokasi_file', 'judul_foto', 'deskripsi_foto'];
    protected $table = 'allbany_foto';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_user');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'id_album');
    }

    public function like()
    {
        return $this->hasMany(Like::class, 'id_foto');
    }

    public function komen()
    {
        return $this->hasMany(Komen::class, 'id_foto');
    }
}
