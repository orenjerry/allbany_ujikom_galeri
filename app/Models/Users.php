<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'allbany_user';
    protected $fillable = ['id_role', 'username', 'email', 'password', 'nama_lengkap', 'alamat'];
    protected $hidden = 'password';
    public $timestamps = true;
}
