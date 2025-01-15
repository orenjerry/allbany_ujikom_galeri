<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'allbany_role';
    protected $fillable = ['role_code', 'role_name'];
    public $timestamps = true;

    public function users()
    {
        return $this->hasMany(Users::class, 'id_role');
    }
}
