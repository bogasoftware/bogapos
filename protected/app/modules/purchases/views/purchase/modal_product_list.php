<div class="md-card">
    <div class="md-card-content">
        <div class="uk-overflow-container uk-margin-bottom">
            <table class="uk-table uk-table-align-vertical uk-table-hover uk-table-nowrap tablesorter tablesorter-altair" id="table">
                <thead>
                    <tr>
                        <th class="filter-false sorter-false">1</th>
                        <th <?php echo ($search) ? 'data-value="' . $search . '"' : ''; ?>>>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <ul class="uk-pagination ts_pager">
            <li class="first"><a href="javascript:void(0)"><i class="uk-icon-angle-double-left"></i></a></li>
            <li class="prev"><a href="javascript:void(0)"><i class="uk-icon-angle-left"></i></a></li>
            <li><span class="pagedisplay"></span></li>
            <li class="next"><a href="javascript:void(0)"><i class="uk-icon-angle-right"></i></a></li>
            <li class="last"><a href="javascript:void(0)"><i class="uk-icon-angle-double-right"></i></a></li>
            <li data-uk-tooltip title="Page Size">
                <select class="pagesize ts_selectize">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        if (Modernizr.touch) {
            var e = $(".focus-highlight");
            e.length && e.find("td, th").attr("tabindex", "1").on("touchstart", function () {
                $(this).focus()
            }), $(".tablesorter").find("th").addClass("needsclick")
        }
        var t = $("#table"),
                n = {
                    container: $(".ts_pager"),
                    fixedHeight: !0,
                    removeRows: !1,
                    output: "{startRow} - {endRow} / {filteredRows} ({totalRows})",
                    ajaxUrl: base_url + 'purchases/get_list_modal_products?page={page}&size={size}&{filterList:fcol}&{sortList:col}',
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
            widgets: ["filter", ],
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
    });
</script>