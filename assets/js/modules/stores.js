//add
$('body').on('click', '#btn-add', function (e) {
    e.preventDefault();
    $('#form').parsley().reset();
    $('#save_method').val('add');
    $('#id').val('');
    $('#code').val('');
    $('#name').val('');
    $('#address').val('');
    $('#telephone').val('');
    $('#city').val('');
    $('#province').val('');
    $('#postcode').val('');
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
            $('#address').val(data.address);
            $('#telephone').val(data.telephone);
            $('#city').val(data.city);
            $('#province').val(data.province);
            $('#postcode').val(data.postcode);
            $('#form .md-input').each(function () {
                if ($(this).val().length > 0) {
                    $(this).parent('div.md-input-wrapper').addClass('md-input-filled');
                }
            });
            showModal('form');
        }
    });
});