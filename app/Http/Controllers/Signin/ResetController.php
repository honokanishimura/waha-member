<?php

namespace App\Http\Controllers\Signin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Signin\ResetRequest;
use App\Mail\AdminPasswordResetCompleteMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * パスワードを忘れた方へページ表示
     */
    public function verify(Request $request)
    {
        $admin = Admin::verifyPasswordResetByToken($request->token);
        if ($admin === null) {
            abort(404);
        }

        return view('signin.reset.index');
    }

    /**
     * パスワード再設定用トークン発行処理
     */
    public function store(ResetRequest $request)
    {
        \DB::beginTransaction();

        try {
            $admin = Admin::verifyPasswordResetByToken($request->password_reset_token);

            if ($admin === null) {
                abort(404);
            }

            $admin->password = Hash::make($request->password);
            $admin->password_reset_token = null;
            $admin->password_reset_token_sent_at = null;
            $admin->save();

            \DB::commit();
        }
        catch (\Exception $e) {
            \DB::rollback();

            throw $e;
        }

        \Mail::to($admin->email)
                ->send(new AdminPasswordResetCompleteMail());

        return redirect()->route('signin.reset.complete');
    }

    /**
     * パスワード再設定完了画面表示
     */
    public function complete()
    {
        return view('signin.reset.complete');
    }
}
