$(function () {
    if (Modernizr.touch) {
        var e = $(".focus-highlight");
        e.length && e.find("td, th").attr("tabindex", "1").on("touchstart", function () {
            $(this).focus()
        }), $(".tablesorter").find("th").addClass("needsclick")
    }
    table.table();
}), table = {
    table: function () {
        var t = $("#table");
        var n = {
            container: $(".ts_pager"),
            fixedHeight: !0,
            removeRows: !1,
            output: "{startRow} - {endRow} / {filteredRows} ({totalRows})",
            ajaxUrl: base_url + 'master/customers/get_list?page={page}&size={size}&{filterList:fcol}&{sortList:col}',
            ajaxProcessing: function (data) {
                if (data && data.hasOwnProperty('rows')) {
                    var indx, r, row, c, d = data.rows,
                            total = data.total_rows,
                            headers = data.headers,
                            headerXref = headers.join(',').replace(/\s+/g, '').split(','),
                            rows = [],
                            len = d.length;
                    for (r = 0; r < len; r++) {
                        row = [];
                        for (c in d[r]) {
                            if (typeof (c) === "string") {
                                indx = $.inArray(c, headerXref);
                                if (indx >= 0) {
                                    row[indx] = d[r][c];
                                }
                            }
                        }
                        rows.push(row);
                    }
                    return [total, rows, headers];
                }
            },
            processAjaxOnInit: true,
            updateArrows: true,
            page: 0,
            size: 10,
            savePages: true,
            pageReset: 0,
            countChildRows: false,
        };
        var a = t.tablesorter({
            theme: "altair",
            widthFixed: !0,
            widgets: ["zebra", "filter", ],
            sortList: [[1, 0]],
            sortReset: true,
            sortRestart: true,
        }).tablesorterPager(n);
        $(".pagesize.ts_selectize").after('<div class="selectize_fix"></div>').selectize({
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
//add
//$('body').on('click', '#btn-add', function (e) {
//    e.preventDefault();
//    showModal('form');
//    $('#save_method').val('add');
//    $('#id').val('');
//    $('#id').removeAttr('readonly');
//    $('#name').val('');
//    $('#address').val('');
//    $('#phone').val('');
//    $('#email').val('');
//    $('#form-modal input[type=text]').each(function () {
//        if ($(this).val().length == 0) {
//            $(this).parent('div.md-input-wrapper').removeClass('md-input-filled');
//        }
//    });
//});
//// Edit button
//$('body').on('click', '.btn-edit', function (e) {
//    e.preventDefault();
//    $('#save_method').val('edit');
//    var id = $(this).attr('data-id');
//    $.ajax({
//        url: current_url + "/get/" + id,
//        method: 'post',
//        success: function (response) {
//            var data = JSON.parse(response);
//            $('#id').val(data.id);
//            $('#id').attr('readonly', 'readonly');
//            $('#name').val(data.name);
//            $('#address').val(data.address);
//            $('#phone').val(data.phone);
//            $('#email').val(data.email);
//            $('#form-modal .md-input').each(function () {
//                if ($(this).val().length > 0) {
//                    $(this).parent('div.md-input-wrapper').addClass('md-input-filled');
//                }
//            });
//            showModal('form');
//        }
//    });
//});