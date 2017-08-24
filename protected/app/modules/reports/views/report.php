<div id="page_content_inner">
    <div class="uk-grid uk-grid-medium uk-grid-width-medium-1-2 uk-grid-width-large-1-3" data-uk-grid="{gutter: 30}">
        <div>
            <div class="md-card">
                <div class="md-card-head md-bg-light-blue-700 reports">
                    <h3 class="md-card-head-text uk-text-center md-color-white">
                        <?php echo number($total_sales); ?>                                
                        <span><?php echo lang('report_sales_heading') . get_month(date('F')); ?></span>
                    </h3>
                </div>
                <div class="md-card-content">
                    <ul class="md-list md-list-outside">
                        <li>
                            <a href="<?php echo site_url('reports/sales'); ?>" class="md-list-content">
                                <span class="md-list-heading"><?php echo lang('report_sales_chart_text'); ?></span>
                                <span class="uk-text-small uk-text-muted"><?php echo lang('report_sales_chart_help'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/sales/recap'); ?>" class="md-list-content">
                                <span class="md-list-heading"><?php echo lang('report_sales_recap_text'); ?></span>
                                <span class="uk-text-small uk-text-muted"><?php echo lang('report_sales_recap_help'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/sales/daily'); ?>" class="md-list-content">
                                <span class="md-list-heading"><?php echo lang('report_sales_daily_text'); ?></span>
                                <span class="uk-text-small uk-text-muted"><?php echo lang('report_sales_daily_help'); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-head md-bg-light-blue-700 reports">
                    <h3 class="md-card-head-text uk-text-center md-color-white">
                        <?php echo number($total_profit_loss); ?>                                
                        <span><?php echo lang('report_profit_loss_heading') . get_month(date('F')); ?></span>
                    </h3>
                </div>
                <div class="md-card-content">
                    <ul class="md-list md-list-outside">
                        <li>
                            <a href="<?php echo site_url('reports/profit_loss'); ?>" class="md-list-content">
                                <span class="md-list-heading"><?php echo lang('report_profit_loss_chart_text'); ?></span>
                                <span class="uk-text-small uk-text-muted"><?php echo lang('report_profit_loss_chart_help'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/profit_loss/recap'); ?>" class="md-list-content">
                                <span class="md-list-heading"><?php echo lang('report_profit_loss_recap_text'); ?></span>
                                <span class="uk-text-small uk-text-muted"><?php echo lang('report_profit_loss_recap_help'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/profit_loss/detail'); ?>" class="md-list-content">
                                <span class="md-list-heading"><?php echo lang('report_profit_loss_detail_text'); ?></span>
                                <span class="uk-text-small uk-text-muted"><?php echo lang('report_profit_loss_detail_help'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/profit_loss/net'); ?>" class="md-list-content">
                                <span class="md-list-heading"><?php echo lang('report_profit_loss_net_text'); ?></span>
                                <span class="uk-text-small uk-text-muted"><?php echo lang('report_profit_loss_net_help'); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-head md-bg-light-blue-700 reports">
                    <h3 class="md-card-head-text uk-text-center md-color-white">
                        <?php echo number($total_purchase); ?>                                
                        <span><?php echo lang('report_profit_loss_heading') . get_month(date('F')); ?></span>
                    </h3>
                </div>
                <div class="md-card-content">
                    <ul class="md-list md-list-outside">
                        <li>
                            <a href="<?php echo site_url('reports/purchase'); ?>" class="md-list-content">
                                <span class="md-list-heading"><?php echo lang('report_purchase_chart_text'); ?></span>
                                <span class="uk-text-small uk-text-muted"><?php echo lang('report_purchase_chart_help'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/purchase/recap'); ?>" class="md-list-content">
                                <span class="md-list-heading"><?php echo lang('report_purchase_recap_text'); ?></span>
                                <span class="uk-text-small uk-text-muted"><?php echo lang('report_purchase_recap_help'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/purchase/daily'); ?>" class="md-list-content">
                                <span class="md-list-heading"><?php echo lang('report_purchase_daily_text'); ?></span>
                                <span class="uk-text-small uk-text-muted"><?php echo lang('report_purchase_daily_help'); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
