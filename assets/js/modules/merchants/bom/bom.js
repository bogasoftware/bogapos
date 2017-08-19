$('body').on('click', '#submit', function (e) {
    e.preventDefault();
    $('#form').ajaxSubmit({
        success: function (data) {
            data = JSON.parse(data);
            showNotify(data.message, data.status);
        }
    });
    return false;
});
$('body').on('keyup', '.searchParts', function (e) {
    var row = $(this).attr('data-row');
    var field = $(this).attr('data-search');
    e.preventDefault();
    if (e.keyCode == 13) {
        var text = $(this).val();
        showModal('parts');
        $('#modal-parts').find("#view").load(base_url + 'master/bom/modal_parts/' + row + '/' + field + '/' + text);
    }
});
function selectParts(row, id, name, unit) {
    $('#' + row + 'id').val(id);
    $('#' + row + 'id').attr('readonly', 'readonly');
    $('#' + row + 'name').val(name);
    $('#' + row + 'name').attr('readonly', 'readonly');
    $('#' + row + 'unit').text(unit);
    $('#' + row + 'quantity').val(1);
    $('#' + row + 'quantity').removeAttr('readonly');
    $('#' + row + 'delete').attr('href', 'javascript:removeParts(' + row + ');');
    $('#' + row + 'delete').attr('onclick', "return confirm('Are you sure want to delete Part: " + id + "?')");
    row = parseInt(row) + 1;
    var newRow = '<tr id="' + row + '">' +
            '<td><a id="' + row + 'delete" href="javascript:;"><i class="md-icon material-icons">delete</i></a></td>' +
            '<td><input class="md-input searchParts" autocomplete="off" name="components[' + row + '][id]" data-row="' + row + '" data-search="id" id="' + row + 'id' + '"></td>' +
            '<td><input class="md-input searchParts" autocomplete="off" data-row="' + row + '" data-search="name" id="' + row + 'name' + '" ></td>' +
            '<td><input class="md-input" autocomplete="off" name="components[' + row + '][quantity]" readonly id="' + row + 'quantity' + '"></td>' +
            '<td><span id="' + row + 'unit' + '"></span></td>' +
            '</tr>';
    $('#list-component').append(newRow);
    showModal('parts');
}
function removeParts(row) {
    $("#list-component tr#" + row).fadeOut(300, function () {
        $(this).remove();
    });
}