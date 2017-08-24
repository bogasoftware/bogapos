<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
    <div class="heading_actions">
        <a href="<?php echo site_url('reports/profit_loss/recap'); ?>" class="md-btn md-btn-wave waves-effect waves-button"><?php echo lang('report_recap_text'); ?></a>
        <a href="<?php echo site_url('reports/profit_loss/detail'); ?>" class="md-btn md-btn-wave waves-effect waves-button"><?php echo lang('report_detail_text'); ?></a>
        <a href="<?php echo site_url('reports/profit_loss/net'); ?>" class="md-btn md-btn-wave waves-effect waves-button"><?php echo lang('report_profit_loss_net_text'); ?></a>
    </div>
    <h1><?php echo lang('report_profit_loss_chart_heading'); ?></h1>
    <span class="uk-text-small"><?php echo lang('report_periode_date_text'); ?> 01 <?php echo get_month('January'); ?> <span class="year"></span> - 31 <?php echo get_month('December'); ?> <span class="year"></span></span>
</div>
<div id="page_content_inner">
    <div class="uk-grid uk-grid-small">
        <div class="uk-width-1-1">
            <div class="md-card">
                <div class="md-card-toolbar">
                    <div class="md-card-toolbar-actions">
                        <div class="uk-float-right">
                            <select id="select-year">
                                <?php
                                if ($years) {
                                    foreach ($years->result() as $year) {
                                        echo '<option value="' . $year->year . '" ' . ($year->year == date('Y') ? 'selected' : '') . '>' . $year->year . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <h3 class="md-card-toolbar-heading-text">
                        <?php echo lang('report_profit_loss_monthly_text'); ?>
                    </h3>
                </div>
                <div class="md-card-content">
                    <div id="profit-loss-monthly-chart" class="c3chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>