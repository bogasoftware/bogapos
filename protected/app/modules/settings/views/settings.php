<div id="page_content_inner">
    <form action="<?php echo site_url('settings/save'); ?>" class="uk-form-stacked" id="form" method="post">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-large-1-3 uk-width-medium-1-1">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-form-row parsley-row">
                            <label for="name"><?php echo lang('setting_name_label'); ?></label>
                            <input class="md-input" required="" type="text" id="name" name="store_name" value="<?php echo $settings->store_name; ?>"/>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="address"><?php echo lang('setting_address_label'); ?></label>
                            <textarea class="md-input" required="" name="store_address" id="address" cols="30" rows="2"><?php echo $settings->store_address; ?></textarea>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="telephone"><?php echo lang('setting_phone_label'); ?></label>
                            <input class="md-input" required="" type="text" id="telephone" name="store_phone" value="<?php echo $settings->store_phone; ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-large-1-3 uk-width-medium-1-2">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-form-row parsley-row">
                            <label for="language"><?php echo lang('setting_language_label'); ?></label>
                            <select id="language" required="" name="language" data-md-selectize data-md-selectize-bottom>
                                <option value="indonesian" <?php echo ($settings->language == 'indonesian') ? 'selected' : ''; ?>>Bahasa Indonesia</option>
                                <option value="english" <?php echo ($settings->language == 'english') ? 'selected' : ''; ?>>English</option>
                            </select>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="timezone"><?php echo lang('setting_timezone_label'); ?></label>
                            <select id="timezone" required="" name="timezone" data-md-selectize data-md-selectize-bottom>
                                <?php foreach ($timezones as $timezone) { ?>
                                <option value="<?php echo $timezone; ?>" <?php echo ($settings->timezone == $timezone) ? 'selected' : ''; ?>><?php echo $timezone; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="default_customer"><?php echo lang('setting_default_customer_label'); ?></label>
                            <select id="default_customer" required="" name="default_customer" data-md-selectize data-md-selectize-bottom>
                                <?php foreach ($customers->result() as $customer) { ?>
                                    <option value="<?php echo $customer->id; ?>" <?php echo ($customer->id == $settings->default_customer) ? 'selected' : ''; ?>><?php echo $customer->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="default_supplier"><?php echo lang('setting_default_supplier_label'); ?></label>
                            <select id="default_supplier" required=""  name="default_supplier" data-md-selectize data-md-selectize-bottom>
                                <?php foreach ($suppliers->result() as $supplier) { ?>
                                    <option value="<?php echo $supplier->id; ?>" <?php echo ($customer->id == $settings->default_supplier) ? 'selected' : ''; ?>><?php echo $supplier->name; ?></option>
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
                                        <input type="checkbox" data-switchery <?php echo ($settings->enable_tax=='true') ? 'checked' : ''; ?> id="enable_tax" name="enable_tax" value="true" />
                                    </div>
                                    <span class="md-list-heading"><?php echo lang('setting_enable_tax_label'); ?></span>
                                    <span class="uk-text-muted uk-text-small"><?php echo lang('setting_enable_tax_help'); ?></span>
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