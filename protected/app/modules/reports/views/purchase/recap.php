<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
    <div class="heading_actions">
        <a href="<?php echo site_url('reports/purchase'); ?>" class="md-btn md-btn-wave waves-effect waves-button"><?php echo lang('report_chart_text'); ?></a>
        <a href="<?php echo site_url('reports/purchase/daily'); ?>" class="md-btn md-btn-wave waves-effect waves-button"><?php echo lang('report_daily_text'); ?></a>
    </div>
    <h1><?php echo lang('report_purchase_recap_heading'); ?></h1>
    <span class="uk-text-small"><?php echo lang('report_periode_date_text'); ?> <span id="date-start-display"></span> - <span id="date-end-display"></span></span>
</div>
<div id="page_content_inner">
    <div class="md-card uk-margin-small-bottom" id="filter-form">
        <div class="md-card-toolbar">
            <div class="md-card-toolbar-actions">
                <i class="md-icon material-icons md-card-toggle" id="filter-form-toggle">&#xE316;</i>
            </div>
            <h3 class="md-card-toolbar-heading-text"><?php echo lang('report_filter_text'); ?></h3>
        </div>
        <div class="md-card-content">
            <div class="uk-grid">
                <div class="uk-width-medium-7-10">
                    <div class="uk-grid">
                        <div class="uk-width-medium-1-2">
                            <label><?php echo lang('report_periode_start_label'); ?></label>
                            <input type="text" id="date-start" readonly="" class="md-input" data-uk-datepicker="{format:'<?php echo settings('date_format_uk'); ?>'}" value="<?php echo get_date(date('Y-m-01')); ?>" />
                        </div>
                        <div class="uk-width-medium-1-2">
                            <label><?php echo lang('report_periode_end_label'); ?></label>
                            <input type="text" id="date-end" readonly="" class="md-input" data-uk-datepicker="{format:'<?php echo settings('date_format_uk'); ?>'}" value="<?php echo get_date(date('Y-m-t')); ?>" />
                        </div>
                    </div>
                </div>
                <div class="uk-width-medium-3-10">
                    <a href="javascript:void(0);" id="generate" class="md-btn md-btn-primary md-btn-wave waves-effect waves-button"><?php echo lang('action_submit_button'); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="md-card  uk-margin-small-top">
        <div class="md-card-content">
            <div class="uk-overflow-container uk-margin-bottom">
                <table class="uk-table uk-table-align-vertical uk-table-hover uk-table-nowrap tablesorter tablesorter-altair" id="table">
                    <thead>
                        <tr>
                            <th><?php echo lang('report_purchase_code_label'); ?></th>
                            <th><?php echo lang('report_purchase_date_label'); ?></th>
                            <th><?php echo lang('report_purchase_supplier_label'); ?></th>
                            <th class="uk-text-right"><?php echo lang('report_purchase_subtotal_label'); ?></th>
                            <th class="uk-text-right"><?php echo lang('report_purchase_discount_label'); ?></th>
                            <th class="uk-text-right"><?php echo lang('report_purchase_tax_label'); ?></th>
                            <th class="uk-text-right"><?php echo lang('report_purchase_shipping_cost_label'); ?></th>
                            <th class="uk-text-right"><?php echo lang('report_purchase_total_label'); ?></th>
                            <th class="uk-text-right"><?php echo lang('report_purchase_cash_label'); ?></th>
                            <th class="uk-text-right"><?php echo lang('report_purchase_credit_label'); ?></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td id="subtotal" class="uk-text-right"></td>
                            <td id="discount" class="uk-text-right"></td>
                            <td id="tax" class="uk-text-right"></td>
                            <td id="shipping" class="uk-text-right"></td>
                            <td id="total" class="uk-text-right"></td>
                            <td id="cash" class="uk-text-right"></td>
                            <td id="credit" class="uk-text-right"></td>
                        </tr>
                    </tfoot>
                    <tbody></tbody>
                </table>
            </div>
            <ul class="uk-pagination ts_pager">
                <li data-uk-tooltip title="Select Page">
                    <select class="ts_gotoPage ts_selectize"></select>
                </li>
                <li class="first"><a href="javascript:void(0)"><i class="uk-icon-angle-double-left"></i></a></li>
                <li class="prev"><a href="javascript:void(0)"><i class="uk-icon-angle-left"></i></a></li>
                <li><span class="pagedisplay"></span></li>
                <li class="next"><a href="javascript:void(0)"><i class="uk-icon-angle-right"></i></a></li>
                <li class="last"><a href="javascript:void(0)"><i class="uk-icon-angle-double-right"></i></a></li>
                <li data-uk-tooltip title="Page Size">
                    <select class="pagesize ts_selectize">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </li>
            </ul>
        </div>
    </div>
</div>