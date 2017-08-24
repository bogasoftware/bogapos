<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
    <div class="heading_actions">
        <a href="<?php echo site_url('reports/profit_loss'); ?>" class="md-btn md-btn-wave waves-effect waves-button"><?php echo lang('report_chart_text'); ?></a>
        <a href="<?php echo site_url('reports/profit_loss/recap'); ?>" class="md-btn md-btn-wave waves-effect waves-button"><?php echo lang('report_recap_text'); ?></a>
        <a href="<?php echo site_url('reports/profit_loss/detail'); ?>" class="md-btn md-btn-wave waves-effect waves-button"><?php echo lang('report_detail_text'); ?></a>
    </div>
    <h1><?php echo lang('report_profit_loss_net_heading'); ?></h1>
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
                <table class="uk-table uk-table-align-vertical uk-table-hover uk-table-nowrap" id="table">
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>