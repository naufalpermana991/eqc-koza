<?php

namespace App\Models\settings;

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
        'fullname',
        'nip',
        'file_ttd',
        'deleted',
    ];
}
