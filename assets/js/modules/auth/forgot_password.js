$(function () {
    $('#forgot-password').submit(function () {
        $('#forgot-password').ajaxSubmit({
            success: function (data) {
                data = JSON.parse(data);
                showNotify(data.message, data.status);
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