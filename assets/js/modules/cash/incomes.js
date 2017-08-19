//add
$('body').on('click', '#btn-add', function (e) {
    e.preventDefault();
    if (localStorage.getItem('store') == 'all') {
        showModalNotKeyboard('store');
    } else {
        $('#form').parsley().reset();
        $('#save_method').val('add');
        $('#id').val('');
        $.get(base_url + 'cash/incomes/get_code', function (response) {
            $('#code').val(response);
            $('#code').parent('div.md-input-wrapper').addClass('md-input-filled');
        });
        $('#amount').val(0);
        $('#date').val(date_now());
        $('#note').val('');
        $('#form .md-input').each(function () {
            if ($(this).val().length == 0) {
                $(this).parent('div.md-input-wrapper').removeClass('md-input-filled');
            } else {
                $(this).parent('div.md-input-wrapper').addClass('md-input-filled');
            }
        });
        showModal('form');
    }
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
            $('#date').val(data.date);
            $('#amount').val(data.amount);
            $('#note').val(data.note);
            $('#form .md-input').each(function () {
                if ($(this).val().length > 0) {
                    $(this).parent('div.md-input-wrapper').addClass('md-input-filled');
                }
            });
            showModal('form');
        }
    });
});