<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SigninRequest;
use App\Mail\AdminLoginMail;
use App\Models\Admin;
use App\Models\AdminLogin;

class SigninController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('signout');
    }

    /**
     * サインイン画面表示
     */
    public function index()
    {
        return view('index');
    }

    /**
     * ログイン処理
     */
    public function signin(SigninRequest $request)
    {
        $login_result = \Auth::attempt([
            'email'     => $request->Input('login-email'),
            'password'  => $request->Input('login-password'),
            'status'    => 4,
        ]);

        if (!$login_result) {
            \Session::flash('login_global_error', '入力されたメールアドレスまたはパスワードがアカウントと一致しません。');
            return redirect()->route('signin')->withInput();
        }

        \DB::beginTransaction();

        try {
            $login_admin = \Auth::user();

            $admin_login = AdminLogin::create([
                'admin_id' => $login_admin->id,
                'ip'       => $request->ip(),
            ]);

            $login_admin->last_loggedin_at = $admin_login->created_at;
            $login_admin->save();

            \DB::commit();
        }
        catch (\Exception $e) {
            \DB::rollback();

            throw $e;
        }
    
        \Mail::to($login_admin['email'])
                ->send(new AdminLoginMail($login_admin->last_loggedin_at));

        $redirect_path = '/members';
        if (session()->exists('signin_redirect_path')) {
            $redirect_path = '/' . session()->get('signin_redirect_path');
            session()->forget('signin_redirect_path');
        }

        return redirect($redirect_path);
    }

    /**
     * ログアウト処理
     */
    public function signout()
    {
        \Auth::logout();

        return redirect()->route('signin');
    }
}
