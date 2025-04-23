<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Members\CreateRequest;
use App\Http\Requests\Members\EditRequest;
use App\Http\Requests\Members\BulkUploadRequest;
use App\Mail\MemberRegistMail;
use App\Models\AdminBulkLog;
use App\Models\Member;
use App\Models\MemberHandling;
use App\Rules\MemberDispIDDuplicate;
use App\Rules\MemberDispIDRule;
use App\Rules\MemberPassword;
use App\Rules\MemberRegistEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MemberController extends Controller
{
    // 1ページに表示する会員件数
    const SEARCH_MEMBER_LIST_MAX = 50;

    // ページネーションの最大表示数
    const SEARCH_PAGE_LIST_MAX = 11;


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 会員一覧画面表示
     */
    public function index()
    {
        return view('members.index');
    }

    /**
     * 会員新規登録画面表示
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * 会員新規登録処理
     */
    public function store(CreateRequest $request)
    {
        \DB::beginTransaction();

        if (empty($request->disp_id)) {
            $disp_id = Member::getNextDispId(true);
        }
        else {
            $disp_id = $request->disp_id;
        }

        try {
            $member = Member::create([
                'disp_id'       => $disp_id,
                'nickname'      => $request->nickname,
                'company'       => $request->company,
                'department'    => $request->department,
                'position'      => $request->position,
                'lname'         => $request->lname,
                'fname'         => $request->fname,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'industry'      => $request->industry,
                'location'      => $request->location,
                'employee'      => $request->employee,
                'affiliation'   => $request->affiliation,
                'status'        => 4,
                'terms_agree'   => 1,
                'privacy_agree' => 1,
            ]);

            $handlings = [];
            if (!empty($request->handling)) {
                foreach ($request->handling as $handling_id) {
                    $handlings[] = new MemberHandling([
                        'member_id'     => $member->id,
                        'handling_id'   => $handling_id,
                    ]);
                }
                $member->handlings()->saveMany($handlings);
            }

            \DB::commit();
        }
        catch (\Exception $e) {
            \DB::rollback();

            throw $e;
        }

        return redirect()
                ->route('members.edit', $member->id)
                ->with('member_edit_complete', true);
    }

    /**
     * 会員編集画面表示
     */
    public function edit(Request $request)
    {
        $member = Member::findNotDeletedMember($request->member_id);
        if ($member === null) {
            abort('404');
        }

        $member_handlings = [];
        foreach ($member->handlings as $member_handling) {
            $member_handlings[] = $member_handling->handling_id;
        }

        return view('members.edit')->with([
            'member'            => $member,
            'member_handlings'  => $member_handlings,
        ]);
    }

    
    /**
     * 会員更新処理
     */
    public function update(EditRequest $request)
    {
        \DB::beginTransaction();

        try {
            $member = Member::findNotDeletedMember($request->member_id);
            if ($member === null) {
                abort('404');
            }

            $member->disp_id = $request->disp_id;
            $member->nickname = $request->nickname;
            $member->company = $request->company;
            $member->department = $request->department;
            $member->position = $request->position;
            $member->lname = $request->lname;
            $member->fname = $request->fname;
            $member->email = $request->email;
            if ($request->password !== '') {
                $member->password = Hash::make($request->password);
            }
            $member->industry = $request->industry;
            $member->location = $request->location;
            $member->employee = $request->employee;
            $member->affiliation = $request->affiliation;
            $member->save();

            $member->handlings()->delete();
            $handlings = [];
            if (!empty($request->handling)) {
                foreach ($request->handling as $handling_id) {
                    $handlings[] = new MemberHandling([
                        'member_id'     => \Auth::Id(),
                        'handling_id'   => $handling_id,
                    ]);
                }
            }
            $member->handlings()->saveMany($handlings);

            \DB::commit();
        }
        catch (\Exception $e) {
            \DB::rollback();

            throw $e;
        }

        return redirect()
                ->route('members.edit', $request->member_id)
                ->with('member_edit_complete', true);
    }

    /**
     * 会員検索
     */
    public function search_ajax(Request $request)
    {
        $conditions = [
            'status'        => $request->status,
            'keyword'       => $request->keyword,
            'sort_by'       => $request->sort_by,
            'sort_order'    => $request->sort_order,
            'page'          => $request->page,
            'limit'         => self::SEARCH_MEMBER_LIST_MAX,
        ];

        list($members, $members_count) = Member::searchForAdmin($conditions);

        $page = (int) $request->page;
        if ($page <= 0) $page = 1;

        $page_info = [];
        $page_info['now_page'] = $page;
        $page_info['all_last_page'] = ceil($members_count / self::SEARCH_MEMBER_LIST_MAX);
        $page_info['first_page'] = $page_info['now_page'] - floor(self::SEARCH_PAGE_LIST_MAX / 2);
        if ($page_info['first_page'] < 1) {
            $page_info['first_page'] = 1;
        }

        $page_info['last_page'] = $page_info['first_page'] + self::SEARCH_PAGE_LIST_MAX - 1;
        if ($page_info['last_page'] > $page_info['all_last_page']) {
            $page_info['last_page'] = $page_info['all_last_page'];
            $page_info['first_page'] = $page_info['last_page'] - self::SEARCH_PAGE_LIST_MAX + 1;
            if ($page_info['first_page'] < 1) {
                $page_info['first_page'] = 1;
            }
        }

        $tbody_html = view('members.search_tbody')
                ->with('members', $members)
                ->render();

        $pager_html = view('members.search_pager')
                ->with('page_info', $page_info)
                ->render();

        $response = [
            'tbody' => $tbody_html,
            'pager' => $pager_html,
        ];

        return response()->json($response);
    }

    /**
     * 一括ステータス変更処理
     */
    public function bulk_update(Request $request)
    {
        if (!is_array($request->member_id) || !in_array($request->blk_action, [3, 4, 6])) {
            return redirect()->route('members');
        }

        $update_status = $request->blk_action;

        \DB::beginTransaction();

        foreach ($request->member_id as $member_id) {

            try {
                $member = Member::findNotDeletedMember($member_id);
                if ($member === null) continue;

                $old_status = $member->status;
                $member->status = $update_status;
                $member->save();

                \DB::commit();

                // 仮登録から有効の場合は本登録完了メール送信
                if ($old_status == 2 && $update_status == 4) {
                    \Mail::to($member->email)
                            ->send(new MemberRegistMail());
                }
            }
            catch (\Exception $e) {
                \DB::rollback();

                throw $e;
            }
        }

        return redirect()
                ->route('members', $request->member_id)
                ->with('member_bulk_update_complete', '保存しました');
    }

    /**
     * 会員一括操作画面表示
     */
    public function bulk()
    {
        return view('members.bulk');
    }

    /**
     * 会員一括操作画面表示
     */
    public function bulk_download(Request $request)
    {
        $file_name = now()->format('Ymd') . '_members.csv';
        $headers = [
            'Content-Type'          => 'application/octet-stream',
            'Content-Disposition'   => 'attachment; filename="' . $file_name . '"',
        ];

        $streamed_response = new StreamedResponse(function () {
                $stream = fopen('php://output', 'w');

                $const = config('const');

                $csv_headers = [
                    '会員ID',
                    'ステータス',
                    'ニックネーム',
                    '会社名',
                    '部署名',
                    '役職',
                    '姓',
                    '名',
                    'メールアドレス',
                    '業種',
                    '勤務地',
                    '従業員規模',
                    '所属部門',
                    '取扱いデータ',
                    '最終ログイン日時',
                    '登録日時',
                ];

                $csv_header = '"' . mb_convert_encoding(implode('","', $csv_headers), 'SJIS-win', 'UTF-8') . "\"\r\n";
                fwrite($stream, $csv_header);

                $db_members = Member::whereIn('status', [2, 3, 4, 5])
                        ->with('handlings')
                        ->orderBy('disp_id', 'ASC')
                        ->get();

                foreach ($db_members as $db_member) {
                    $handlings = [];
                    foreach ($db_member->handlings as $db_member_handling) {
                        if (isset($const['member']['handling'][$db_member_handling->handling_id])) {
                            $handlings[] = $const['member']['handling'][$db_member_handling->handling_id];
                        }
                    }

                    $csv_bodies = [
                        $db_member->disp_id,
                        isset($const['member']['status'][$db_member->status]) ? $const['member']['status'][$db_member->status] : '',
                        $db_member->nickname,
                        $db_member->company,
                        $db_member->department,
                        $db_member->position,
                        $db_member->lname,
                        $db_member->fname,
                        $db_member->email,
                        isset($const['member']['industry'][$db_member->industry]) ? $const['member']['industry'][$db_member->industry] : '',
                        isset($const['member']['location'][$db_member->location]) ? $const['member']['location'][$db_member->location] : '',
                        isset($const['member']['employee'][$db_member->employee]) ? $const['member']['employee'][$db_member->employee] : '',
                        isset($const['member']['affiliation'][$db_member->affiliation]) ? $const['member']['affiliation'][$db_member->affiliation] : '',
                        implode('|', $handlings),
                        $db_member->last_loggedin_at,
                        $db_member->created_at,
                    ];

                    array_walk($csv_bodies, function(&$value) {
                        $value = str_replace('"', '""', (string) $value);
                    });

                    $csv_body = '"' . mb_convert_encoding(implode('","', $csv_bodies), 'SJIS-win', 'UTF-8') . "\"\r\n";
                    fwrite($stream, $csv_body);
                }
            },
            \Illuminate\Http\Response::HTTP_OK,
            $headers
        );

        $admin_bulk_log = AdminBulkLog::create([
            'admin_id'  => \Auth::id(),
            'ip'        => $request->ip(),
            'action'    => 1,
        ]);

        return $streamed_response;
    }

    /**
     * 会員一括登録用テンプレートダウンロード
     */
    public function bulk_template_download(Request $request)
    {
        $file_name = 'upload_members_template.csv';
        $headers = [
            'Content-Type'          => 'application/octet-stream',
            'Content-Disposition'   => 'attachment; filename="' . $file_name . '"',
        ];

        $streamed_response = new StreamedResponse(function () {
                $stream = fopen('php://output', 'w');

                $const = config('const');

                $industry_list = [];
                foreach ($const['member']['industry'] as $value => $label) {
                    $industry_list[] = "{$value}={$label}";
                }

                $location_list = [];
                foreach ($const['member']['location'] as $value => $label) {
                    $location_list[] = "{$value}={$label}";
                }

                $employee_list = [];
                foreach ($const['member']['employee'] as $value => $label) {
                    $employee_list[] = "{$value}={$label}";
                }

                $affiliation_list = [];
                foreach ($const['member']['affiliation'] as $value => $label) {
                    $affiliation_list[] = "{$value}={$label}";
                }

                $handling_list = [];
                foreach ($const['member']['handling'] as $value => $label) {
                    $handling_list[] = "{$value}={$label}";
                }

                $csv_headers = [
                    '会員ID（任意）（省略時は自動設定）',
                    'ニックネーム（任意）',
                    '会社名（必須）',
                    '部署名（必須）',
                    '役職（任意）',
                    '姓（必須）',
                    '名（必須）',
                    'メールアドレス（必須）',
                    'パスワード（必須）',
                    '業種（任意）（' . implode('、', $industry_list) . '）',
                    '勤務地（任意）（' . implode('、', $location_list) . '）',
                    '従業員規模（任意）（' . implode('、', $employee_list) . '）',
                    '所属部門（任意）（' . implode('、', $affiliation_list) . '）',
                    '取扱いデータ（任意、パイプ(|)区切りで複数入力可）（' . implode('、', $handling_list) . '）',
                ];

                $csv_header = '"' . mb_convert_encoding(implode('","', $csv_headers), 'SJIS-win', 'UTF-8') . "\"\r\n";
                fwrite($stream, $csv_header);
            },
            \Illuminate\Http\Response::HTTP_OK,
            $headers
        );

        return $streamed_response;
    }

    /**
     * 会員一括登録ファイルアップロード
     */
    public function bulk_upload(BulkUploadRequest $request)
    {
        \DB::beginTransaction();

        $validator_rules = [
            'disp_id'               => ['required',  new MemberDispIDRule('・:attribute：半角英字1文字、半角数字6文字で入力してください'), new MemberDispIDDuplicate(null, '・:attribute：その会員IDは登録できません')],
            'nickname'              => ['nullable', 'alpha_num', 'between:6,12'],
            'company'               => ['required'],
            'department'            => ['required'],
            'position'              => [],
            'lname'                 => ['required'],
            'fname'                 => ['required'],
            'email'                 => ['required', 'email:rfc', new MemberRegistEmail(null, '・:attribute：そのメールアドレスは登録できません')],
            'password'              => ['required', 'min:8', new MemberPassword('・:attribute：半角数字、半角英数(大文字、小文字)を組み合わせてください')],
            'industry'              => ['nullable', Rule::in(array_keys(config('const.member.industry')))],
            'location'              => ['nullable', Rule::in(array_keys(config('const.member.location')))],
            'employee'              => ['nullable', Rule::in(array_keys(config('const.member.employee')))],
            'affiliation'           => ['nullable', Rule::in(array_keys(config('const.member.affiliation')))],
            'handling'              => ['nullable', 'array'],
            'handling.*'            => [Rule::in(array_keys(config('const.member.handling')))],
        ];

        $validator_messages = [
            'required'                          => '・:attribute：必ず入力してください',
            'alpha_num'                         => '・:attribute：半角英数字を入力してください',
            'between'                           => '・:attribute：:min～:max文字で入力してください',
            'email'                             => '・:attribute：有効なメールアドレスを入力してください',
            'min'                               => '・:attribute：:min文字以上入力してください',
            'in'                                => '・:attribute：選択肢から選択してください',
        ];

        try {
            $csv_file = new \SplFileObject($request->file('bulk_upload_file')->getPathname());
            $csv_file->setFlags(
                \SplFileObject::READ_CSV |
                \SplFileObject::READ_AHEAD |
                \SplFileObject::SKIP_EMPTY
            );

            $errors = [];
            $regist_count = 0;
            $first_disp_id = '';

            $row = 0;
            while (!$csv_file->eof()) {
                $row++;
                $cells = $csv_file->fgetcsv();

                if ($row === 1) continue;
                if ($cells === null) continue;
                $cells_count = count($cells);
                if ($cells_count === 1 && $cells[0] === '') continue;

                if ($cells_count !== 14) {
                    $errors['bulk_upload_file'] = [
                        "【{$row}行目】",
                        "・データの個数が異なります。正しいCSVファイルを指定してください",
                    ];
                    break;
                }

                $member = [
                    'disp_id'       => $cells[0],
                    'nickname'      => $cells[1],
                    'company'       => $cells[2],
                    'department'    => $cells[3],
                    'position'      => $cells[4],
                    'lname'         => $cells[5],
                    'fname'         => $cells[6],
                    'email'         => $cells[7],
                    'password'      => $cells[8],
                    'industry'      => $cells[9],
                    'location'      => $cells[10],
                    'employee'      => $cells[11],
                    'affiliation'   => $cells[12],
                    'handling'      => $cells[13],
                ];

                foreach ($member as $index => &$value) {
                    $value = mb_convert_encoding(trim($value), 'UTF-8', 'SJIS-win');

                    if ($index === 'disp_id') {
                        if ($value === '') {
                            $value = Member::getNextDispId(true);
                            if ($first_disp_id === '') {
                                $first_disp_id = $value;
                            }
                        }
                    }
                    elseif ($index === 'industry' || $index === 'location' || $index === 'employee' || $index === 'affiliation') {
                        if ($value === '') {
                            $value = null;
                        }
                    }
                    elseif ($index === 'handling') {
                        if ($value === '') {
                            $value = [];
                        }
                        else {
                            $value = explode('|', $value);
                        }
                    }
                }
                $member['status'] = 4;
                $member['terms_agree'] = 1;
                $member['privacy_agree'] = 1;

                $validator = Validator::make($member, $validator_rules, $validator_messages);
                if ($validator->fails()) {
                    $errors['bulk_upload_file'] = array_merge(["【{$row}行目】"], $validator->errors()->all());
                    break;
                }

                $member['password'] = Hash::make($member['password']);

                $db_member = Member::create($member);
    
                $handlings = [];
                if (!empty($member['handling'])) {
                    foreach ($member['handling'] as $handling_id) {
                        $handlings[] = new MemberHandling([
                            'member_id'     => $db_member->id,
                            'handling_id'   => $handling_id,
                        ]);
                    }
                    $db_member->handlings()->saveMany($handlings);
                }

                $regist_count++;
            }
        }
        catch (\Exception $e) {
            \DB::rollback();
            $this->revert_disp_id($first_disp_id);

            throw $e;
        }

        if (empty($errors) && $regist_count === 0) {
            $errors['bulk_upload_file'] = 'データが1件もありませんでした';
        }

        if (empty($errors)) {
            $admin_bulk_log = AdminBulkLog::create([
                'admin_id'  => \Auth::id(),
                'ip'        => $request->ip(),
                'action'    => 2,
            ]);

            \DB::commit();

            return redirect()->route('members.bulk')
                    ->with('member_bulk_update_complete', "{$regist_count}件の会員情報を登録しました");
        }
        else {
            \DB::rollback();
            $this->revert_disp_id($first_disp_id);

            return redirect()->route('members.bulk')
                    ->withErrors($errors);
        }
    }

    /**
     * 一括登録時に進行させた会員IDの増分を元に戻す
     */
    private function revert_disp_id($disp_id) {
        if ($disp_id === '') return;

        $disp_id_file_path = env('MEMBER_APP_ROOT_DIR') . 'storage/app/disp_id_counter.dat';
        if (!file_exists($disp_id_file_path)) return;

        $disp_id_file = fopen($disp_id_file_path, 'w');
        flock($disp_id_file, LOCK_EX);

        $prefix = substr($disp_id, 0, 1);
        $id = ((int) substr($disp_id, 1)) - 1;

        fwrite($disp_id_file, "{$prefix},{$id}");
        fclose($disp_id_file);
    }
}
