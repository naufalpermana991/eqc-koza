<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\UsersModel;
use App\Http\Controllers\Controller;

class Users extends Controller
{
	public function index(Request $request)
	{
		$data = UsersModel::select('users.*','app_role.role_name')
		->leftJoin('app_role','app_role.id','=','users.id_role')
		->where('users.deleted', false)
		->orderBy('username','asc')
		->get();

		$role = DB::table('app_role')->select('*')
		->orderBy('role_name','asc')
		->get();

		return view('layouts.app', [
			'title' => 'User',
			'data' => $data,
			'role' => $role,
			'content' => 'contents.users.list'
		]);
	}

	public function create(Request $request)
	{
		if($request->isMethod('post')) {
			$username = $request->username;
			$nip = $request->nip;
			$fullname = $request->fullname;
			$id_role = $request->id_role;
			$password = Hash::make($request->password);

			$check_username = UsersModel::select('id')
			->where('username',$username)
			->where('deleted', false)
			->get()
			->count();

			if($check_username > 0){
				return redirect()->back()->with('error', 'username sudah ada!');
				exit();
			}

			try {
				DB::beginTransaction();

				$_file_foto = '';
				$_file_ttd = '';
				if($_FILES['foto_profile']['name'] != ''){
					$_filename = $_FILES['foto_profile']['name'];
					$_file_extention = pathinfo($_filename,PATHINFO_EXTENSION);
					$_file_extention = strtolower($_file_extention);
					$_valid_extention = array("jpg","png","jpeg");
					$_basic_path = 'assets/foto_profile/';
					$_file_name = "foto_profile_".$username.date('Ymdhis').".".$_file_extention;
					$_full_path = $_basic_path.$_file_name;

					if(in_array(strtolower($_file_extention), $_valid_extention)) {
						if($_file_foto != '' && $_file_foto != null){
							unlink($_file_foto);
						}
						$_file = $request->file('foto_profile');
						$_file->move($_basic_path, $_file_name);
						$_file_foto = $_full_path;
					}else{
						return redirect()->back()->with('error', 'File extention is not valid (only .jpg, .jpeg, .png)!');
						exit();
					}
				}

				if($_FILES['file_ttd']['name'] != ''){
					$_filename = $_FILES['file_ttd']['name'];
					$_file_extention = pathinfo($_filename,PATHINFO_EXTENSION);
					$_file_extention = strtolower($_file_extention);
					$_valid_extention = array("jpg","png","jpeg");
					$_basic_path = 'assets/ttd/';
					$_file_name = "ttd_".$username.date('Ymdhis').".".$_file_extention;
					$_full_path = $_basic_path.$_file_name;

					if(in_array(strtolower($_file_extention), $_valid_extention)) {
						if($_file_ttd != '' && $_file_ttd != null){
							unlink($_file_ttd);
						}
						$_file = $request->file('file_ttd');
						$_file->move($_basic_path, $_file_name);
						$_file_ttd = $_full_path;
					}else{
						return redirect()->back()->with('error', 'File extention is not valid (only .jpg, .jpeg, .png)!');
						exit();
					}
				}

				$insert_data = [
					'username' => $username,
					'nip' => $nip,
					'fullname' => $fullname,
					'id_role' => $id_role,
					'password' => $password,
					'foto_profile' => $_file_foto,
					'file_ttd' => $_file_ttd,

				];

				UsersModel::create($insert_data);
				DB::commit();
				return redirect()->route('user.list')->with('success', 'Add New user Success!');
			} catch (Exception $e) {
				DB::rollBack();
				return redirect()->back()->with('error', 'Add New user Failed!');
			}
		}else{
			return redirect()->back()->with('error', 'Data is not found!');
		}
	}

	public function getData(Request $request)
	{
		$data = UsersModel::select('*')
		->where('users.id', $request->id)
		->where('users.deleted', false)
		->get()
		->first();

		echo json_encode($data);
	}

	public function update(Request $request)
	{
		if($request->isMethod('post')) {
			$id = $request->id;
			$nip = $request->nip;
			$fullname = $request->fullname;
			$id_role = $request->id_role;

			$check_data = UsersModel::select('*')
			->where('id',$id)
			->where('deleted', false)
			->get()
			->first();

			if(!$check_data){
				return redirect()->back()->with('error', 'user tidak ditemukan!');
				exit();
			}

			try {
				DB::beginTransaction();

				$_file_foto = $check_data->foto_profile;
				$_file_ttd = $check_data->file_ttd;
				if($_FILES['foto_profile']['name'] != ''){
					$_filename = $_FILES['foto_profile']['name'];
					$_file_extention = pathinfo($_filename,PATHINFO_EXTENSION);
					$_file_extention = strtolower($_file_extention);
					$_valid_extention = array("jpg","png","jpeg");
					$_basic_path = 'assets/foto_profile/';
					$_file_name = "foto_profile_".$check_data->username.date('Ymdhis').".".$_file_extention;
					$_full_path = $_basic_path.$_file_name;

					if(in_array(strtolower($_file_extention), $_valid_extention)) {
						if($_file_foto != '' && $_file_foto != null){
							unlink($_file_foto);
						}
						$_file = $request->file('foto_profile');
						$_file->move($_basic_path, $_file_name);
						$_file_foto = $_full_path;
					}else{
						return redirect()->back()->with('error', 'File extention is not valid (only .jpg, .jpeg, .png)!');
						exit();
					}
				}

				if($_FILES['file_ttd']['name'] != ''){
					$_filename = $_FILES['file_ttd']['name'];
					$_file_extention = pathinfo($_filename,PATHINFO_EXTENSION);
					$_file_extention = strtolower($_file_extention);
					$_valid_extention = array("jpg","png","jpeg");
					$_basic_path = 'assets/ttd/';
					$_file_name = "ttd_".$check_data->username.date('Ymdhis').".".$_file_extention;
					$_full_path = $_basic_path.$_file_name;

					if(in_array(strtolower($_file_extention), $_valid_extention)) {
						if($_file_ttd != '' && $_file_ttd != null){
							unlink($_file_ttd);
						}
						$_file = $request->file('file_ttd');
						$_file->move($_basic_path, $_file_name);
						$_file_ttd = $_full_path;
					}else{
						return redirect()->back()->with('error', 'File extention is not valid (only .jpg, .jpeg, .png)!');
						exit();
					}
				}

				$update_data = [
					'nip' => $nip,
					'fullname' => $fullname,
					'id_role' => $id_role,
					'foto_profile' => $_file_foto,
					'file_ttd' => $_file_ttd,

				];

				UsersModel::where('id',$id)->update($update_data);
				DB::commit();
				return redirect()->route('user.list')->with('success', 'Edi user Success!');
			} catch (Exception $e) {
				DB::rollBack();
				return redirect()->back()->with('error', 'Edit user Failed!');
			}
		}else{
			return redirect()->back()->with('error', 'Data is not found!');
		}
	}

	public function deleteData(Request $request)
	{
		$check_data = UsersModel::select('*')
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
			UsersModel::where(['id' => $request->id])->update($update_data);
			return redirect()->back()->with('success', 'Delete user success!');
		}
	}

	public function getProfile(Request $request)
	{
		$id = Session::get('id');
		$data = UsersModel::select('nip','fullname','file_ttd','foto_profile','role_name')
		->leftJoin('app_role','app_role.id', '=','users.id_role')
		->where('users.id', $id)
		->where('users.deleted', false)
		->get()
		->first();

		echo json_encode($data);
	}

	public function changePassword(Request $request)
	{
		if($request->isMethod('post')) {
			$data = [
				'password' => Hash::make($request->new_password)
			];
			UsersModel::where(['id' => Session::get('id')])->update($data);

			echo json_encode('sukses');
		}
	}

	public function updateProfile(Request $request)
	{
		$id = Session::get('id');
		$data = UsersModel::select('nip','fullname','file_ttd','foto_profile','role_name')
		->leftJoin('app_role','app_role.id', '=','users.id_role')
		->where('users.id', $id)
		->where('users.deleted', false)
		->get()
		->first();

		if(!$data){
			session()->forget('id');
			session()->forget('nip');
			session()->forget('fullname');
			session()->forget('role_name');
			session()->forget('username');
			session()->forget('foto_profile');
			session()->forget('file_ttd');
			session()->forget('logo');
			session()->forget('tempat');
			session()->forget('nama_perusahaan');
			session()->forget('logged_menus');
			session()->forget('logged_menus_path');
			session()->forget('accessToken');
			session()->flush();

			return redirect()->route('auth.login_form')->with('warning', 'Your token is expired');
		}

		$fullname = $request->fullname;
		$_file_foto = $data->foto_profile;
		$_file_ttd = $data->file_ttd;
		if($_FILES['foto_profile']['name'] != ''){
			$_filename = $_FILES['foto_profile']['name'];
			$_file_extention = pathinfo($_filename,PATHINFO_EXTENSION);
			$_file_extention = strtolower($_file_extention);
			$_valid_extention = array("jpg","png","jpeg");
			$_basic_path = 'assets/foto_profile/';
			$_file_name = "foto_profile_".$id.date('Ymdhis').".".$_file_extention;
			$_full_path = $_basic_path.$_file_name;

			if(in_array(strtolower($_file_extention), $_valid_extention)) {
				if($_file_foto != '' && $_file_foto != null){
					unlink($_file_foto);
				}
				$_file = $request->file('foto_profile');
				$_file->move($_basic_path, $_file_name);
				$_file_foto = $_full_path;
			}else{
				return redirect()->back()->with('error', 'File extention is not valid (only .jpg, .jpeg, .png)!');
				exit();
			}
		}

		if($_FILES['file_ttd']['name'] != ''){
			$_filename = $_FILES['file_ttd']['name'];
			$_file_extention = pathinfo($_filename,PATHINFO_EXTENSION);
			$_file_extention = strtolower($_file_extention);
			$_valid_extention = array("jpg","png","jpeg");
			$_basic_path = 'assets/ttd/';
			$_file_name = "ttd_".$id.date('Ymdhis').".".$_file_extention;
			$_full_path = $_basic_path.$_file_name;

			if(in_array(strtolower($_file_extention), $_valid_extention)) {
				if($_file_ttd != '' && $_file_ttd != null){
					unlink($_file_ttd);
				}
				$_file = $request->file('file_ttd');
				$_file->move($_basic_path, $_file_name);
				$_file_ttd = $_full_path;
			}else{
				return redirect()->back()->with('error', 'File extention is not valid (only .jpg, .jpeg, .png)!');
				exit();
			}
		}

		$update_data = [
			'fullname' => $fullname,
			'foto_profile' => $_file_foto,
			'file_ttd' => $_file_ttd,
		];

		UsersModel::where(['id' => $id])->update($update_data);

		session()->forget('id');
		session()->forget('nip');
		session()->forget('fullname');
		session()->forget('role_name');
		session()->forget('username');
		session()->forget('foto_profile');
		session()->forget('file_ttd');
		session()->forget('logo');
		session()->forget('tempat');
		session()->forget('nama_perusahaan');
		session()->forget('logged_menus');
		session()->forget('logged_menus_path');
		session()->forget('accessToken');
		session()->flush();

		return redirect()->route('auth.login_form')->with('success', 'Update Profile Success, Silahkan login ulang');

	}

}