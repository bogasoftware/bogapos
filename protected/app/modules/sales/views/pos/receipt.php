<style>
    @media print {
        @page { margin: 0; }
        body  { 
            margin-bottom: 0;
            margin-right: 0;
            margin-left: 0;
            margin-top: -30px;
        }
    }
</style>
<script>
    window.print();
</script>
<div id="page_content_inner">
    <div class="uk-width-medium-6-10 uk-container-center reset-print">
        <?php if ($this->input->get('back') == 1) { ?>
            <button class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light hidden-print" onclick="javascript:window.location.href = base_url + 'sales/pos/';"><?php echo lang('action_finish_button'); ?></button>
        <?php } else { ?>
            <button class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light hidden-print" onclick="javascript:window.close();"><?php echo lang('action_finish_button'); ?></button>
        <?php } ?>
        <div class="md-card md-card-single main-print">
            <div class="md-card-content invoice_content print_bg invoice_footer_active">
                <div class="uk-margin-small-bottom">
                    <h3 class="heading_a uk-text-center"> <?php echo $store->name; ?> </h3>
                    <div class="uk-text-center uk-text-small"><?php echo nl2br($store->address); ?></div>
                    <div class="uk-text-center uk-text-small"><?php echo $store->city; ?></div>
                    <div class="uk-text-center uk-text-small"><?php echo $store->telephone; ?></div>
                    <span><?php echo lang('sale_code_receipt_label'); ?>: <?php echo $data->code; ?></span><br>
                    <span><?php echo lang('sale_customer_label'); ?>: <?php echo $data->customer_name; ?></span><br>
                    <span><?php echo lang('sale_date_label'); ?>: <?php echo date_time($data->date); ?></span>
                </div>
                <div class="uk-grid uk-margin-large-bottom">
                    <div class="uk-width-1-1">
                        <table class="uk-table receipt-table">
                            <?php
                            $i = 1;
                            foreach ($products->result() as $product) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo '#' . $i . ': ' . $product->product_name . ' <span class="uk-text-small">(' . $product->product_code . ')</span>'; ?><br>
                                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;' . number($product->quantity) . ' x ' . number($product->net_price) . ($product->discount ? ' (pot. ' . $product->discount . '%)' : ''); ?>
                                    </td>
                                    <td class="uk-text-right">
                                        <?php echo '*'; ?><br>
                                        <?php echo number($product->subtotal); ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            <tfoot>
                                <tr>
                                    <td>
                                        <?php
                                        echo lang('sale_subtotal_label');
                                        echo '<br>' . lang('sale_discount_label');
                                        if ($data->tax > 0) {
                                            echo '<br>' . lang('sale_tax_label') . ' (' . number($data->tax) . '%)';
                                        }
                                        ?>
                                    </td>
                                    <td class="uk-text-right">
                                        <?php
                                        echo number($data->subtotal);
                                        echo '<br>' . number($data->discount);
                                        if ($data->tax > 0) {
                                            echo '<br>' . number($tax = ($data->subtotal - $data->discount) * $data->tax / 100);
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                        echo '<b style="font-size:18px;">Total</b>';
                                        echo '<br>'. lang('sale_cash_label');
                                        echo '<br>'. lang('sale_change_label');
                                        ?>

                                    </td>
                                    <td class="uk-text-right">
                                        <?php
                                        echo '<b style="font-size:18px;">' . number($data->grand_total) . '</b>';
                                        echo '<br>' . number($data->cash);
                                        echo '<br>' . number($data->change);
                                        ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>