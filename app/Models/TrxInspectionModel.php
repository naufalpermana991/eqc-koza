<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxInspectionModel extends Model
{
    use HasFactory;

    protected $table = 'trx_inspection';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'inspected_date',
        'inspected_file',
        'file_name',
        'bulan',
        'tahun',
        'deleted',
        'validasi_leader_id',
        'validasi_leader_by',
        'validasi_leader_date',
        'validasi_spv_id',
        'validasi_spv_by',
        'validasi_spv_date',
        'created_id',
        'created_by',
        'created_date',
        'updated_id',
        'updated_by',
        'updated_date',
        'deleted_id',
        'deleted_by',
        'deleted_date'
    ];
}
