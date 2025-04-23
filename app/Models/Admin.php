<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    /**
     * 指定したメールアドレスの有効なステータスの会員情報を取得
     */
    public static function getAvailableAdminByEmail($email)
    {
        $admin = self::where('email', $email)
                ->where('status', 4)
                ->lockForUpdate()
                ->first();

        return $admin;
    }

    /**
     * パスワードリセットトークンからリセット可能かどうかを判定する
     */
    public static function verifyPasswordResetByToken($token)
    {
        if ($token === null) return null;

        $expiration = new \DateTime();
        $expiration->modify('-3days');

        $admin = self::where('password_reset_token', $token)
                ->where('password_reset_token_sent_at', '>=', $expiration->format('Y-m-d H:i:s'))
                ->where('status', 4)
                ->lockForUpdate()
                ->first();

        return $admin;
    }

}
