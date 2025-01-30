<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public $timestamps = true;
    protected $table = 'allbany_album';
    protected $fillable = ['id_user', 'nama_album', 'deskripsi'];

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_user');
    }

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_album');
    }
}
