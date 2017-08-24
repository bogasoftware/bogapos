$(function () {
    bt_reports_purchase.monthly(), bt_reports_purchase.monthly_product();
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
            bt_reports_purchase.monthly(), bt_reports_purchase.monthly_product();
            $('.year').text($(this).val());
        }
    });
    $('.year').text($('#select-year').val());
    $("#select-product").selectize({
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
            bt_reports_purchase.monthly_product();
        }
    });
});
bt_reports_purchase = {
    monthly: function () {
        var e = '#purchase-monthly-chart';
        if ($(e).length) {
            $.ajax({
                url: base_url + 'reports/purchase/monthly_chart/',
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
                                value: [lang.purchases.label],
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
    }, monthly_product: function () {
        var e = '#purchase-product-monthly-chart';
        if ($(e).length) {
            $.ajax({
                url: base_url + 'reports/purchase/product_monthly_chart/',
                type: 'post',
                data: {year: $('#select-year').val(), product: $('#select-product').val()},
                dataType: "json",
                success: function (response) {
                    var t = c3.generate({
                        bindto: e,
                        data: {
                            json: response.data,
                            type: "bar",
                            keys: {
                                value: [lang.purchases.label],
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
                            contents: function (d, defaultTitleFormat, defaultValueFormat, color) {
                                var $$ = this, config = $$.config,
                                        text, i, title, value, name, bgcolor;
                                for (i = 0; i < d.length; i++) {
                                    if (!(d[i] && (d[i].value || d[i].value === 0))) {
                                        continue;
                                    }

                                    if (!text) {
                                        title = get_month_from_chart(d[i].x);
                                        text = "<table class='" + $$.CLASS.tooltip + "'><tr><th colspan='2'>" + title + "</th></tr>";
                                    }

                                    bgcolor = $$.levelColor ? $$.levelColor(d[i].value) : color(d[i].id);

                                    text += "<tr class='" + $$.CLASS.tooltipName + "-" + d[i].id + "'>";
                                    text += "<td class='name'><span style='background-color:" + bgcolor + "'></span>" + d[i].name + "</td>";
                                    text += "<td class='value'>" + number(d[i].value) + "</td>";
                                    text += "</tr>";
                                    text += "<tr class='" + $$.CLASS.tooltipName + "-" + d[i].id + "'>";
                                    text += "<td class='name'><span style='background-color:" + bgcolor + "'></span>Kuantitas</td>";
                                    var value = response.quantity[0];
                                    text += "<td class='value'>" + number(value[d[i].index]) + "</td>";
                                    text += "</tr>";
                                }
                                return text + "</table>";
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