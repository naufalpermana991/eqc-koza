<?php

namespace App\Models\config;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Launcher extends Model
{
    use HasFactory;

    protected $table = 'apps';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'appcode',
        'appname',
        'appicon',
        'appdesc'
    ];
}
