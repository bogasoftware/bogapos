function insertCode(e) {
    var text = $(e).data('text');
    var module = $(e).data('id');
    var $module = $('#code_format_' + module);
    $module.val($module.val() + text);
}