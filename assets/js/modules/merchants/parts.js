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
        var t = $("#table"),
                n = {
                    container: $(".ts_pager"),
                    fixedHeight: !0,
                    removeRows: !1,
                    output: "{startRow} - {endRow} / {filteredRows} ({totalRows})",
                    ajaxUrl: base_url + 'master/parts/get_list?page={page}&size={size}&{filterList:fcol}&{sortList:col}',
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
        }), t.on("click", ".ts_remove_row", function (e) {
            e.preventDefault();
            var t = $(this);
            var url = t.attr('href');
            UIkit.modal.confirm("Are you sure want to delete '" + t.attr('data-name') + "'?", function () {
                $.ajax({
                    url: url,
                    method: 'post',
                    success: function (data) {
                        data = JSON.parse(data);
                        showNotify(data.message, data.status);
                        if (data.status == 'success') {
                            t.closest("tr").remove(), a.trigger("update")
                        }
                    }
                });
            }, {
                labels: {
                    Ok: "Delete"
                }
            })
        })
    },
};
$("#type").selectize({
    onDropdownOpen: function (t) {
        t.hide().velocity("slideDown", {begin: function () {
                t.css({"margin-top": "0"})
            }, duration: 200, easing: easing_swiftOut})
    },
    onDropdownClose: function (t) {
        t.show().velocity("slideUp", {complete: function () {
                t.css({"margin-top": ""})
            }, duration: 200, easing: easing_swiftOut})
    }
});
$("#unit").selectize({
    onDropdownOpen: function (t) {
        t.hide().velocity("slideDown", {begin: function () {
                t.css({"margin-top": "0"})
            }, duration: 200, easing: easing_swiftOut})
    },
    onDropdownClose: function (t) {
        t.show().velocity("slideUp", {complete: function () {
                t.css({"margin-top": ""})
            }, duration: 200, easing: easing_swiftOut})
    }
});
altair_forms.parsley_validation_config();
$(function () {
    altair_form_validation.init()
}), altair_form_validation = {
    init: function ()
    {
        var i = $("#form-modal");
        i.parsley().on("form:validated", function () {
            altair_md.update_input(i.find(".md-input-danger"))
        }).on("field:validated", function (i) {
            $(i.$element).hasClass("md-input") && altair_md.update_input($(i.$element))
        }), window.Parsley.on("field:validate", function () {
            var i = $(this.$element).closest(".md-input-wrapper").siblings(".error_server_side");
            i && i.hide()
        })
    }
};
//add
$('body').on('click', '#btn-add', function (e) {
    e.preventDefault();
    showModal('form');
    $('#save_method').val('add');
    $('#id').val('');
    $('#id').removeAttr('readonly');
    $('#name').val('');
    $('#type')[0].selectize.setValue('');
    $('#unit')[0].selectize.setValue('');
    $('#cost').val('0');
    $('#price').val('0');
    $('#form-modal input[type=text]').each(function () {
        if ($(this).val().length == 0) {
            $(this).parent('div.md-input-wrapper').removeClass('md-input-filled');
        }
    });
});
// Edit button
$('body').on('click', '.btn-edit', function (e) {
    e.preventDefault();
    $('#save_method').val('edit');
    var id = $(this).attr('data-id');
    $.ajax({
        url: current_url + "/get/" + id,
        method: 'post',
        success: function (response) {
            var data = JSON.parse(response);
            $('#id').val(data.id);
            $('#id').attr('readonly', 'readonly');
            $('#name').val(data.name);
            $('#type')[0].selectize.setValue(data.type);
            $('#unit')[0].selectize.setValue(data.unit);
            $('#cost').val(data.cost);
            $('#price').val(data.price);
            $('#form-modal input[type=text]').each(function () {
                if ($(this).val().length > 0) {
                    $(this).parent('div.md-input-wrapper').addClass('md-input-filled');
                }
            });
            showModal('form');
        }
    });
});