$('body').on('click', '#btn-add', function (e) {
    e.preventDefault();
    $('#form').parsley().reset();
    $('#save_method').val('add');
    $('#id').val('');
    $('#code').val('');
    $('#name').val('');
    $('#description').val('');
    $('#cost').val('0');
    $('#price').val('0');
    $('#image').val('');
    $('#image-image').removeAttr('src');
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
            $('#description').val(data.description);
            $('#cost').val(data.cost);
            $('#price').val(data.price);
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