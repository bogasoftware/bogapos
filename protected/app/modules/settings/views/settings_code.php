<div id="page_content_inner">
    <form action="<?php echo site_url('settings/save_code'); ?>" class="uk-form-stacked" id="form" method="post">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-large-7-10 uk-width-small-1-1">
                <?php foreach ($modules as $module) { ?>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-form-row parsley-row">
                                <label for="<?php echo 'code_format_' . $module; ?>"><?php echo lang('setting_code_format_' . $module . '_label'); ?></label>
                                <input class="md-input" required="" type="text" id="<?php echo 'code_format_' . $module; ?>" name="<?php echo 'code_format_' . $module; ?>" value="<?php echo settings('code_format_' . $module); ?>"/>
                            </div>
                            <div class="uk-margin-top">
                                <button type="button" class="md-btn md-btn-mini" onclick="insertCode(this)" data-id="<?php echo $module; ?>" data-text="[IN]">[IN]</button>
                                <button type="button" class="md-btn md-btn-mini" onclick="insertCode(this)" data-id="<?php echo $module; ?>" data-text="[MONTH]">[MONTH]</button>
                                <button type="button" class="md-btn md-btn-mini" onclick="insertCode(this)" data-id="<?php echo $module; ?>" data-text="[YEAR]">[YEAR]</button>
                                <button type="button" class="md-btn md-btn-mini" onclick="insertCode(this)" data-id="<?php echo $module; ?>" data-text="[MY]">[MY]</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="uk-width-large-3-10 uk-width-small-1-1">
                <div class="md-card">
                    <div class="md-card-content"><?php echo lang('setting_code_help'); ?></div>
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