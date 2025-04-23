$(function(){
  /**
   * jQueryValidator Settings
  */
  // #form-reset - rules
  var sigin_rules = {
    'password': {
      required: true,
      minlength: 8,
      passwordStrength: true
    },
    'password_confirmation': {
      required: true,
      equalTo: 'input[name=password]',
    },
  };
  // #form-reset - messages
  var sigin_messages = {
    'password': {
      required: '「パスワード」を入力してください',
      minlength: '8文字以上入力してください'
    },
    'password_confirmation': {
      required: '「パスワード確認」を入力してください',
      equalTo: 'パスワードが一致しません。'
    },
  };

  /**
   * Run jQueryValidator
  */
  run_validate( '#form-reset', sigin_rules, sigin_messages );
});