<?php

namespace App\Models\settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configs extends Model
{
    use HasFactory;

    protected $table = 'app_config';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'param',
        'value',
        'created_date',
        'created_by',
        'updated_date',
        'updated_by'
    ];
}
