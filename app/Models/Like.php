<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'allbany_foto_like';
    protected $fillable = ['id_foto', 'id_user'];
    public $timestamps = true;

    public function foto()
    {
        return $this->belongsTo(Foto::class, 'id_foto');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_user');
    }
}
