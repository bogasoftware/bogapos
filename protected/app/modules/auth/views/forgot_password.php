<div class="login_page_wrapper">
    <div class="md-card" id="login_card">
        <div class="md-card-content large-padding">
            <h2 class="heading_a uk-margin-medium-bottom uk-text-center">Lupa Password Bogatoko</h2>
            <div id="message"></div>
            <form id="forgot-password" method="post">
                <p>Silahkan masukkan email login Anda, Anda akan menerima email untuk mendapatkan link reset password.</p>                    
                <div class="uk-form-row parsley-row">
                    <label for="email">Email</label>
                    <input class="md-input" autocomplete="off" type="text" required="" id="email" name="email" />
                </div>
                <div class="uk-margin-medium-top">
                    <button class="md-btn md-btn-primary md-btn-block md-btn-large" type="submit">Ganti Kata Sandi</button>
                </div>
            </form>
        </div>
    </div>
    <div class="uk-margin-top uk-text-center">
        <a href="<?php echo site_url('auth/login'); ?>">Masuk</a>
    </div>
</div>