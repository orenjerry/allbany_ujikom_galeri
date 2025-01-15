<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public $timestamps = true;
    protected $table = 'allbany_album';
    protected $fillable = ['id_user', 'nama_album'];
}
