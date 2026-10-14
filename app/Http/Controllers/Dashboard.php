<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Dashboard extends Controller
{

	public function index()
	{
		return view('layouts.app', [
			'title' => 'Dashboard',
			'content' => 'contents.dashboard'
		]);
	}

	public function showExcel(Request $request)
	{
		$link = public_path($request->link);
		return view('contents.show_excel', [
			'title' => 'Show Excel',
			'link' => $link
		]);
	}

}