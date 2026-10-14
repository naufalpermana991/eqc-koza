<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\TrxInspectionModel;
use App\Http\Controllers\Controller;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Inspection extends Controller
{
	public function index(Request $request)
	{
		$from_date = date('Y-m-01 00:00:00');
		$to_date = date('Y-m-d 23:59:59');

		$data = DB::table('trx_inspection')->select('*')
		->whereRaw(" inspected_date BETWEEN '".$from_date."' AND '".$to_date."'")
		->where('deleted', false)
		->orderBy('inspected_date','desc')
		->get();

		return view('layouts.app', [
			'title' => 'Inspection',
			'data' => $data,
			'content' => 'contents.inspection.list'
		]);
	}

	public function getDataInspection(Request $request)
	{
		$from_date = $request->from_date.' 00:00:00';
		$to_date = $request->to_date.' 23:59:59';

		$data = DB::table('trx_inspection')->select('*')
		->whereRaw(" inspected_date BETWEEN '".$from_date."' AND '".$to_date."'")
		->where('deleted', false)
		->orderBy('inspected_date','desc')
		->get();

		echo json_encode($data);
	}

	public function convertImage(Request $request)
	{
        // Read file contents
		$fileContents = file_get_contents($request->full_path);

        // Convert to base64
		$base64Encoded = base64_encode($fileContents);

        // Kembalikan sebagai respons JSON
		return response()->json(['base64EncodedFile' => $base64Encoded]);
	}

	public function create(Request $request)
	{
		if($request->isMethod('post')) {
			$inspected_date = $request->inspected_date;
			$inspected_time = $request->inspected_time;
			$file_name = $request->file_name;

			$check_file_name = DB::table('trx_inspection')
			->select('id')
			->whereRaw("UPPER(file_name) = '".strtoupper(trim($file_name))."'")
			->get()
			->count();

			if($check_file_name > 0){
				return redirect()->back()->with('error', 'File Name is already exists!');
				exit();
			}

			$_full_path = '';
			if($_FILES['inspected_file']['name'] == ''){
				return redirect()->back()->with('error', 'File is not found!');
				exit();
			}else{
				$_filename = $_FILES['inspected_file']['name'];
				$_file_extention = pathinfo($_filename,PATHINFO_EXTENSION);
				$_file_extention = strtolower($_file_extention);
				$_valid_extention = array("xlsx");
				$_basic_path = 'assets/inspection/';
				$_file_name = $file_name.".".$_file_extention;
				$_full_path = $_basic_path.$_file_name;

				if(in_array(strtolower($_file_extention), $_valid_extention)) {
					$_file = $request->file('inspected_file');
					$_file->move($_basic_path, $_file_name);
				}else{
					return redirect()->back()->with('error', 'File extention is not valid (only .xlsx)!');
					exit();
				}
			}

			try {
				DB::beginTransaction();
				$trx_inspection = [
					'inspected_date' => $inspected_date.' '.$inspected_time,
					'inspected_file' => $_full_path,
					'file_name' => $file_name,
					'bulan' => date('m',strtotime($inspected_date)),
					'tahun' => date('Y',strtotime($inspected_date)),
					'created_id' => Session::get('id'),
					'created_by' => Session::get('fullname'),
					'created_date' => date('Y-m-d H:i:s')
				];

				TrxInspectionModel::create($trx_inspection);
				DB::commit();
				return redirect()->route('inspection.list')->with('success', 'Create Inspection Success!');
			} catch (Exception $e) {
				DB::rollBack();
				return redirect()->back()->with('error', 'Create Inspection Failed!');
			}
		}else{
			return redirect()->back()->with('error', 'Data is not found!');
		}
	}

	public function deleteData(Request $request)
	{
		$check_data = DB::table('trx_inspection')
		->select('*')
		->where("id", $request->id)
		->where('deleted', false)
		->get()
		->first();

		if(!$check_data){
			return redirect()->back()->with('error', 'Data is not found!');
		}else{
			if($check_data->validasi_leader_id != '' && $check_data->validasi_leader_id != null){
				return redirect()->back()->with('error', 'Inspection is already validated!');
			}else{
				$update_data = [
					'deleted' => true,
					'deleted_id' => Session::get('id'),
					'deleted_date' => date('Y-m-d H:i:s'),
					'deleted_by' => Session::get('fullname')
				];
				TrxInspectionModel::where(['id' => $request->id])->update($update_data);
				return redirect()->back()->with('success', 'Delete inspection success!');
			}
		}
	}

	public function showData(Request $request)
	{
		// Membaca file Excel yang ada
		$spreadsheet = IOFactory::load($request->link);

		// Mengakses sheet aktif (atau Anda bisa memilih sheet tertentu)
		$sheet = $spreadsheet->getActiveSheet();

		header('Content-Type: text/html');
		header('Content-Disposition: inline; filename="example.html"');
		header('Cache-Control: max-age=0');

		$writer = new Html($spreadsheet);
		$writer->save('php://output');
	}
	
}