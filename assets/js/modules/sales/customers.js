//add
$('body').on('click', '#btn-add', function (e) {
    e.preventDefault();
    $('#form').parsley().reset();
    $('#save_method').val('add');
    $('#id').val('');
    $('#name').val('');
    $('#email').val('');
    $('#address').val('');
    $('#phone').val('');
    $('#city').val('');
    $('#postcode').val('');
    $('#form .md-input').each(function () {
        if ($(this).val().length == 0) {
            $(this).parent('div.md-input-wrapper').removeClass('md-input-filled');
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
            $('#name').val(data.name);
            $('#address').val(data.address);
            $('#phone').val(data.phone);
            $('#city').val(data.city);
            $('#email').val(data.email);
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