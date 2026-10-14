<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\str;
use Symfony\Component\HttpFoundation\Response;

use App\Models\settings\UsersModel;

class Verify
{
    public function handle(Request $request, Closure $next): Response
    {
        $accessToken = \Session::get('accessToken');
        $allowed = false;

        if($accessToken) {

            /**
             * Check existing user by decoded token
             * */

            $token = \JWT::parse($accessToken);
            if($token->isValid(env('SECRET_KEY'))) {
                /**
                 * Redirect to login if validation is false
                 * */
                $user = (object) $token->getPayload();

                $data = UsersModel::where(['id' => $user->id, 'deleted' => false])->first();
                if($data) $allowed = true;
            }
        }

        /**
         * Send response
         * */

        if(!$allowed) {
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

        // cek menu akses
        $_current_url = $_SERVER['REQUEST_URI'];
        if($_current_url != '/'){
            $_explode_url = explode('/', $_current_url);
            if($_explode_url[1] != 'dashboard' && $_explode_url[1] != 'user'){
                $_logged_menus_path = Session::get('logged_menus_path');
                $_menus_flag = false;
                if($_logged_menus_path == '' || $_logged_menus_path == null){
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
                }else{
                    foreach ($_logged_menus_path as $val) {
                        if (Str::contains($_current_url, $val->path)) {
                            $_menus_flag = true;
                            break;
                        }                        
                    }

                    if($_menus_flag == false){
                        return redirect()->route('validation.list')->with('warning', 'Maaf anda tidak memiliki akses ke menu tersebut');
                    }
                }
            }
        }

        return $next($request);
    }
}
