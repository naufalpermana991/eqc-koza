<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    use HasFactory;

    protected $table = 'users';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'id_role',
        'username',
        'password',
        'nip',
        'foto_profile',
        'fullname',
        'file_ttd',
        'deleted'
    ];
}
