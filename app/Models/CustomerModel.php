<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;

    protected $table = 'tb_customer';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'customer_name',
        'location_file',
        'file_name',
        'location_date_leader',
        'location_sign_leader',
        'location_name_leader',
        'location_date_spv',
        'location_sign_spv',
        'location_name_spv',
        'deleted'
    ];
}
