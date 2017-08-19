<div class="login_page_wrapper">
    <div class="md-card" id="login_card">
        <div class="md-card-content large-padding">
            <h2 class="heading_a uk-margin-medium-bottom uk-text-center">Registrasi BogaToko</h2>
            <div id="message"></div>
            <form id="register" method="post">
                <div class="uk-form-row parsley-row">
                    <label for="name">Nama Toko</label>
                    <input class="md-input" type="text" required id="name" name="name" />
                </div>
                <div class="uk-form-row parsley-row">
                    <label for="email">Alamat Email</label>
                    <input class="md-input" type="email" required id="email" name="email" />
                </div>
                <div class="uk-form-row parsley-row">
                    <label for="password">Kata Sandi</label>
                    <input class="md-input" type="password" required id="password" name="password" />
                </div>
                <div class="uk-form-row parsley-row">
                    <label for="password_confirmation">Ulangi Kata Sandi</label>
                    <input class="md-input" type="password" required id="password_confirmation" name="password_confirmation" />
                </div>
                <div class="uk-margin-medium-top">
                    <button class="md-btn md-btn-primary md-btn-block md-btn-large" type="submit">Daftar Akun</button>
                </div>
            </form>
        </div>
    </div>
    <div class="uk-margin-top uk-text-center">
        Sudah punya akun? <a href="<?php echo site_url('auth/login'); ?>">Login Disini</a>
    </div>
</div>