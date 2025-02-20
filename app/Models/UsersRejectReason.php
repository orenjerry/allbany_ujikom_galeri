<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersRejectReason extends Model
{
    protected $table = 'allbany_users_reject_reason';
    protected $fillable = ['id_user', 'reason'];
    public $timestamps = true;

    public function users()
    {
        return $this->belongsTo(Users::class, 'id');
    }
}
