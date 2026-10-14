<?php

namespace App\Http\Controllers\auth;

use DB;
use Cookie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\settings\UsersModel;
use Illuminate\Support\Facades\Hash;

class Login extends Controller
{

      public function index(Request $request)
      {
            if($request->isMethod('post')) {
                  $data = UsersModel::select('users.*','app_role.role_name')
                  ->leftJoin('app_role', 'users.id_role', '=', 'app_role.id')
                  ->where([
                        'users.deleted' => false,
                        'username' => $request->username
                  ])->first();

                  if(!$data) return back()->with('error', 'Username is not found!');

                  if (!Hash::check($request->password, $data->password)) {
                        return back()->with('error', 'Username and password does not match!');
                  }

                  if ($data->id_role == null || $data->id_role == '') {
                        return back()->with('error', 'User belum memiliki role!');
                  }

                  $group_menu = DB::table('app_role_menu')
                  ->leftJoin('app_menu', 'app_role_menu.id_menu', '=', 'app_menu.id')
                  ->select('group','position')
                  ->where('id_role', $data->id_role)
                  ->groupBy('app_menu.group','position')
                  ->orderBy('position','asc')
                  ->get();

                  $data_menu = DB::table('app_role_menu')
                  ->leftJoin('app_menu', 'app_role_menu.id_menu', '=', 'app_menu.id')
                  ->select('app_menu.*')
                  ->where('id_role', $data->id_role)
                  ->orderBy('position','asc')
                  ->get();

                  $app_actived_path = [];
                  foreach ($group_menu as $value) {
                        $_arr_push = [];
                        foreach ($data_menu as $v) {
                              if($value->group == $v->group){
                                    $_arr_push[] = $v;
                                    array_push($app_actived_path, $v);
                              }
                        }
                        $value->list_menus = $_arr_push;
                  }

                  $data_app_config = DB::table('app_config')
                  ->select('*')
                  ->where('deleted',false)
                  ->get();

                  $logo = '';
                  $tempat = '';
                  $nama_perusahaan = '';

                  foreach ($data_app_config as $value) {
                        if($value->param == 'LOGO'){
                              $logo = $value->isi;
                        }

                        if($value->param == 'TEMPAT'){
                              $tempat = $value->isi;
                        }

                        if($value->param == 'NAMA_PERUSAHAAN'){
                              $nama_perusahaan = $value->isi;
                        }
                  }

                  $_foto_profile = $data->foto_profile;
                  if($_foto_profile == '' || $_foto_profile == null){
                        $_foto_profile = 'assets/images/user.png';
                  }

                  $dataSession = [
                        'id' => $data->id,
                        'nip' => $data->nip,
                        'fullname' => $data->fullname,
                        'role_name' => $data->role_name,
                        'username' => $data->username,
                        'foto_profile' => $_foto_profile,
                        'file_ttd' => $data->file_ttd,
                        'logo' => $logo,
                        'tempat' => $tempat,
                        'nama_perusahaan' => $nama_perusahaan,
                        'logged_menus' => $group_menu,
                        'logged_menus_path' => $app_actived_path
                  ];

                  if($request->rememberme == 'yes'){
                        $accessToken = \JWT::get(env('SECRET_KEY'), $dataSession, now()->addMinutes(43200));
                        session([...$dataSession, 'accessToken' => $accessToken]);
                  }else{
                        $accessToken = \JWT::get(env('SECRET_KEY'), $dataSession, now()->addMinutes(480));
                        session([...$dataSession, 'accessToken' => $accessToken]);
                  }

                  return redirect()->route('validation.list');
            }

            return view('contents.auth.login');
      }

      public function logout()
      {
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

            return redirect()->route('auth.login_form')->with('warning', 'You are logged out, please login to continue');
      }

}