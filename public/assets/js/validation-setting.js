$(function(){
  /**
   * jQueryValidator Settings
  */
  // #form-sigin - rules
  var sigin_rules = {
    'login-email': {
      required: true,
      email   : true
    },
    'login-password': { required: true }
  };
  // #form-sigin - messages
  var sigin_messages = {
    'login-email'  : {
      required: '「メールアドレス」を入力してください',
      email   : '有効な「メールアドレス」を入力してください',
    },
    'login-password': { required: '「パスワード」を入力してください' }
  };

  // #form-register - rules
  var register_rules = {
    'register-email': {
      required: true,
      email   : true
    }
  };
  // #form-register - messages
  var register_messages = {
    'register-email'  : {
      required: '「メールアドレス」を入力してください',
      email   : '有効な「メールアドレス」を入力してください',
    }
  };

  /**
   * Run jQueryValidator
  */
  run_validate( '#form-login', sigin_rules, sigin_messages );
  run_validate( '#form-register', register_rules, register_messages );
});