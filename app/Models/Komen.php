<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komen extends Model
{
    protected $table = 'allbany_foto_komentar';
    protected $fillable = ['id_foto', 'id_user', 'isi_komentar'];
    public $timestamps = true;
}
