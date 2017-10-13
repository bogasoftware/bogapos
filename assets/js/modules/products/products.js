altair_forms.parsley_validation_config();
$(function () {
    altair_form_validation.init()
}), altair_form_validation = {
    init: function () {
        var i = $("#form-import");
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
$('body').on('submit', '#form-import', function (e) {
    e.preventDefault();
    $('#form-import').ajaxSubmit({
        success: function (data) {
            data = JSON.parse(data);
            showNotify(data.message, data.status);
            if (data.status == 'success') {
                $('table').trigger('pagerUpdate');
                showModal('import');
            } else if (data.status == 'success_redirect') {
                window.setTimeout(function () {
                    window.location = base_url + data.redirect;
                }, 1000);
            }
        }
    });
    return false;
});


$('body').on('click', '#btn-import', function (e) {
    e.preventDefault();
    $('#form').parsley().reset();
    $('#save_method').val('import');
    $('#import_data').val('');
    $('.dropify-clear').click();
    $('#form .md-input').each(function () {
        if ($(this).val().length == 0) {
            $(this).parent('div.md-input-wrapper').removeClass('md-input-filled');
        } else {
            $(this).parent('div.md-input-wrapper').addClass('md-input-filled');
        }
    });
    showModal('import');
});




$('body').on('click', '#btn-add', function (e) {
    e.preventDefault();
    $('#form').parsley().reset();
    $('#save_method').val('add');
    $('#id').val('');
    $('#code').val('');
    $('#name').val('');
    //$('#description').val('');
    var textarea = document.getElementById('description');
    textarea.setAttribute('style','');
    textarea.value = "";
    $('#cost').val('0');
    $('#price').val('0');
    $('#image').val('');
    $('#image-image').removeAttr('src');
    $('#categories').val('0');
    $('#quantity').val('');
    $('#quantity-form').show();
    $('#form .md-input').each(function () {
        if ($(this).val().length == 0) {
            $(this).parent('div.md-input-wrapper').removeClass('md-input-filled');
        } else {
            $(this).parent('div.md-input-wrapper').addClass('md-input-filled');
        }
    });
    showModal('form');
});
// Edit button
$('body').on('click', '.btn-edit', function (e) {
    e.preventDefault();
    $('#form').parsley().reset();
    $('#save_method').val('edit');
    var id = $(this).attr('data-id');
    $.ajax({
        url: current_url + "/get/" + id,
        method: 'post',
        success: function (response) {
            var data = JSON.parse(response);
            $('#id').val(data.id);
            $('#code').val(data.code);
            $('#name').val(data.name);
            //$('#description').val(data.description);
            var textarea = document.getElementById('description');
            textarea.setAttribute('style','');
            textarea.value = data.description;
            $('#cost').val(data.cost);
            $('#price').val(data.price);
            $('#categories').val(data.category);
            $('#image-image').attr('src', base_url + data.image);
            $('#quantity-form').hide();
            $('#form .md-input').each(function () {
                if ($(this).val().length > 0) {
                    $(this).parent('div.md-input-wrapper').addClass('md-input-filled');
                }
            });
            showModal('form');
            $('.input-number').number(true, decimal_digit, decimal_separator, thousand_separator);
            $('.input-number').attr('autocomplete', 'off');
        }
    });
});
$('body').on('change', '#image', function (e) {
    e.preventDefault();
    var reader = new FileReader();
    reader.onload = function (e) {
        document.getElementById("image-image").src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
});