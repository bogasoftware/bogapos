<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
    <div class="heading_actions">
        <a href="<?php echo site_url('reports/purchase/recap'); ?>" class="md-btn md-btn-wave waves-effect waves-button"><?php echo lang('report_recap_text'); ?></a>
        <a href="<?php echo site_url('reports/purchase/daily'); ?>" class="md-btn md-btn-wave waves-effect waves-button"><?php echo lang('report_daily_text'); ?></a>
    </div>
    <h1><?php echo lang('report_purchase_chart_heading'); ?></h1>
    <span class="uk-text-small"><?php echo lang('report_periode_date_text'); ?> 01 <?php echo get_month('January'); ?> <span class="year"></span> - 31 <?php echo get_month('December'); ?> <span class="year"></span></span>
</div>
<div id="page_content_inner">
    <div class="uk-grid uk-grid-small">
        <div class="uk-width-1-2">
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
                    <h3 class="md-card-toolbar-heading-text"><?php echo lang('report_purchase_monthly_text'); ?></h3>
                </div>
                <div class="md-card-content">
                    <div id="purchase-monthly-chart" class="c3chart"></div>
                </div>
            </div>
        </div>
        <div class="uk-width-1-2">
            <div class="md-card">
                <div class="md-card-toolbar">
                    <div class="md-card-toolbar-actions">
                        <div class="uk-float-right">
                            <select id="select-product" >
                                <?php
                                if ($products) {
                                    foreach ($products->result() as $product) {
                                        echo '<option value="' . $product->id . '">' . $product->name . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <h3 class="md-card-toolbar-heading-text"><?php echo lang('report_purchase_product_monthly_text'); ?></h3>
                </div>
                <div class="md-card-content">
                    <div id="purchase-product-monthly-chart" class="c3chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>