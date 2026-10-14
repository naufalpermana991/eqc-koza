<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\CustomerModel;
use App\Http\Controllers\Controller;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Customer extends Controller
{
	public function index(Request $request)
	{
		$data = CustomerModel::select('*')
		->where('deleted', false)
		->orderBy('customer_name','asc')
		->get();

		return view('layouts.app', [
			'title' => 'Customer',
			'data' => $data,
			'content' => 'contents.customer.list'
		]);
	}

	public function create(Request $request)
	{
		if($request->isMethod('post')) {
			$customer_name = $request->customer_name;
			$location_file = $request->location_file;
			$file_name = $request->file_name;
			$location_date_leader = strtoupper($request->location_date_leader);
			$location_sign_leader = strtoupper($request->location_sign_leader);
			$location_name_leader = strtoupper($request->location_name_leader);
			$location_date_spv = strtoupper($request->location_date_spv);
			$location_sign_spv = strtoupper($request->location_sign_spv);
			$location_name_spv = strtoupper($request->location_name_spv);

			try {
				DB::beginTransaction();
				$insert_data = [
					'customer_name' => $customer_name,
					'location_file' => $location_file,
					'file_name' => $file_name,
					'location_date_leader' => $location_date_leader,
					'location_sign_leader' => $location_sign_leader,
					'location_name_leader' => $location_name_leader,
					'location_date_spv' => $location_date_spv,
					'location_sign_spv' => $location_sign_spv,
					'location_name_spv' => $location_name_spv,

				];

				CustomerModel::create($insert_data);
				DB::commit();
				return redirect()->route('customer.list')->with('success', 'Add New Customer Success!');
			} catch (Exception $e) {
				DB::rollBack();
				return redirect()->back()->with('error', 'Add New Customer Failed!');
			}
		}else{
			return redirect()->back()->with('error', 'Data is not found!');
		}
	}

	public function deleteData(Request $request)
	{
		$check_data = CustomerModel::select('*')
		->select('*')
		->where("id", $request->id)
		->where('deleted', false)
		->get()
		->first();

		if(!$check_data){
			return redirect()->back()->with('error', 'Data is not found!');
		}else{
			$update_data = [
				'deleted' => true,
			];
			CustomerModel::where(['id' => $request->id])->update($update_data);
			return redirect()->back()->with('success', 'Delete customer success!');
		}
	}

	public function getData(Request $request)
	{
		$data = CustomerModel::select('*')
		->select('*')
		->where("id", $request->id)
		->where('deleted', false)
		->get()
		->first();

		echo json_encode($data);
	}

	public function update(Request $request)
	{
		if($request->isMethod('post')) {
			$id = $request->id;
			$customer_name = $request->customer_name;
			$location_file = $request->location_file;
			$file_name = $request->file_name;
			$location_date_leader = strtoupper($request->location_date_leader);
			$location_sign_leader = strtoupper($request->location_sign_leader);
			$location_name_leader = strtoupper($request->location_name_leader);
			$location_date_spv = strtoupper($request->location_date_spv);
			$location_sign_spv = strtoupper($request->location_sign_spv);
			$location_name_spv = strtoupper($request->location_name_spv);

			try {
				DB::beginTransaction();
				$update_data = [
					'customer_name' => $customer_name,
					'location_file' => $location_file,
					'file_name' => $file_name,
					'location_date_leader' => $location_date_leader,
					'location_sign_leader' => $location_sign_leader,
					'location_name_leader' => $location_name_leader,
					'location_date_spv' => $location_date_spv,
					'location_sign_spv' => $location_sign_spv,
					'location_name_spv' => $location_name_spv,

				];

				CustomerModel::where('id', $id)->update($update_data);
				DB::commit();
				return redirect()->route('customer.list')->with('success', 'Update Customer Success!');
			} catch (Exception $e) {
				DB::rollBack();
				return redirect()->back()->with('error', 'Update Customer Failed!');
			}
		}else{
			return redirect()->back()->with('error', 'Data is not found!');
		}
	}
	
}