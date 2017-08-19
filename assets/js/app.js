$body = $("body");
$(document).on({
    ajaxStart: function () {
        $body.addClass("loading");
    },
    ajaxStop: function () {
        $body.removeClass("loading");
    }
});
localStorage.setItem('store', $('#store').attr('data-id'));
$('.change-store').on('click', function () {
    $.ajax({
        method: 'post',
        url: base_url + 'settings/change_store',
        data: {id: $(this).attr('data-id')},
        success: function (response) {
            window.location.reload();
        }
    });
});
$('#change-store').on('click', function () {
    $.ajax({
        method: 'post',
        url: base_url + 'settings/change_store',
        data: {id: $('#select-store').val()},
        success: function (response) {
//            showNotify(response);
            window.location.reload();
        }
    });
});

$('.input-number').number(true, 0, ',', '.');
$('.input-number').attr('autocomplete', 'off');
$('.input-number').keyup(function (e) {
    var id = $(this).attr('id');
    if ($('#' + id).val() == '')
        $('#' + id).val('0');
});
function showNotify(message, status) {
    thisNotify = UIkit.notify({
        message: message,
        status: status,
        timeout: 5e3,
        onClose: function () {
            clearTimeout(thisNotify.timeout)
        }
    });
}

function showModal(type) {
    var modal = UIkit.modal("#modal-" + type, {bgclose: false});
    if (modal.isActive()) {
        modal.hide();
    } else {
        modal.show();
    }
}
function showModalNotKeyboard(type) {
    var modal = UIkit.modal("#modal-" + type, {bgclose: false, keyboard: false});
    if (modal.isActive()) {
        modal.hide();
    } else {
        modal.show();
    }
}
function hideModal(type) {
    var modal = UIkit.modal("#modal-" + type);
    if (modal.isActive()) {
        modal.hide();
    }
}

function date_now() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd
    }

    if (mm < 10) {
        mm = '0' + mm
    }

    return  yyyy + '-' + mm + '-' + dd;
}

function get_month_from_chart(month) {
    switch (month) {
        case 0:
            month = "Januari";
            break;
        case 1:
            month = "Februari";
            break;
        case 2:
            month = "Maret";
            break;
        case 3:
            month = "April";
            break;
        case 4:
            month = "Mei";
            break;
        case 5:
            month = "Juni";
            break;
        case 6:
            month = "Juli";
            break;
        case 7:
            month = "Agustus";
            break;
        case 8:
            month = "September";
            break;
        case 9:
            month = "Oktober";
            break;
        case 10:
            month = "November";
            break;
        case 11:
            month = "Desember";
            break;
    }
    return month;
}

function mysql_to_date_indo(date) {
    var year = date.substr(0, 4);
    var month = date.substr(5, 2);
    var date = date.substr(8, 2);
    return date + ' ' + get_month(parseInt(month)) + ' ' + year;
}

function get_month(month) {
    switch (month) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}