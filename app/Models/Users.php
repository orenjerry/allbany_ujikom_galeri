<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'allbany_user';
    protected $fillable = ['id_role', 'username', 'email', 'password', 'nama_lengkap', 'alamat', 'accepted'];
    protected $hidden = ['password', 'accepted'];
    public $timestamps = true;

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
}
