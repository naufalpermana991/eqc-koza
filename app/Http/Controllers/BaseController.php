<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\bacameter\BmPelangganModel;
use DB;
use Request;

class BaseController extends Controller
{
	public function toMonth($value)
    {
        $callback = 'January';
        switch ($value) {
            case '01':
            $callback = 'Januari';
            break;
            case '02':
            $callback = 'Februari';
            break;
            case '03':
            $callback = 'Maret';
            break;
            case '04':
            $callback = 'April';
            break;
            case '05':
            $callback = 'Mei';
            break;
            case '06':
            $callback = 'Juni';
            break;
            case '07':
            $callback = 'Juli';
            break;
            case '08':
            $callback = 'Agustus';
            break;
            case '09':
            $callback = 'September';
            break;
            case '10':
            $callback = 'Oktober';
            break;
            case '11':
            $callback = 'November';
            break;
            case '12':
            $callback = 'Desember';
            break;
        }
        return $callback;
    }
}