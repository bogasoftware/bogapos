$(function () {
    bt_reports_profit_loss.monthly();
    $("#select-year").selectize({
        onDropdownOpen: function (t) {
            t.hide().velocity("slideDown", {begin: function () {
                    t.css({"margin-top": "0"})
                }, duration: 200, easing: easing_swiftOut})
        },
        onDropdownClose: function (t) {
            t.show().velocity("slideUp", {complete: function () {
                    t.css({"margin-top": ""})
                }, duration: 200, easing: easing_swiftOut})
        },
        onChange: function (t) {
            bt_reports_profit_loss.monthly();
            $('.year').text($(this).val());
        }
    });
    $('.year').text($('#select-year').val());
});
bt_reports_profit_loss = {
    monthly: function () {
        var e = '#profit-loss-monthly-chart';
        if ($(e).length) {
            $.ajax({
                url: base_url + 'reports/profit_loss/monthly_chart/',
                type: 'post',
                data: {year: $('#select-year').val()},
                dataType: "json",
                success: function (response) {
                    var t = c3.generate({
                        bindto: e,
                        data: {
                            json: response,
                            type: "bar",
                            keys: {
                                value: [lang.text.profit_loss],
                            }
                        },
                        axis: {
                            y: {
                                tick: {
                                    format: function (d) {
                                        var formatValue = d3.format(".1s");
                                        return formatValue(d);
                                    }
                                }
                            },
                            x: {
                                type: 'category',
                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                            }
                        },
                        tooltip: {
                            format: {
                                title: function (d) {
                                    return get_month_from_chart(d);
                                },
                                value: function (value, ratio, id) {
                                    return number(value);
                                }
                            }
                        },
                        color: {pattern: ["#1f77b4", "#ff7f0e", "#2ca02c"]}
                    });
                    $window.on("debouncedresize", function () {
                        $(t).resize()
                    });
                }
            });
        }
    }
}