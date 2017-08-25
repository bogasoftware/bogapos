<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no"/>
        <title><?php echo "{$title} - BogaPOS"; ?></title>
        <link rel="shortcut icon" href="<?php echo site_url('assets/img/favicon.png'); ?>" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="<?php echo site_url('assets/images/favicon.png'); ?>">

        <?php
        foreach ($css as $file) {
            echo "\n    ";
            echo '<link href="' . $file . '" rel="stylesheet" type="text/css" />';
        } echo "\n";
        ?>
        <!-- matchMedia polyfill for testing media queries in JS -->
        <!--[if lte IE 9]>
            <script type="text/javascript" src="<?php echo site_url(); ?>assets/components/matchMedia/matchMedia.js"></script>
            <script type="text/javascript" src="<?php echo site_url(); ?>assets/components/matchMedia/matchMedia.addListener.js"></script>
            <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/ie.css" media="all">
        <![endif]-->
        <script type="text/javascript">
            var base_url = '<?php echo base_url(); ?>';
            var current_url = '<?php echo current_url(); ?>';
            var decimal_digit = '<?php echo settings('number_of_decimal'); ?>';
            var decimal_separator = '<?php echo settings('separator_decimal'); ?>';
            var thousand_separator = '<?php echo settings('separator_thousand'); ?>';
            var date_format = '<?php echo settings('date_format'); ?>';
            var date_format_uk = '<?php echo settings('date_format_uk'); ?>';
        </script>

    </head>
    <?php // $user = $this->ion_auth->user()->row(); ?>
    <body class=" sidebar_main_open sidebar_main_swipe header_full">
        <div class="modal"></div>
        <!-- main header -->
        <header id="header_main">
            <div class="header_main_content">
                <nav class="uk-navbar">
                    <div class="main_logo_top">
                        <a href="<?php echo site_url(); ?>"><img src="<?php echo site_url('assets/img/logo_main_white.png'); ?>" alt="" height="15" width="71"/></a>
                    </div>

                    <!-- main sidebar switch -->
                    <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                        <span class="sSwitchIcon"></span>
                    </a>

                    <!-- secondary sidebar switch -->
                    <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check">
                        <span class="sSwitchIcon"></span>
                    </a>                
                    <div class="uk-navbar-flip">
                        <ul class="uk-navbar-nav user_actions">
                            <li><a href="#" id="full_screen_toggle" class="user_action_icon uk-visible-large"><i class="material-icons md-24 md-light">&#xE5D0;</i></a></li>
                            <li>
                                <a href="#" class="user_action_icon"><?php echo settings('store_name'); ?></a>
                            </li>
                            <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                <a href="#" class="user_action_image"><?php echo $user->fullname; ?> <i class="material-icons md-24 md-light">keyboard_arrow_down</i></a>
                                <div class="uk-dropdown uk-dropdown-small">
                                    <ul class="uk-nav js-uk-prevent">
                                        <li><a href="<?php echo site_url('auth/profile'); ?>"><?php echo lang('account_setting_label'); ?></a></li>
                                        <li><a href="<?php echo site_url('auth/logout'); ?>"><?php echo lang('account_logout_label'); ?></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <aside id="sidebar_main">
            <div class="menu_section">
                <ul>
                    <li class="<?php echo ($menu['menu'] == 'home') ? 'current_section' : ''; ?>">
                        <a href="<?php echo site_url(); ?>">
                            <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>
                            <span class="menu_title"><?php echo lang('menu_dashboard_label'); ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($menu['menu'] == 'product') ? 'current_section' : ''; ?>">
                        <a href="<?php echo site_url('products'); ?>">
                            <span class="menu_icon"><i class="material-icons">watch</i></span>
                            <span class="menu_title"><?php echo lang('menu_products_label'); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="menu_icon"><i class="material-icons">shopping_cart</i></span>
                            <span class="menu_title"><?php echo lang('menu_sales_label'); ?></span>
                        </a>
                        <ul>
                            <li class="<?php echo ($menu['menu'] == 'sales' && $menu['submenu'] == 'sales') ? 'act_item' : ''; ?>">
                                <a href="<?php echo site_url('sales'); ?>"><?php echo lang('menu_sales_label'); ?></a>
                            </li>
<!--                            <li class="<?php echo ($menu['menu'] == 'sales' && $menu['submenu'] == 'pos') ? 'act_item' : ''; ?>">
                                <a href="<?php echo site_url('sales/pos'); ?>"><?php echo lang('menu_sale_pos_label'); ?></a>
                            </li>-->
                            <li class="<?php echo ($menu['menu'] == 'sales' && $menu['submenu'] == 'customer') ? 'act_item' : ''; ?>">
                                <a href="<?php echo site_url('sales/customers'); ?>"><?php echo lang('menu_customers_label'); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <span class="menu_icon"><i class="material-icons">add_shopping_cart</i></span>
                            <span class="menu_title"><?php echo lang('menu_purchases_label'); ?></span>
                        </a>
                        <ul>
                            <li class="<?php echo ($menu['menu'] == 'purchase' && $menu['submenu'] == 'purchase') ? 'act_item' : ''; ?>">
                                <a href="<?php echo site_url('purchases'); ?>"><?php echo lang('menu_purchases_label'); ?></a>
                            </li>
                            <li class="<?php echo ($menu['menu'] == 'purchase' && $menu['submenu'] == 'supplier') ? 'act_item' : ''; ?>">
                                <a href="<?php echo site_url('purchases/suppliers'); ?>"><?php echo lang('menu_suppliers_label'); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo ($menu['menu'] == 'report') ? 'current_section' : ''; ?>">
                        <a href="<?php echo site_url('reports'); ?>">
                            <span class="menu_icon"><i class="material-icons">assessment</i></span>
                            <span class="menu_title"><?php echo lang('menu_reports_label'); ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($menu['menu'] == 'setting') ? 'current_section' : ''; ?>">
                        <a href="#">
                            <span class="menu_icon"><i class="material-icons">settings</i></span>
                            <span class="menu_title"><?php echo lang('menu_settings_label'); ?></span>
                        </a>
                        <ul>
                            <li class="<?php echo ($menu['menu'] == 'setting' && $menu['submenu'] == 'setting') ? 'act_item' : ''; ?>">
                                <a href="<?php echo site_url('settings'); ?>"><?php echo lang('menu_settings_label'); ?></a>
                            </li>
                            <li class="<?php echo ($menu['menu'] == 'setting' && $menu['submenu'] == 'code') ? 'act_item' : ''; ?>">
                                <a href="<?php echo site_url('settings/code'); ?>"><?php echo lang('menu_settings_code_label'); ?></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="uk-grid uk-margin">
                <div class="uk-width-1-1 uk-text-center">
                    BogaPOS <?php echo VERSION; ?><br>
					Dev by <a href="https://bogasoftware.com">Bogasoftware</a>
                </div>
            </div>
        </aside>
        <div id="page_content">
            <?php echo $output; ?>
        </div>

        <!-- google web fonts -->
        <script>
            WebFontConfig = {
                google: {
                    families: [
                        'Source+Code+Pro:400,700:latin',
                        'Roboto:400,300,500,700,400italic:latin'
                    ]
                }
            };
            (function () {
                var wf = document.createElement('script');
                wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                        '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                wf.type = 'text/javascript';
                wf.async = 'true';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(wf, s);
            })();
        </script>

        <?php
        foreach ($js as $file) {
            echo "\n    ";
            echo '<script src="' . $file . '"></script>';
        } echo "\n";
        ?>

        <script>
            $(function () {
                if (isHighDensity) {
                    // enable hires images
                    altair_helpers.retina_images();
                }
                if (Modernizr.touch) {
                    // fastClick (touch devices)
                    FastClick.attach(document.body);
                }
            });
            $window.load(function () {
                // ie fixes
                altair_helpers.ie_fix();
            });
        </script>
    </body>
</html>