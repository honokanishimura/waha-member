$(function(){
  /**
   * jQueryValidator Settings
  */
  // #form-reminder - rules
  var sigin_rules = {
    'email'  : {
      required: true,
      email   : true
    }
  };
  // #form-reminder - messages
  var sigin_messages = {
    'email'  : {
      required: '「メールアドレス」を入力してください',
      email   : '有効な「メールアドレス」を入力してください',
    }
  };

  /**
   * Run jQueryValidator
  */
  run_validate( '#form-reminder', sigin_rules, sigin_messages );
});