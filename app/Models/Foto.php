<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $fillable = ['id_user', 'id_album', 'lokasi_file', 'judul_foto', 'deskripsi_foto'];
    protected $table = 'allbany_foto';
    public $timestamps = true;
}
