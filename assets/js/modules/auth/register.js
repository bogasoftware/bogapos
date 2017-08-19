$(function () {
    $('#register').submit(function () {
        $('#register').ajaxSubmit({
            success: function (data) {
                data = JSON.parse(data);
                showNotify(data.message, data.status);
                if (data.status == 'success') {
                    window.setTimeout(function () {
                        window.location = base_url + 'auth/login';
                    }, 1000);
                }
            }
        });
        return false;
    });
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