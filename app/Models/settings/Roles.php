<?php

namespace App\Models\settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'app_role';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'role_name',
        'created_date',
        'created_by',
        'updated_date',
        'updated_by'
    ];
}
