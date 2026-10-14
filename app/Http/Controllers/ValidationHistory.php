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
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Storage;

class ValidationHistory extends Controller
{
	public function index(Request $request)
	{
		$jabatan = Session::get('role_name');

		$data_customer = DB::table('tb_customer')
		->select('id','customer_name','location_file','file_name')
		->where('deleted', false)
		->orderBy('customer_name','asc')
		->get();


		$data = [];
		$id_customer = '';
		if(count($data_customer) > 0){

			$id_customer = $data_customer[0]->id;
			if(isset($request->id)){
				$id_customer = $request->id;
				$_data_file = DB::table('tb_customer')
				->select('*')
				->where('deleted', false)
				->where('id', $request->id)
				->get()
				->first();

			}else{
				$_data_file = $data_customer[0];
			}

			$data = [];
			if(file_exists($_data_file->location_file)){
				$file_computer = scandir($_data_file->location_file, 1);
				foreach ($file_computer as $v) {
					if(str_contains($v,$_data_file->file_name)){
						if(str_contains($v,'LDR')){
							$_spv = false;
							if(str_contains($v,'SPV')){
								$_spv = true;
							}
							$path = str_replace('\\', '/', $_data_file->location_file);
							$data[] = [
								'id_customer' => $_data_file->id,
								'file_name' => $v,
								'leader' => true,
								'spv' => $_spv,
								'path' => $path.'/'.$v
							];
						}
					}
				}
			}
		}

		return view('layouts.app', [
			'title' => 'Validation History',
			'data' => $data,
			'id_customer' => $id_customer,
			'data_customer' => $data_customer,
			'content' => 'contents.validation_history.list'
		]);
	}

	public function getDataHistory(Request $request)
	{
		$from_date = $request->from_date;
		$to_date = $request->to_date;
		$data = DB::table('trx_inspection')->select('*')
		->where('deleted', false)
		->whereRaw("inspected_date BETWEEN '".$from_date."' AND '".$to_date."' ")
		->orderBy('inspected_date','desc')
		->get();

		echo json_encode($data);
	}

	public function showData(Request $request)
	{
		$_path = $request->link;
		$_explode = explode('/', $_path);
		$_file_name = $_explode[sizeof($_explode)-1];
		$_explode_name = explode('.',$_file_name);
		$_file_pdf = $_explode_name[0].'.pdf';

		$sofficePath = '"C:\Program Files\LibreOffice\program\soffice.exe"';
		$inputFilePath = '"'.str_replace('/','\\',$request->link).'"';
		$outputDirectory = '"'.public_path('assets\inspection').'"';
		$command = "$sofficePath --headless --convert-to pdf --outdir $outputDirectory $inputFilePath";

		$output = shell_exec($command);

		return response()->file(public_path('assets\inspection').'/'.$_file_pdf, [
			'Content-Type' => 'application/pdf',
			'Content-Disposition' => 'inline; filename="converted-file.pdf"',
		]);
	}

	public function exportExcel(Request $request)
	{
		$from_date = $request->from;
		$to_date = $request->to;
		if($from_date != '' && $to_date != ''){
			$data = DB::table('trx_inspection')->select('*')
			->where('deleted', false)
			->whereRaw("inspected_date BETWEEN '".$from_date."' AND '".$to_date."' ")
			->orderBy('inspected_date','desc')
			->get();

			if($data){
				$excel = new Spreadsheet();
				$sheet = $excel->getActiveSheet();
				$sheet->setTitle("Validation History");
				$sheet->setShowGridlines(false);

				$excel->getDefaultStyle()->getFont()->setName('Tahoma');
				$excel->getDefaultStyle()->getFont()->setSize(11);

				$titleExcel = array(
					'font'  => array(
						'size'  => 14,
						'bold'  => true,
					),
					'alignment' => array(
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					)
				); 

				$boldCenter = array(
					'font'  => array(
						'bold'  => true,
					),
					'alignment' => array(
						'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					)
				);

				$boldRight = array(
					'font'  => array(
						'bold'  => true,
					),
					'alignment' => array(
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
					)
				);

				$alignRight = array(
					'alignment' => array(
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
					)
				);

				$alignCenter = array(
					'alignment' => array(
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					)
				);

				$allBorder = array(
					'borders' => array(
						'allBorders' => array(
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
						)
					)
				);

				$sheet->getStyle('A1')->getFont()->setBold(true);
				$sheet->getStyle('A1')->applyFromArray($titleExcel);
				$sheet->setCellValue("A1","VALIDATION HISTORY");
				$sheet->setCellValue("A2","From ".date('d F Y', strtotime($from_date)).", to ".date('d F Y', strtotime($to_date)));
				$sheet->mergeCells('A1:F1');

				$sheet->setCellValue("A4","NO");
				$sheet->setCellValue("B4","INSPECTED DATE");
				$sheet->setCellValue("C4","INSPECTED BY");
				$sheet->setCellValue("D4","FILE NAME");
				$sheet->setCellValue("E4","LEADER CHECKING");
				$sheet->setCellValue("F4","SUPERVISOR CHECKING");

				$cellBarisPertama = 5;
				foreach ($data as $row => $value) {
					$sheet->setCellValue('A'.$cellBarisPertama,$row+1);
					$sheet->setCellValue('B'.$cellBarisPertama,date('d F Y, H:i:s', strtotime($value->inspected_date)));
					$sheet->setCellValue('C'.$cellBarisPertama,$value->created_by);
					$sheet->setCellValue('D'.$cellBarisPertama,$value->file_name.".xlsx");
					$sheet->setCellValue('E'.$cellBarisPertama,$value->validasi_leader_by);
					$sheet->setCellValue('F'.$cellBarisPertama,$value->validasi_spv_by);
					$cellBarisPertama++;
				}

				$sheet->getStyle('A4:F'.((int)$cellBarisPertama - 1))->applyFromArray($allBorder);

				$sheet->getStyle('A4:F4')->applyFromArray($boldCenter);
				$sheet->getStyle('A5:B'.((int)$cellBarisPertama - 1))->applyFromArray($alignCenter);
				$sheet->getStyle('E5:F'.((int)$cellBarisPertama - 1))->applyFromArray($alignCenter);

				$sheet->getColumnDimension('A')->setWidth(6);
				$sheet->getColumnDimension('B')->setWidth(25);
				$sheet->getColumnDimension('C')->setWidth(20);
				$sheet->getColumnDimension('D')->setWidth(40);
				$sheet->getColumnDimension('E')->setWidth(25);
				$sheet->getColumnDimension('F')->setWidth(25);

				$filename	= "Validation History From ".date('d F Y', strtotime($from_date))." to ".date('d F Y', strtotime($to_date));

				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
				header('Cache-Control: max-age=0');
				header('Cache-Control: max-age=1');

				$writer = IOFactory::createWriter($excel, 'Xlsx');
				$writer->save('php://output');
			}else{
				echo "Data tidak ditemukan";
			}
		}else{
			echo "Data tidak ditemukan";
		}
	}

}