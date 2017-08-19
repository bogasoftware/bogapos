$(function () {
    $.ajax({
        url: base_url + 'home/sales_chart/',
        type: 'post',
        dataType: "json",
        success: function (response) {
            var t = c3.generate({
                bindto: '#sales-vs-purchase',
                x: 'x',
                data: {
                    json: response,
                    type: "bar",
                    keys: {
                        value: [lang.sales.label, lang.purchases.label],
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
                            return $.number(value, 0, ',', '.');
                        }
                    }
                },
                color: {pattern: ["#1f77b4", "#ff7f0e", "#2ca02c"]}
            });
        }
    });
    $window.on("debouncedresize", function () {
        t.resize()
    })
})
