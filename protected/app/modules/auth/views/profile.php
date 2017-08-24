<div id="page_content_inner">
    <form action="<?php echo site_url('auth/update_profile'); ?>" class="uk-form-stacked" id="form" method="post">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-large-1-2 uk-width-medium-1-1">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-form-row parsley-row">
                            <label for="fullname"><?php echo lang('account_fullname_label'); ?></label>
                            <input class="md-input" required="" type="text" id="fullname" name="fullname" value="<?php echo $user->fullname; ?>"/>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="phone"><?php echo lang('account_phone_label'); ?></label>
                            <input class="md-input" required="" type="text" id="phone" name="phone" value="<?php echo $user->phone; ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-large-1-2 uk-width-medium-1-1">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-form-row parsley-row">
                            <label for="email"><?php echo lang('account_email_label'); ?></label>
                            <input class="md-input" required="" type="email" id="email" disabled name="email" value="<?php echo $user->email; ?>"/>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="password_old"><?php echo lang('account_old_password_label'); ?></label>
                            <input class="md-input" type="password" id="password_old" name="password_old"/>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="password"><?php echo lang('account_new_password_label'); ?></label>
                            <input class="md-input" type="password" id="password" name="password"/>
                            <span class="uk-form-help-block"><?php echo lang('account_new_password_help'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="md-fab-wrapper">
            <button type="submit" class="md-fab md-fab-primary">
                <i class="material-icons">&#xE161;</i>
            </button>
        </div>

    </form>

</div>