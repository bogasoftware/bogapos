<table class="uk-table">
    <thead>
        <tr>
            <th><?php echo lang('product_store_label'); ?></th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($stores) { ?>
            <?php foreach ($stores->result() as $store) { ?>
                <tr>
                    <td><?php echo $store->name; ?></td>
                    <td>
                        <?php if ($method == 'add') { ?>
                            <input type="text" name="quantity[<?php echo $store->store; ?>]" id="tempat_lahir" class="md-input" value="<?php echo $store->quantity; ?>" />
                            <?php
                        } else {
                            echo $store->quantity;
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>
