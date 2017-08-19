altair_forms.parsley_validation_config();
$(function () {
    altair_form_validation.init()
}), altair_form_validation = {
    init: function () {
        var i = $("#form");
        i.parsley().on("form:validated", function () {
            altair_md.update_input(i.find(".md-input-danger"))
        }).on("field:validated", function (i) {
            $(i.$element).hasClass("md-input") && altair_md.update_input($(i.$element))
        }), window.Parsley.on("field:validate", function () {
            var i = $(this.$element).closest(".md-input-wrapper").siblings(".error_server_side");
            i && i.hide()
        })
    }
};
$('body').on('submit', '#form', function (e) {
    e.preventDefault();
    $('#form').ajaxSubmit({
        success: function (data) {
            data = JSON.parse(data);
            showNotify(data.message, data.status);
            if (data.status == 'success') {
                $('table').trigger('pagerUpdate');
                showModal('form');
            } else if (data.status == 'success_redirect') {
                window.setTimeout(function () {
                    window.location = base_url + data.redirect;
                }, 1000);
            }
        }
    });
    return false;
});