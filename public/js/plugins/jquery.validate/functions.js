/**
 * Validator: Run jQueryValidator
 * @param {string} target - 対象フォームのID
 * @param {array} rule_arr - バリデーションルールの設定
 * @param {array} msg_arr - バリデーションルールメッセージの設定
 */
function run_validate( target, rule_arr, msg_arr ){
  $(target).validate({
    errorElement: 'span',
    errorClass: 'validate-error',
    rules : rule_arr,
    messages: msg_arr,
    ignore: ':hidden:not(:checkbox)',
    errorPlacement: function(error, element) {
      if ( element.attr("type") == "checkbox" ){
        var parent_elm = $(element).parents('.form-group');
        error.appendTo(parent_elm);
      } else {
        error.insertAfter(element);
      }
    },
    // onfocusin: function(element) { $(element).valid(); },
    onfocusout: function(element) { $(element).valid(); },
  });
};

$(function(){
/**
 * Add Method: add jQueryValidator's Validation rules
 */
  // alpha(Uppercase, lowercase) and Num
  $.validator.addMethod("passwordStrength", function(value) {
    if (value === '') return true;

    var validate = 0;
    if (/[a-zA-Z]/.test(value)) validate++;
    if (/[0-9]/.test(value)) validate++;
    if ( validate >= 2 ) return true
  }, '半角数字、半角英数(大文字、小文字)を組み合わせてください');

  // alpha(Uppercase and lowercase) or Num
  $.validator.addMethod("alphaNum", function(value, element) {
    return this.optional(element) || /^([a-zA-Z0-9]+)$/.test(value);
  }, "半角英数字を入力してください");

  // alpha(Uppercase and lowercase) 1 character and Num 6 characters
  $.validator.addMethod("dispId", function(value) {
    if (value === '') return true;

    return /^[a-zA-Z][0-9]{6}$/.test(value);
  }, '半角英字1文字、半角数字6文字で入力してください');

});