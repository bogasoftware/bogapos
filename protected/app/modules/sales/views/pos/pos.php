<div id="page_content_inner">
    <form id="form" action="<?php echo site_url('sales/pos/save'); ?>" method="post">
        <input type="hidden" id="customer" name="customer">
        <input type="hidden" id="total-value" name="total-value">
        <input type="hidden" id="subtotal-value" name="subtotal-value">
        <input type="hidden" id="cash-value" name="cash-value">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-7-10">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-form">
                            <input type="text" id="searchProduct" placeholder="<?php echo lang('sale_search_product_cashier_label'); ?>" />
                        </div>
                    </div>
                </div>
                <div class="md-card uk-margin-small-top">
                    <div class="md-card-content uk-padding-remove">
                        <div style="padding-top: 10px;">
                            <table id="products" class="uk-table">
                                <thead class="md-bg-grey-200">
                                    <tr>
                                        <th style="width: 2%;"></th>
                                        <th style="width: 50%;" class="uk-text-center"><?php echo lang('sale_product_name_label'); ?></th>
                                        <th style="width: 15%;" class="uk-text-center"><?php echo lang('sale_product_price_label'); ?></th>
                                        <th style="width: 8%;" class="uk-text-center"><?php echo lang('sale_product_quantity_label'); ?></th>
                                        <th style="width: 10%;" class="uk-text-center"><?php echo lang('sale_product_discount_label'); ?>(%)</th>
                                        <th style="width: 15%;" class="uk-text-center"><?php echo lang('sale_product_subtotal_label'); ?></th>
                                    </tr>
                                </thead>
                                <tbody class="uk-form"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-3-10">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-grid">
                            <div class="uk-width-1-1">
                                <div class="uk-autocomplete uk-position-relative uk-loading uk-input-group" data-uk-autocomplete="{source:'<?php echo site_url('sales/get_customers'); ?>',minLength:'1'}" id="customer_autocomplete">
                                    <label for="customer_name"><?php echo lang('sale_customer_label'); ?></label>
                                    <input type="text" name="customer_name" id="customer_name"  class="md-input" />
                                    <span class="uk-input-group-addon" id="customer_change" style="display: none;">
                                        <a href="javascript:change_customer()" data-uk-tooltip title="<?php echo lang('sale_edit_customer_label'); ?>"><i class="material-icons">cached</i></a>
                                    </span>
                                    <script type="text/autocomplete">
                                        <ul class="uk-nav uk-nav-autocomplete uk-autocomplete-results">
                                        {{~items}}
                                        <li data-value="{{ $item.value }}" data-name="{{ $item.title }}">
                                        <a>
                                        {{ $item.title }}
                                        <span>{{{ $item.city }}}</span>
                                        </a>
                                        </li>
                                        {{/items}}
                                        </ul>
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-1-1">
                                <div class="uk-grid uk-grid-small">
                                    <div class="uk-width-1-2">
                                        <span class="uk-text-muted uk-text-small"><?php echo lang('sale_total_product_label'); ?></span>
                                    </div>
                                    <div class="uk-width-1-2 uk-text-right">
                                        <span class="uk-text-large uk-text-middle" id="total-product">0</span>
                                    </div>
                                </div>
                                <div class="uk-grid uk-grid-small">
                                    <div class="uk-width-1-2">
                                        <span class="uk-text-muted uk-text-small"><?php echo lang('sale_subtotal_label'); ?></span>
                                    </div>
                                    <div class="uk-width-1-2 uk-text-right">
                                        <span class="uk-text-large uk-text-middle" id="subtotal">0</span>
                                    </div>
                                </div>
                                <div class="uk-grid uk-grid-small">
                                    <div class="uk-width-1-2">
                                        <span class="uk-text-muted uk-text-small"><?php echo lang('sale_discount_label'); ?></span>
                                    </div>
                                    <div class="uk-width-1-2 uk-text-right uk-form">
                                        <input type="text" name="discount" id="discount" class="input-number uk-text-right" value="0" />
                                    </div>
                                </div>
                                <?php if (settings('enable_tax') == true) { ?>
                                    <div class="uk-grid uk-grid-small">
                                        <div class="uk-width-1-2">
                                            <span class="uk-text-muted uk-text-small"><?php echo lang('sale_tax_label'); ?></span>
                                        </div>
                                        <div class="uk-width-1-2 uk-text-right uk-form">
                                            <div class="uk-grid uk-grid-collapse">
                                                <div class="uk-width-medium-3-10">
                                                    <input type="text" name="tax" maxlength="2" id="tax" class="input-number uk-text-right" value="0" />
                                                </div>
                                                <div class="uk-width-medium-7-10">
                                                    <input type="text" name="tax-value" id="tax-value" class="input-number uk-text-right" value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="uk-grid uk-grid-small">
                                    <div class="uk-width-1-2">
                                        <span class=""><?php echo lang('sale_total_label'); ?></span>
                                    </div>
                                    <div class="uk-width-1-2 uk-text-right">
                                        <span id="total" style="font-weight: bold; font-size: 22px;">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid">
                            <div class="uk-width-1-2 uk-text-center">
                                <button type="button" id="cancel" class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light"><?php echo lang('action_cancel_button'); ?></button>
                            </div>
                            <div class="uk-width-1-2 uk-text-center">
                                <button type="button" id="payment" class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"><?php echo lang('action_pay_button'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="uk-modal" id="modal-products">
    <div class="uk-modal-dialog uk-modal-dialog-large" style="width: 900px;">
        <button type="button" class="uk-modal-close uk-close"></button>
        <div id="products-list"></div>
    </div>
</div>
<div class="uk-modal" id="modal-payment">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-3">
                <span class="text-field"><?php echo lang('sale_total_label'); ?></span>
            </div>
            <div class="uk-width-medium-2-3">
                <span class="field md-bg-grey-200" id="payment-total"></span>
            </div>
        </div>
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-3">
                <span class="text-field"><?php echo lang('sale_pay_label'); ?></span>
            </div>
            <div class="uk-width-medium-2-3">
                <input type="text" name="cash" id="cash" class="md-input field input-number" value="0" />
            </div>
        </div>
        <div class="uk-grid" id="credit" data-uk-grid-margin>
            <div class="uk-width-medium-1-3">
                <span class="text-field"><?php echo lang('sale_due_label'); ?></span>
            </div>
            <div class="uk-width-medium-2-3">
                <span class="field md-bg-grey-200" id="payment-credit"></span>
            </div>
        </div>
        <div class="uk-grid" id="change" data-uk-grid-margin>
            <div class="uk-width-medium-1-3">
                <span class="text-field"><?php echo lang('sale_change_label'); ?></span>
            </div>
            <div class="uk-width-medium-2-3">
                <span class="field md-bg-grey-200" id="payment-change"></span>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close"><?php echo lang('action_cancel_button'); ?></button>
            <button type="button" id="save" class="md-btn md-btn-flat md-btn-large md-btn-flat-primary"><?php echo lang('action_save_button'); ?></button>
        </div>
    </div>
</div>