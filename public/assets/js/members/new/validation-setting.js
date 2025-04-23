$(function(){
  /**
   * jQueryValidator Settings
  */
  // #form-sigin - rules
  var rules = {
    'disp_id'   : { dispId: true },
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
      required: true,
      minlength: 8,
      passwordStrength: true
    },
    'password_confirmation': {
      required        : true,
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
    'disp_id'   : { dispId: '半角英字1文字、半角数字6文字で入力してください' },
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
      required: '「パスワード」を入力してください',
      minlength: '8文字以上入力してください'
    },
    'password_confirmation': {
      required: '「パスワード確認」を入力してください',
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