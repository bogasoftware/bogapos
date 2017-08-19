<div id="page_content_inner">
    <form id="form" action="<?php echo site_url('purchases/save'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" value="<?php echo ($data) ? $data->id : ''; ?>">
        <input type="hidden" id="save_method" name="save_method" value="<?php echo ($data) ? 'edit' : 'add'; ?>">
        <input type="hidden" id="supplier" name="supplier">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <div class="uk-form-row">
                            <div class="uk-grid">
                                <div class="uk-width-1-3">
                                    <label for="date"><?php echo lang('purchase_date_label'); ?></label>
                                    <input type="text" name="date" id="date" readonly class="md-input" data-uk-datepicker="{format:'YYYY-MM-DD'}"/>
                                </div>
                                <div class="uk-width-1-3">
                                    <label for="code"><?php echo lang('purchase_code_label'); ?></label>
                                    <input type="text" name="code" id="code" class="md-input" />
                                </div>
                                <div class="uk-width-1-3">
                                    <div class="uk-autocomplete uk-position-relative uk-loading uk-input-group" data-uk-autocomplete="{source:'<?php echo site_url('purchases/get_suppliers'); ?>',minLength:'1'}" id="supplier_autocomplete">
                                        <label for="supplier_name"><?php echo lang('purchase_supplier_label'); ?></label>
                                        <input type="text" name="supplier_name" id="supplier_name"  class="md-input" />
                                        <span class="uk-input-group-addon" id="supplier_change" style="display: none">
                                            <a href="javascript:change_supplier()" data-uk-tooltip title="<?php echo lang('purchase_edit_supplier_label'); ?>"><i class="material-icons">cached</i></a>
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
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <table id="products" class="uk-table">
                            <thead class="md-bg-grey-300">
                                <tr>
                                    <th style="width: 2%;"></th>
                                    <th style="width: 50%;" class="uk-text-center"><?php echo lang('purchase_product_name_label'); ?></th>
                                    <th style="width: 15%;" class="uk-text-center"><?php echo lang('purchase_product_price_label'); ?> <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo lang('purchase_product_price_help'); ?>">info</i></th>
                                    <th style="width: 8%;" class="uk-text-center"><?php echo lang('purchase_product_quantity_label'); ?></th>
                                    <th style="width: 10%;" class="uk-text-center"><?php echo lang('purchase_product_discount_label'); ?>(%)</th>
                                    <th style="width: 15%;" class="uk-text-center"><?php echo lang('purchase_product_subtotal_label'); ?></th>
                                </tr>
                            </thead>
                            <tbody class="uk-form"></tbody>
                        </table>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-2">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-1-2">
                                <div class="uk-form-row">
                                    <label for="note"><?php echo lang('purchase_note_label'); ?></label>
                                    <textarea name="note" id="note" class="md-input"></textarea>
                                </div>
                            </div>
                            <div class="uk-width-1-2">
                                <div class="uk-form-row">
                                    <input type="checkbox" name="shipping_check" id="shipping_check" value="1" data-md-icheck />
                                    <label for="shipping_check" class="inline-label"><?php echo lang('purchase_delivery_label'); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-1-2">
                                <div class="uk-form-row uk-form">
                                    <div class="uk-grid">
                                        <label class="uk-width-4-10" for="subtotal"><?php echo lang('purchase_subtotal_label'); ?></label>
                                        <div class="uk-width-6-10">
                                            <input type="text" name="subtotal" id="subtotal" class="input-number" disabled value="0" />
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-row uk-form uk-margin-top">
                                    <div class="uk-grid">
                                        <label class="uk-width-4-10" for="discount"><?php echo lang('purchase_discount_label'); ?></label>
                                        <div class="uk-width-6-10">
                                            <input type="text" name="discount" id="discount" class="input-number" value="0" />
                                        </div>
                                    </div>
                                </div>
                                <?php if (settings('enable_tax') == true) { ?>
                                    <div class="uk-form-row uk-form uk-margin-top">
                                        <div class="uk-grid">
                                            <label class="uk-width-4-10" for="tax"><?php echo lang('purchase_tax_label'); ?></label>
                                            <div class="uk-width-6-10">
                                                <div class="uk-grid uk-grid-collapse">
                                                    <div class="uk-width-medium-3-10">
                                                        <input type="text" name="tax" maxlength="2" id="tax" class="input-number" value="0" />
                                                    </div>
                                                    <div class="uk-width-medium-7-10">
                                                        <input type="text" name="tax-value" id="tax-value" disabled="" class="input-number" value="0" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="uk-form-row uk-form uk-margin-top" id="shipping-form"  style="display: none">
                                    <div class="uk-grid">
                                        <label class="uk-width-4-10" for="shipping"><?php echo lang('purchase_shipping_cost_label'); ?></label>
                                        <div class="uk-width-6-10">
                                            <input type="text" name="shipping" id="shipping" class="input-number" value="0" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-2">
                                <div class="uk-form-row uk-form">
                                    <div class="uk-grid">
                                        <label class="uk-width-4-10" for="total"><?php echo lang('purchase_total_label'); ?></label>
                                        <div class="uk-width-6-10">
                                            <input type="text" name="total" id="total" class="input-number" disabled value="0" />
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-row uk-form uk-margin-top">
                                    <div class="uk-grid">
                                        <label class="uk-width-4-10" for="cash"><?php echo lang('purchase_cash_label'); ?></label>
                                        <div class="uk-width-6-10">
                                            <input type="text" name="cash" id="cash" class="input-number" class="" value="0" />
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-row uk-form uk-margin-top">
                                    <div class="uk-grid">
                                        <label class="uk-width-4-10" for="credit"><?php echo lang('purchase_credit_label'); ?></label>
                                        <div class="uk-width-6-10">
                                            <input type="text" name="credit" id="credit" class="input-number" disabled value="0" />
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-form-row uk-form uk-margin-top" style="display: none" id="change-form">
                                    <div class="uk-grid">
                                        <label class="uk-width-4-10" for="change"><?php echo lang('purchase_change_label'); ?></label>
                                        <div class="uk-width-6-10">
                                            <input type="text" name="change" id="change" class="input-number" disabled value="0" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <button type="button" id="cancel" class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light uk-float-left"><?php echo lang('action_cancel_button'); ?></button>
                        <button type="button" id="save" class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light uk-float-right"><?php echo lang('action_save_button'); ?></button>
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
<script type="text/javascript">
<?php if ($data) { ?>
        var data = JSON.parse('<?php echo json_encode($data); ?>');
        localStorage.setItem('pcmethod', 'edit');
        localStorage.setItem('pcdate', data.date.substring(0, 10));
        localStorage.setItem('pccode', data.code);
        localStorage.setItem('pcsupplier', data.supplier);
        localStorage.setItem('pcsupplier_name', data.supplier_name);
    <?php if ($data->shipping) { ?>
            localStorage.setItem('pcshipping', '1');
            localStorage.setItem('pcshipping_cost', data.shipping);
    <?php } ?>
        localStorage.setItem('pcdiscount', data.discount);
        localStorage.setItem('pctax', data.tax);
        localStorage.setItem('pccash', data.cash);
        localStorage.setItem('pcnote', data.note);
        localStorage.setItem('pcproducts', '<?php echo json_encode($products); ?>');
        window.btn_clicked = false;
        document.getElementById('save').onclick = function () {
            window.btn_clicked = true;
        };
        window.onbeforeunload = function () {
            if (!window.btn_clicked) {
                removeSession();
                return 'If you leave now your order will be canceled.';
            }
        };
<?php } else { ?>
        localStorage.setItem('pcmethod', 'add');
        if (!localStorage.getItem('pcdate')) {
            localStorage.setItem('pcdate', '<?php echo date('Y-m-d'); ?>');
        }
    <?php if ($this->session->userdata('store')->id != 'all') { ?>
            if (!localStorage.getItem('pccode')) {
                localStorage.setItem('pccode', '<?php echo trx_code($this->session->userdata('store')->code, 'purchases', 'PC'); ?>');
            }
    <?php } ?>
        if (!localStorage.getItem('pcsupplier')) {
            localStorage.setItem('pcsupplier', '');
        }
        if (!localStorage.getItem('pcsupplier_name')) {
            localStorage.setItem('pcsupplier_name', '');
        }
<?php } ?>
</script>