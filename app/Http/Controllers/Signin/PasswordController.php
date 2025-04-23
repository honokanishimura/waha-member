<?php

namespace App\Http\Controllers\Signin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Signin\PasswordRequest;
use App\Mail\AdminPasswordResetRequestMail;
use App\Models\Admin;
use Illuminate\Support\Str;

class PasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * パスワードを忘れた方へページ表示
     */
    public function index()
    {
        return view('signin.password.index');
    }

    /**
     * パスワード再設定用トークン発行処理
     */
    public function store(PasswordRequest $request)
    {
        \DB::beginTransaction();

        try {
            $admin = Admin::getAvailableAdminByEmail($request->email);

            if ($admin === null) {
                \Session::flash('global_error', '入力されたメールアドレスがアカウントと一致しません。');
                return redirect()->route('signin.password')->withInput();
            }

            do {
                $password_token = hash('sha256', Str::random(60));
            } while (Admin::where('password_reset_token', $password_token)->exists());

            $admin->password_reset_token = $password_token;
            $admin->password_reset_token_sent_at = now();
            $admin->save();

            \DB::commit();
        }
        catch (\Exception $e) {
            \DB::rollback();

            throw $e;
        }

        \Mail::to($admin->email)
                ->send(new AdminPasswordResetRequestMail($password_token));

        return redirect()->route('signin.password.complete');
    }

    /**
     * パスワード再設定用トークン発行処理完了画面表示
     */
    public function complete()
    {
        return view('signin.password.complete');
    }
}
