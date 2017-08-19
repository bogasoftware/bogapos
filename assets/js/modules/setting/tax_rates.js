$('body').on('click', '#btn-add', function (e) {
    e.preventDefault();
    showModal('form');
    $('#save_method').val('add');
    $('#id').val('');
    $('#name').val('');
    $('#rate').val('');
    $('#form-modal .md-input').each(function () {
        if ($(this).val().length == 0) {
            $(this).parent('div.md-input-wrapper').removeClass('md-input-filled');
        }
    });
});
$('body').on('click', '.btn-edit', function (e) {
    e.preventDefault();
    $('#save_method').val('edit');
    var id = $(this).attr('data-id');
    $.ajax({
        url: current_url + "/get/" + id,
        method: 'post',
        success: function (response) {
            var data = JSON.parse(response);
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#rate').val(data.rate);
            $('#form-modal .md-input').each(function () {
                if ($(this).val().length > 0) {
                    $(this).parent('div.md-input-wrapper').addClass('md-input-filled');
                }
            });
            showModal('form');
        }
    });
});