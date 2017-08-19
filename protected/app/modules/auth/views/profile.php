<div id="page_content_inner">
    <form action="<?php echo site_url('auth/update_profile'); ?>" class="uk-form-stacked" id="form" method="post">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-large-1-2 uk-width-medium-1-1">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-form-row parsley-row">
                            <label for="fullname">Nama Lengkap</label>
                            <input class="md-input" required="" type="text" id="fullname" name="fullname" value="<?php echo $user->fullname; ?>"/>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="phone">No. Handphone</label>
                            <input class="md-input" required="" type="text" id="phone" name="phone" value="<?php echo $user->phone; ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-large-1-2 uk-width-medium-1-1">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-form-row parsley-row">
                            <label for="email">Email</label>
                            <input class="md-input" required="" type="email" id="email" disabled name="email" value="<?php echo $user->email; ?>"/>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="password_old">Password Lama</label>
                            <input class="md-input" type="password" id="password_old" name="password_old"/>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="password">Password Baru</label>
                            <input class="md-input" type="password" id="password" name="password"/>
                            <span class="uk-form-help-block">*untuk merubah password isi password lama dan password baru</span>
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