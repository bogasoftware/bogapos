$(function () {
    if (Modernizr.touch) {
        var e = $(".focus-highlight");
        e.length && e.find("td, th").attr("tabindex", "1").on("touchstart", function () {
            $(this).focus()
        }), $(".tablesorter").find("th").addClass("needsclick")
    }
    table.table();
    $('#generate').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url + 'reports/purchase/recap_data',
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
                $('#table').trigger('updateAll');
                $('#date-start-display').text(mysql_to_date_indo($('#date-start').val()));
                $('#date-end-display').text(mysql_to_date_indo($('#date-end').val()));
                var subtotal = 0;
                $('#table tbody').find('.subtotal').each(function (index, elem) {
                    var val = parseFloat($(elem).text().replace(/\./g, ''));
                    subtotal += val;
                });
                $('#table tfoot #subtotal').text($.number(subtotal, 0, ',', '.'));
                var discount = 0;
                $('#table tbody').find('.discount').each(function (index, elem) {
                    var val = parseFloat($(elem).text().replace(/\./g, ''));
                    discount += val;
                });
                $('#table tfoot #discount').text($.number(discount, 0, ',', '.'));
                var tax = 0;
                $('#table tbody').find('.tax').each(function (index, elem) {
                    var val = parseFloat($(elem).text().replace(/\./g, ''));
                    tax += val;
                });
                $('#table tfoot #tax').text($.number(tax, 0, ',', '.'));
                var shipping = 0;
                $('#table tbody').find('.shipping').each(function (index, elem) {
                    var val = parseFloat($(elem).text().replace(/\./g, ''));
                    shipping += val;
                });
                $('#table tfoot #shipping').text($.number(shipping, 0, ',', '.'));
                var total = 0;
                $('#table tbody').find('.total').each(function (index, elem) {
                    var val = parseFloat($(elem).text().replace(/\./g, ''));
                    total += val;
                });
                $('#table tfoot #total').text($.number(total, 0, ',', '.'));
                var cash = 0;
                $('#table tbody').find('.cash').each(function (index, elem) {
                    var val = parseFloat($(elem).text().replace(/\./g, ''));
                    cash += val;
                });
                $('#table tfoot #cash').text($.number(cash, 0, ',', '.'));
                var credit = 0;
                $('#table tbody').find('.credit').each(function (index, elem) {
                    var val = parseFloat($(elem).text().replace(/\./g, ''));
                    credit += val;
                });
                $('#table tfoot #credit').text($.number(credit, 0, ',', '.'));
            }
        });
    })
}), table = {
    table: function () {
        var t = $("#table"),
                i = $("#columnSelector"),
                n = {
                    container: $(".ts_pager"),
                    output: "{startRow} - {endRow} / {filteredRows} ({totalRows})",
                    fixedHeight: !0,
                    removeRows: !1,
                    cssGoto: ".ts_gotoPage"
                };
        var a = t.tablesorter({
            theme: "altair",
            widthFixed: !0,
            widgets: ["zebra"],
            headers: {
                'th': {
                    sorter: false,
                }
            },
        }).tablesorterPager(n).on("pagerComplete", function (e, t) {
            "undefined" != typeof selectizeObj && selectizeObj.data("selectize") && (selectizePage = selectizeObj[0].selectize, selectizePage.setValue($("select.ts_gotoPage option:selected").index() + 1, !1))
        });
        $(".ts_gotoPage.ts_selectize, .pagesize.ts_selectize").after('<div class="selectize_fix"></div>').selectize({
            hideSelected: !0,
            onDropdownOpen: function (e) {
                e.hide().velocity("slideDown", {
                    duration: 200,
                    easing: easing_swiftOut
                })
            },
            onDropdownClose: function (t) {
                t.show().velocity("slideUp", {
                    duration: 200,
                    easing: easing_swiftOut
                }), $(".uk-tooltip").hide(), "undefined" != typeof selectizeObj && selectizeObj.data("selectize") && (selectizePage = selectizeObj[0].selectize, selectizePage.destroy(), $(".ts_gotoPage").next(".selectize_fix").remove(), setTimeout(function () {
                    e()
                }))
            }
        })
    },
};