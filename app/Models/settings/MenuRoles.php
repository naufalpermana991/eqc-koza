<?php

namespace App\Models\settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRoles extends Model
{
    use HasFactory;

    protected $table = 'app_role_menu';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'role_id',
        'menu_id',
        'view_list',
        'view_detail',
        'insert',
        'update',
        'delete',
        'created_date',
        'created_by',
        'updated_date',
        'updated_by'
    ];
}
