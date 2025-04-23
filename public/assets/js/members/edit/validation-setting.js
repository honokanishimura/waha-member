$(function(){
  /**
   * jQueryValidator Settings
  */
  // #form-sigin - rules
  var rules = {
    'disp_id'   : {
      required: true,
      dispId: true,
    },
    'nickname'   : {
      rangelength: [6, 12],
      alphaNum: true
    },
    'company'   : { required: true },
    'department': { required: true },
    'lname'     : { required: true },
    'fname'     : { required: true },
    'email'     : {
      required: true,
      email   : true
    },
    'password'  : {
      minlength: 8,
      passwordStrength: true
    },
    'password_confirmation': {
      equalTo         : 'input[name=password]',
      passwordStrength: true
    },
    'handling[]'   : {},
    'industry'   : {},
    'location'   : {},
    'employee'   : {},
    'affiliation'   : {}
  };
  // #form-sigin - messages
  var messages = {
    'disp_id'   : {
      required: '「会員ID」を入力してください',
      dispId  : '半角英字1文字、半角数字6文字で入力してください',
    },
    'nickname'  : { rangelength: '6~12文字で入力してください' },
    'company'   : { required: '「会社名」を入力してください' },
    'department': { required: '「部署名」を入力してください' },
    'lname'     : { required: '「名前(姓)」を入力してください' },
    'fname'     : { required: '「名前(名)」を入力してください' },
    'email'     : {
      required: '「メールアドレス」を入力してください',
      email   : '有効な「メールアドレス」を入力してください',
    },
    'password'  : {
      minlength: '8文字以上入力してください'
    },
    'password_confirmation': {
      equalTo: 'パスワードが一致しません。'
    },
    'handling[]'   : {},
    'industry'   : {},
    'location'   : {},
    'employee'   : {},
    'affiliation'   : {}
  };

  /**
   * Run jQueryValidator
  */
  run_validate( '#form-register', rules, messages );
});