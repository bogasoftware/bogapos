$('body').on('click', '#btn-add', function (e) {
    e.preventDefault();
    $('#form').parsley().reset();
    $('#save_method').val('add');
    $('#id').val('');
    $('#name').val('');
    if($('#status').is(':checked')){
        //$('#status').trigger("click");
    } else {
        $('#status').trigger("click");
    }
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
            $('#name').val(data.name);
            if(data.status == 0){
                    if($('#status').is(':checked')){
                        //$('#status').trigger("click");
                    } else {
                        $('#status').trigger("click");
                    }
            } else {
                    if($('#status').is(':checked')){
                        $('#status').trigger("click");
                    }
            }
            $('#form .md-input').each(function () {
                if ($(this).val().length > 0) {
                    $(this).parent('div.md-input-wrapper').addClass('md-input-filled');
                }
            });
            showModal('form');
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