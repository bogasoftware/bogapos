<div class="login_page_wrapper">
    <div class="md-card" id="login_card">
        <div class="md-card-content large-padding" id="login_form">
            <h2 class="heading_a uk-margin-medium-bottom uk-text-center"><?php echo lang('login_heading'); ?></h2>
            <div id="message"></div>
            <form id="login" method="post">
                <div class="uk-form-row parsley-row">
                    <label for="identity"><?php echo lang('login_identity_label'); ?></label>
                    <input class="md-input" autocomplete="off" type="text" required="" id="identity" name="identity" />
                </div>
                <div class="uk-form-row parsley-row">
                    <label for="password"><?php echo lang('login_password_label'); ?></label>
                    <input class="md-input" autocomplete="off" type="password" required="" id="password" name="password" />
                </div>
                <div class="uk-margin-medium-top">
                    <button class="md-btn md-btn-primary md-btn-block md-btn-large" type="submit"><?php echo lang('login_submit_btn'); ?></button>
                </div>
                <div class="uk-margin-top">
                    <a href="<?php echo site_url('auth/forgot_password'); ?>" class="uk-float-right"><?php echo lang('login_forgot_password'); ?></a>
                    <span class="icheck-inline">
                        <input type="checkbox" name="remember" id="remember" data-md-icheck />
                        <label for="remember" class="inline-label"><?php echo lang('login_remember_label'); ?></label>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>