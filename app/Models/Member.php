<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    const DISP_ID_FILE_NAME = 'disp_id_counter.dat';

    protected $primaryKey = 'id';

    protected $fillable = [
        'disp_id',
        'nickname',
        'company',
        'department',
        'position',
        'lname',
        'fname',
        'email',
        'email_token',
        'email_token_sent_at',
        'password',
        'status',
        'rank',
        'terms_agree',
        'privacy_agree',
        'industry',
        'location',
        'employee',
        'affiliation',
    ];

    public function handlings()
    {
        return $this->hasMany('App\Models\MemberHandling');
    }

    /**
     * 仮登録用トークンから仮登録可能かどうかを判定する
     */
    public static function verifyEmailByToken($token)
    {
        if ($token === null) return null;

        $expiration = new \DateTime();
        $expiration->modify('-3days');

        $member = self::where('email_token', $token)
                ->where('email_token_sent_at', '>=', $expiration->format('Y-m-d H:i:s'))
                ->where('status', 1)
                ->lockForUpdate()
                ->first();

        if ($member === null) return null;

        if (!self::isRegistableEmail($member->email)) {
            return null;
        }

        return $member;
    }

    /**
     * 指定したメールアドレスが登録可能かどうかを判定する
     */
    public static function isRegistableEmail($email, $exclude_member_id = null)
    {
        $query = self::where('email', $email)
            ->whereIn('status', [2, 3, 4]);

        if ($exclude_member_id !== null) {
            $query = $query->where('id', '!=', $exclude_member_id);
        }

        return $query->doesntExist();
    }

    /**
     * 次の会員IDを取得して返す
     */
    public static function getNextDispId($admin_mode = false)
    {
        if ($admin_mode) {
            $disp_id_file_path = env('MEMBER_APP_ROOT_DIR') . 'storage/app/disp_id_counter.dat';
        }
        else {
            $disp_id_file_path = storage_path('app/disp_id_counter.dat');
        }

        if (!file_exists($disp_id_file_path)) {
            $disp_id_file = fopen($disp_id_file_path, 'w');
            flock($disp_id_file, LOCK_EX);
            $prefix = 'A';
            $id = 1999;
        }
        else {
            $disp_id_file = fopen($disp_id_file_path, 'r+');
            flock($disp_id_file, LOCK_EX);
            list($prefix, $id) = explode(',', fgets($disp_id_file));
            rewind($disp_id_file);
        }

        do {
            $id++;
            $disp_id = sprintf('%s%06d', $prefix, $id);
        } while(!Member::isRegistableDispID($disp_id));

        fwrite($disp_id_file, "{$prefix},{$id}");

        return $disp_id;
    }

    /**
     * 指定した表示用会員IDが登録可能かどうかを判定する
     */
    public static function isRegistableDispID($disp_id, $exclude_member_id = null)
    {
        $query = self::where('disp_id', $disp_id)
            ->whereIn('status', [2, 3, 4, 5, 6]);

        if ($exclude_member_id !== null) {
            $query = $query->where('id', '!=', $exclude_member_id);
        }

        return $query->doesntExist();
    }

    /**
     * 指定したメールアドレスの有効なステータスの会員情報を取得
     */
    public static function getAvailableMemberByEmail($email)
    {
        $member = self::where('email', $email)
                ->where('status', 4)
                ->lockForUpdate()
                ->first();

        return $member;
    }

    /**
     * パスワードリセットトークンからリセット可能かどうかを判定する
     */
    public static function verifyPasswordResetByToken($token)
    {
        if ($token === null) return null;

        $expiration = new \DateTime();
        $expiration->modify('-3days');

        $member = self::where('password_reset_token', $token)
                ->where('password_reset_token_sent_at', '>=', $expiration->format('Y-m-d H:i:s'))
                ->where('status', 4)
                ->lockForUpdate()
                ->first();

        return $member;
    }

    /**
     * 削除以外の会員を検索
     */
    public static function findNotDeletedMember($id)
    {
        return self::where('id', $id)
                ->whereIn('status', [2, 3, 4, 5])
                ->lockForUpdate()
                ->first();
    }

    /**
     * 削除も退会もされていない会員を検索
     */
    public static function findNotDeletedAndWithdrawnMember($id)
    {
        return self::where('id', $id)
                ->whereIn('status', [2, 3, 4])
                ->lockForUpdate()
                ->first();
    }

    /**
     * 会員管理画面用会員検索
     */
    public static function searchForAdmin($condition)
    {
        $members = self::select([
            'id', 'disp_id',
            'lname', 'fname',
            'company', 'department', 'email',
            'status', 'last_loggedin_at', 'created_at',
        ]);

        $members->whereIn('status', [2, 3, 4, 5]);
        if ($condition['status'] !== null) {
            $members->where('status', $condition['status']);
        }

        if ($condition['keyword'] !== null && $condition['keyword'] !== '') {
            $keywords = explode(' ', str_replace('　', ' ', $condition['keyword']));

            foreach ($keywords as $keyword) {
                if ($keyword === '') continue;

                $members->where(\DB::raw("CONCAT(disp_id, ' ', lname, ' ', fname, ' ', company, ' ', department, ' ', COALESCE(email, ''))"), 'LIKE', "%{$keyword}%");
            }

        }

        if ($condition['sort_by'] !== null && $condition['sort_order'] !== null) {
            if ($condition['sort_by'] === 'name') {
                $members->orderBy(\DB::raw("CONCAT(lname, ' ', fname)"), $condition['sort_order']);
            }
            else {
                $members->orderBy($condition['sort_by'], $condition['sort_order']);
            }
        }
        else {
            $members->orderBy('disp_id', 'desc');
        }

        $members_count = clone $members;
        $members_count = $members_count->count();

        if ($condition['page'] !== null) {
            $members->offset(($condition['page'] - 1) * $condition['limit']);
        }

        $members->limit($condition['limit']);

        return [$members->get(), $members_count];
    }
}
