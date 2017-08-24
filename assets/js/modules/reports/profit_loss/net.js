$(function () {
    if (Modernizr.touch) {
        var e = $(".focus-highlight");
        e.length && e.find("td, th").attr("tabindex", "1").on("touchstart", function () {
            $(this).focus()
        })
    }
    $('#generate').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url + 'reports/profit_loss/net_data',
            type: 'post',
            data: {start: $('#date-start').val(), end: $('#date-end').val()},
            dataType: 'HTML',
            success: function (response) {
                var a = $('#filter-form-toggle'),
                        i = a.closest('#filter-form');
                $(i).toggleClass('md-card-collapsed').children('.md-card-content').slideToggle('280', bez_easing_swiftOut),
                        a.velocity({
                            scale: 0,
                            opacity: 0.2
                        }, {
                            duration: 280,
                            easing: easing_swiftOut,
                            complete: function () {
                                $(i).hasClass('md-card-collapsed') ? a.html('&#xE313;') : a.html('&#xE316;'),
                                        a.velocity('reverse'),
                                        $window.resize()
                            }
                        })
                $('#table tbody').html(response);
                $('#date-start-display').text($('#date-start').val());
                $('#date-end-display').text($('#date-end').val());
            }
        });
    })
});