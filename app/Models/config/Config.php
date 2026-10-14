<?php

namespace App\Models\config;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'configs';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'appactive',
        'conf_name',
        'conf_address'
    ];
}