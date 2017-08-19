<div id="page_content_inner">
    <form action="<?php echo site_url('settings/save'); ?>" class="uk-form-stacked" id="form" method="post">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-large-1-3 uk-width-medium-1-1">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-form-row parsley-row">
                            <label for="name">Nama Perusahaan</label>
                            <input class="md-input" required="" type="text" id="name" name="name" value="<?php echo $merchant->name; ?>"/>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="description">Deskripsi Singkat Perusahaan</label>
                            <textarea class="md-input" required="" name="description" id="description" cols="30" rows="2"><?php echo $merchant->description; ?></textarea>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="address">Alamat</label>
                            <textarea class="md-input" required="" name="address" id="address" cols="30" rows="2"><?php echo $merchant->address; ?></textarea>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="telephone">Telepon</label>
                            <input class="md-input" required="" type="text" id="telephone" name="telephone" value="<?php echo $merchant->telephone; ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-large-1-3 uk-width-medium-1-2">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-form-row parsley-row">
                            <label for="default_customer">Konsumen Default</label>
                            <select id="default_customer" required="" name="default_customer" data-md-selectize data-md-selectize-bottom>
                                <?php foreach ($customers->result() as $customer) { ?>
                                    <option value="<?php echo $customer->id; ?>" <?php echo ($customer->id == $merchant->default_customer) ? 'selected' : ''; ?>><?php echo $customer->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="default_supplier">Pemasok Default</label>
                            <select id="default_supplier" required=""  name="default_supplier" data-md-selectize data-md-selectize-bottom>
                                <?php foreach ($suppliers->result() as $supplier) { ?>
                                    <option value="<?php echo $supplier->id; ?>" <?php echo ($customer->id == $merchant->default_supplier) ? 'selected' : ''; ?>><?php echo $supplier->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-large-1-3 uk-width-medium-1-2">
                <div class="md-card">
                    <div class="md-card-content">
                        <ul class="md-list">
                            <li>
                                <div class="md-list-content">
                                    <div class="uk-float-right">
                                        <input type="checkbox" data-switchery <?php echo $merchant->enable_tax == 1 ? 'checked' : ''; ?> id="enable_tax" name="enable_tax" value="1" />
                                    </div>
                                    <span class="md-list-heading">Aktifkan Pajak</span>
                                    <span class="uk-text-muted uk-text-small">Akan ditampilkan form isian pajak pada penjualan dan pembelian</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="md-fab-wrapper">
            <button type="submit" class="md-fab md-fab-primary" href="#" id="page_settings_submit">
                <i class="material-icons">&#xE161;</i>
            </button>
        </div>

    </form>

</div>