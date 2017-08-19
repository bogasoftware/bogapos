<div id="page_content_inner">
    <div class="uk-grid uk-grid-width-large-1-3 uk-grid-width-medium-1-1 uk-grid-medium" data-uk-grid-margin>
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <span class="uk-text-muted uk-text-small"><?php echo lang('home_sale_this_month_heading'); ?></span>
                    <h2 class="uk-margin-remove"><?php echo number($sales->total); ?></h2>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <span class="uk-text-muted uk-text-small"><?php echo lang('home_purchase_this_month_heading'); ?></span>
                    <h2 class="uk-margin-remove"><?php echo number($purchase->total); ?></h2>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <span class="uk-text-muted uk-text-small"><?php echo lang('home_profit_loss_this_month_heading'); ?></span>
                    <h2 class="uk-margin-remove"><?php echo number($profit_loss); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-1">
            <div class="md-card">
                <div class="md-card-content">
                    <h4 class="heading_c uk-margin-bottom"><?php echo lang('home_sale_vs_purchase_heading'); ?></h4>
                    <div id="sales-vs-purchase" class="c3chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>