<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'allbany_foto_like';
    protected $fillable = ['id_foto', 'id_user'];
    public $timestamps = true;
}
