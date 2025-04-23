@extends('_emails.html.layouts.common')

@section('contents')
  <div style="margin:0px auto;max-width:600px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
      <tbody>
        <tr>
          <td style="direction:ltr;font-size:0px;padding:12px 20px 10px;text-align:center;vertical-align:top;">
<!--[if mso | IE]>
            <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:600px;">
<![endif]-->
            <div class="dys-column-per-100 outlook-group-fix" style="direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;">
              <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                <tr>
                  <td align="left" style="padding:3px 15px;background:#fff0f0;">
<!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="mso-line-height-rule:exactly;mso-line-height-alt:20px;">
<![endif]-->
                    <p style="font-size:12px;font-family:'Noto Sans JP','ヒラギノ角ゴ Pro W3',メイリオ,sans-serif;font-weight:light;line-height:20px;text-align:left;color:#999999;word-break:break-all;">
                      このメールは自動配信されております。<br />
                    </p>
<!--[if mso | IE]>
                    </td></tr></table>
<![endif]-->
                  </td>
                </tr>
                <tr>
                  <td align="left" style="padding:8px 15px;">
<!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="mso-line-height-rule:exactly;mso-line-height-alt:22px;">
<![endif]-->
                    <p style="color:#000000;font-family:'Noto Sans JP','ヒラギノ角ゴ Pro W3',メイリオ,sans-serif;font-size:14px;font-weight:light;line-height:22px;text-align:left;word-break:break-all;">
                      この度は、【Waha! Transformer 会員サイト】にご登録いただき、<br />
                      誠にありがとうございます。
                    </p>
<!--[if mso | IE]>
                    </td></tr></table>
<![endif]-->
                  </td>
                </tr>
                <tr>
                  <td align="left" style="padding:8px 15px;">
<!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="mso-line-height-rule:exactly;mso-line-height-alt:22px;">
<![endif]-->
                    <p style="color:#000000;font-family:'Noto Sans JP','ヒラギノ角ゴ Pro W3',メイリオ,sans-serif;font-size:14px;font-weight:light;line-height:22px;text-align:left;word-break:break-all;">
                      ただいま、会員登録が完了いたしました。
                    </p>
<!--[if mso | IE]>
                    </td></tr></table>
<![endif]-->
                  </td>
                </tr>
                <tr>
                  <td align="left" style="padding:8px 15px;">
<!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="mso-line-height-rule:exactly;mso-line-height-alt:22px;">
<![endif]-->
                    <p style="color:#000000;font-family:'Noto Sans JP','ヒラギノ角ゴ Pro W3',メイリオ,sans-serif;font-size:14px;font-weight:light;line-height:22px;text-align:left;word-break:break-all;">
                      下記リンクからパスワードを設定の上、ログインしてください。<br />
                      <a href="{!! env('MEMBER_APP_URL') !!}signin">{!! env('MEMBER_APP_URL') !!}signin</a>
                    </p>
<!--[if mso | IE]>
                    </td></tr></table>
<![endif]-->
                  </td>
                </tr>
                <tr>
                  <td align="left" style="padding:8px 15px;">
<!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="mso-line-height-rule:exactly;mso-line-height-alt:22px;">
<![endif]-->
                    <p style="color:#000000;font-family:'Noto Sans JP','ヒラギノ角ゴ Pro W3',メイリオ,sans-serif;font-size:14px;font-weight:light;line-height:22px;text-align:left;word-break:break-all;">
                      ご活用方法など、［ご利用ガイド］をご確認願います。<br />
                      <a href="https://member.waha-transformer.com/guide/">https://member.waha-transformer.com/guide/</a>
                    </p>
<!--[if mso | IE]>
                    </td></tr></table>
<![endif]-->
                  </td>
                </tr>
                <tr>
                  <td align="left" style="padding:8px 15px;">
<!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="mso-line-height-rule:exactly;mso-line-height-alt:22px;">
<![endif]-->
                    <p style="color:#000000;font-family:'Noto Sans JP','ヒラギノ角ゴ Pro W3',メイリオ,sans-serif;font-size:14px;font-weight:light;line-height:22px;text-align:left;word-break:break-all;">
                      お役立ちコンテンツなど、随時拡張してまいります。
                    </p>
<!--[if mso | IE]>
                    </td></tr></table>
<![endif]-->
                  </td>
                </tr>
                <tr>
                  <td align="left" style="padding:8px 15px;">
<!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="mso-line-height-rule:exactly;mso-line-height-alt:22px;">
<![endif]-->
                    <p style="color:#000000;font-family:'Noto Sans JP','ヒラギノ角ゴ Pro W3',メイリオ,sans-serif;font-size:14px;font-weight:light;line-height:22px;text-align:left;word-break:break-all;">
                      ご意見・ご要望などはご遠慮なく、<br />
                      お問い合わせフォームからお寄せください。
                    </p>
<!--[if mso | IE]>
                    </td></tr></table>
<![endif]-->
                  </td>
                </tr>
              </table>
            </div>
<!--[if mso | IE]>
            </td></tr></table>
<![endif]-->
          </td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection
