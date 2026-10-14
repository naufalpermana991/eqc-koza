<?php

namespace App\Models\settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenusModel extends Model
{
    use HasFactory;

    protected $table = 'app_menu';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'icon',
        'path',
        'group',
        'label',
        'appname',
        'position',
        'created_date',
        'created_by',
        'updated_date',
        'updated_by'
    ];
}
