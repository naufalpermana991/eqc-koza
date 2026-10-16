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
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;

class Validation extends Controller
{
	public function index(Request $request)
	{
		$jabatan = Session::get('role_name');

		$data_customer = DB::table('tb_customer')
			->select('id', 'customer_name', 'location_file', 'file_name')
			->where('deleted', false)
			->orderBy('customer_name', 'asc')
			->get();

		$data = [];
		$id_customer = '';
		if (count($data_customer) > 0) {
			$id_customer = $data_customer[0]->id;
			if (isset($request->id)) {
				$id_customer = $request->id;
				$_data_file = DB::table('tb_customer')
					->select('*')
					->where('deleted', false)
					->where('id', $request->id)
					->get()
					->first();
			} else {
				$_data_file = $data_customer[0];
			}

			if ($jabatan != 'Leader' && $jabatan != 'Supervisor' && $jabatan != 'Admin') {
			} elseif ($jabatan == 'Leader') {
				if (file_exists($_data_file->location_file)) {
					$file_computer = scandir($_data_file->location_file, 1);
					foreach ($file_computer as $v) {
						if (str_contains($v, $_data_file->file_name)) {
							if (!str_contains($v, 'LDR')) {
								$_explode_name = explode('.', $v);
								$_ext = $_explode_name[1];

								if ($_ext == 'xlsx') {
									$path = str_replace('\\', '/', $_data_file->location_file);
									$data[] = [
										'id_customer' => $_data_file->id,
										'file_name' => $v,
										'path' => $path . '/' . $v
									];
								}
							}
						}
					}
				}
			} elseif ($jabatan == 'Supervisor') {
				if (file_exists($_data_file->location_file)) {
					$file_computer = scandir($_data_file->location_file, 1);
					foreach ($file_computer as $v) {
						if (str_contains($v, $_data_file->file_name)) {
							if (!str_contains($v, 'SPV') && str_contains($v, 'LDR')) {
								$_explode_name = explode('.', $v);
								$_ext = $_explode_name[1];
								if ($_ext == 'xlsx') {
									$path = str_replace('\\', '/', $_data_file->location_file);
									$data[] = [
										'id_customer' => $_data_file->id,
										'file_name' => $v,
										'path' => $path . '/' . $v
									];
								}
							}
						}
					}
				}
			}
			// elseif($jabatan == 'Admin'){
			// 	if(file_exists($_data_file->location_file)){
			// 		$file_computer = scandir($_data_file->location_file, 1);
			// 		foreach ($file_computer as $v) {
			// 			if(str_contains($v,$_data_file->file_name)){
			// 				$_explode_name = explode('.',$v);
			// 				$_ext = $_explode_name[1];
			// 				if($_ext == 'xlsx'){
			// 					$path = str_replace('\\', '/', $_data_file->location_file);
			// 					$data[] = [
			// 						'id_customer' => $_data_file->id,
			// 						'file_name' => $v,
			// 						'path' => $path.'/'.$v
			// 					];
			// 				}
			// 			}
			// 		}
			// 	}
			// }
		}

		return view('layouts.app', [
			'title' => $jabatan . ' File Validation',
			'id_customer' => $id_customer,
			'data' => $data,
			'data_customer' => $data_customer,
			'content' => 'contents.validation.list'
		]);
	}

	public function downloadData(Request $request)
	{
		$_path = $request->link;
		$_explode = explode('/', $_path);
		$_file_name = $_explode[sizeof($_explode) - 1];
		$_explode_name = explode('.', $_file_name);
		$filename = $_explode_name[0];

		$spreadsheet = IOFactory::load($request->link);
		$sheet = $spreadsheet->getSheet(0);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
	}

	public function showData(Request $request)
	{
		$_path = $request->link;
		$_explode = explode('/', $_path);
		$_file_name = $_explode[sizeof($_explode) - 1];
		$_explode_name = explode('.', $_file_name);
		$_file_pdf = $_explode_name[0] . '.pdf';

		$sofficePath = '"D:\Instalan Software\LibreOffice\Data\program\soffice.exe"';
		$inputFilePath = '"' . str_replace('/', '\\', $request->link) . '"';
		$outputDirectory = '"' . public_path('assets\inspection') . '"';
		$command = "$sofficePath --headless --convert-to pdf --outdir $outputDirectory $inputFilePath";

		$output = shell_exec($command);

		return response()->file(public_path('assets\inspection') . '/' . $_file_pdf, [
			'Content-Type' => 'application/pdf',
			'Content-Disposition' => 'inline; filename="converted-file.pdf"',
		]);
	}

	public function checkedFile(Request $request)
	{
		$jabatan = Session::get('role_name');
		$file_ttd = Session::get('file_ttd');

		if ($jabatan != 'Leader' && $jabatan != 'Supervisor' && $jabatan != 'Admin') {
			return redirect()->back()->with('error', 'Only for Leader and Supervisor!');
			exit();
		}

		if ($file_ttd == '' || $file_ttd == null) {
			return redirect()->back()->with('error', 'Your TTD is not found, please update your profile!');
			exit();
		}

		if ($request->path == '') {
			return redirect()->back()->with('error', 'Path is not found!');
		} else {
			$_id = $request->id;
			$_path = $request->path;
			$_explode = explode('/', $_path);
			$_file_name = $_explode[sizeof($_explode) - 1];
			$_explode_name = explode('.', $_file_name);
			$_file_save = $_explode_name[0];

			$data_customer = DB::table('tb_customer')
				->select('*')
				->where('deleted', false)
				->where('id', $_id)
				->get()
				->first();

			if (!$data_customer) {
				return redirect()->back()->with('error', 'Data customer invalid!');
				exit();
			}

			if ($jabatan == 'Leader') {
				if (str_contains($_file_name, 'LDR')) {
					return redirect()->back()->with('error', 'Inspection is already validated by Leader!');
					exit();
				} else {
					$spreadsheet = IOFactory::load($_path);
					$sheet = $spreadsheet->getSheet(0);

					$imagePath = public_path($file_ttd);

					$drawing = new Drawing();
					$drawing->setName('TTD');
					$drawing->setDescription('TTD');
					$drawing->setPath($imagePath);
					$drawing->setCoordinates($data_customer->location_sign_leader);
					$drawing->setOffsetX(5);
					$drawing->setOffsetY(5);
					$drawing->setHeight(80);
					$drawing->setWidth(80);
					$drawing->setWorksheet($sheet);
					$sheet->setCellValue($data_customer->location_date_leader, date('Y-m-d'));
					$sheet->setCellValue($data_customer->location_name_leader, Session::get('fullname'));

					$_full_path = $data_customer->location_file . '\\' . $_file_save . "-LDR.xlsx";
					$writer = new Xlsx($spreadsheet);
					$writer->setPreCalculateFormulas(false);
					$writer->save($_full_path);

					$writer = new Xlsx($spreadsheet);
					$writer->setPreCalculateFormulas(false);
					$writer->save($_full_path);

					// FIX Excel compatibility
					$zip = new \ZipArchive();

					if ($zip->open($_full_path) === true) {
						for ($i = 1; $i <= 50; $i++) {
							$sheetPath = "xl/worksheets/sheet{$i}.xml";
							$xml = $zip->getFromName($sheetPath);

							if ($xml === false) {
								continue;
							}

							$xml = preg_replace(
								'/<ignoredErrors>.*?<\/ignoredErrors>/s',
								'',
								$xml
							);

							$zip->addFromString($sheetPath, $xml);
						}

						$zip->close();
					}

					unlink($data_customer->location_file . '\\' . $_file_name);

					return redirect()->back()->with('success', 'Leader Checked inspection success!');
				}
			} elseif ($jabatan == 'Supervisor') {
				if (str_contains($_file_name, 'SPV')) {
					return redirect()->back()->with('error', 'Inspection is already validated by Supervisor!');
					exit();
				} elseif (!str_contains($_file_name, 'LDR')) {
					return redirect()->back()->with('error', 'Inspection is not already validated by Leader!');
					exit();
				} else {
					$spreadsheet = IOFactory::load($_path);
					$sheet = $spreadsheet->getSheet(0);

					$imagePath = public_path($file_ttd);

					$drawing = new Drawing();
					$drawing->setName('TTD');
					$drawing->setDescription('TTD');
					$drawing->setPath($imagePath);
					$drawing->setCoordinates($data_customer->location_sign_spv);
					$drawing->setOffsetX(5);
					$drawing->setOffsetY(5);
					$drawing->setHeight(80);
					$drawing->setWidth(80);
					$drawing->setWorksheet($sheet);
					$sheet->setCellValue($data_customer->location_date_spv, date('Y-m-d'));
					$sheet->setCellValue($data_customer->location_name_spv, Session::get('fullname'));

					$_full_path = $data_customer->location_file . '\\' . $_file_save . "-SPV.xlsx";
					$writer = new Xlsx($spreadsheet);

					$writer->save($_full_path);

					unlink($data_customer->location_file . '\\' . $_file_name);

					//generate pdf
					$_file_pdf = $_file_save . '-SPV.pdf';

					$sofficePath = '"D:\Instalan Software\LibreOffice\Data\program\soffice.exe"';
					$inputFilePath = '"' . $_full_path . '"';
					$outputDirectory = '"' . $data_customer->location_file . '"';
					$command = "$sofficePath --headless --convert-to pdf --outdir $outputDirectory $inputFilePath";

					$output = shell_exec($command);

					return redirect()->back()->with('success', 'Supervisor Checked inspection success!');
				}
			} else {
				return redirect()->back()->with('error', 'Only Leader and Supervisor!');
			}
		}
	}

	function checkedFileBatch(Request $request)
	{
		if ($request->method('post')) {
			$arr_path = json_decode($request->path_all);
			if ($arr_path) {
			} else {
				return redirect()->back()->with('error', 'Invalid Method!');
			}

			$explode_arr = explode('?', $arr_path[0]);
			if (!$explode_arr) {
				return redirect()->back()->with('error', 'Path is not found!');
			}

			if (sizeof($explode_arr) != 2) {
				return redirect()->back()->with('error', 'Path is not found!');
			}

			$_gl_id = $explode_arr[1];


			$data_customer = DB::table('tb_customer')
				->select('*')
				->where('deleted', false)
				->where('id', $_gl_id)
				->get()
				->first();

			if (!$data_customer) {
				return redirect()->back()->with('error', 'Data customer invalid!');
				exit();
			}

			$jabatan = Session::get('role_name');
			$file_ttd = Session::get('file_ttd');
			$jml_berhasil = 0;
			foreach ($arr_path as $value) {

				if ($jabatan != 'Leader' && $jabatan != 'Supervisor' && $jabatan != 'Admin') {
					return redirect()->back()->with('error', 'Only for Leader and Supervisor!');
					exit();
				}

				if ($file_ttd == '' || $file_ttd == null) {
					return redirect()->back()->with('error', 'Your TTD is not found, please update your profile!');
					exit();
				}

				if ($value == '') {
					return redirect()->back()->with('error', 'Path is not found!');
				} else {
					$explode_arr = explode('?', $value);
					if (!$explode_arr) {
						return redirect()->back()->with('error', 'Path is not found!');
					}

					if (sizeof($explode_arr) != 2) {
						return redirect()->back()->with('error', 'Path is not found!');
					}

					$_id = $explode_arr[1];
					$_path = $explode_arr[0];
					$_explode = explode('/', $_path);
					$_file_name = $_explode[sizeof($_explode) - 1];
					$_explode_name = explode('.', $_file_name);
					$_file_save = $_explode_name[0];

					if ($jabatan == 'Leader') {
						if (str_contains($_file_name, 'LDR')) {
							return redirect()->back()->with('error', 'Inspection is already validated by Leader!');
							exit();
						} else {
							$spreadsheet = IOFactory::load($_path);
							$sheet = $spreadsheet->getSheetByName('MC KOZA');

							$imagePath = public_path($file_ttd);

							$drawing = new Drawing();
							$drawing->setName('TTD');
							$drawing->setDescription('TTD');
							$drawing->setPath($imagePath);
							$drawing->setCoordinates($data_customer->location_sign_leader);
							$drawing->setOffsetX(5);
							$drawing->setOffsetY(5);
							$drawing->setHeight(80);
							$drawing->setWidth(80);
							$drawing->setWorksheet($sheet);
							$sheet->setCellValue($data_customer->location_date_leader, date('Y-m-d'));
							$sheet->setCellValue($data_customer->location_name_leader, Session::get('fullname'));

							$_full_path = $data_customer->location_file . '\\' . $_file_save . "-LDR.xlsx";
							$writer = new Xlsx($spreadsheet);

							$writer->save($_full_path);

							unlink($data_customer->location_file . '\\' . $_file_name);

							$jml_berhasil++;
						}
					} elseif ($jabatan == 'Supervisor') {
						if (str_contains($_file_name, 'SPV')) {
							return redirect()->back()->with('error', 'Inspection is already validated by Supervisor!');
							exit();
						} elseif (!str_contains($_file_name, 'LDR')) {
							return redirect()->back()->with('error', 'Inspection is not already validated by Leader!');
							exit();
						} else {
							$spreadsheet = IOFactory::load($_path);
							$sheet = $spreadsheet->getSheet(0);

							$imagePath = public_path($file_ttd);

							$drawing = new Drawing();
							$drawing->setName('TTD');
							$drawing->setDescription('TTD');
							$drawing->setPath($imagePath);
							$drawing->setCoordinates($data_customer->location_sign_spv);
							$drawing->setOffsetX(5);
							$drawing->setOffsetY(5);
							$drawing->setHeight(80);
							$drawing->setWidth(80);
							$drawing->setWorksheet($sheet);
							$sheet->setCellValue($data_customer->location_date_spv, date('Y-m-d'));
							$sheet->setCellValue($data_customer->location_name_spv, Session::get('fullname'));

							$_full_path = $data_customer->location_file . '\\' . $_file_save . "-SPV.xlsx";
							$writer = new Xlsx($spreadsheet);

							$writer->save($_full_path);

							unlink($data_customer->location_file . '\\' . $_file_name);

							//generate pdf
							$_file_pdf = $_file_save . '-SPV.pdf';

							$sofficePath = '"C:\Program Files\LibreOffice\program\soffice.exe"';
							$inputFilePath = '"' . $_full_path . '"';
							$outputDirectory = '"' . $data_customer->location_file . '"';
							$command = "$sofficePath --headless --convert-to pdf --outdir $outputDirectory $inputFilePath";

							$output = shell_exec($command);
							$jml_berhasil;
						}
					} else {
						return redirect()->back()->with('error', 'Only Leader and Supervisor!');
					}
				}
			}

			if ($jml_berhasil > 0) {
				if ($jabatan == 'Leader') {
					return redirect()->back()->with('success', 'Leader Checked inspection success!');
				} elseif ($jabatan == 'Supervisor') {
					return redirect()->back()->with('success', 'Supervisor Checked inspection success!');
				}
			}
		} else {
			return redirect()->back()->with('error', 'Invalid Method!');
		}
	}
}
