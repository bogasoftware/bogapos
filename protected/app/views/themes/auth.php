<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no"/>
        <title><?php echo "{$title}"; ?></title>
        <link rel="shortcut icon" href="<?php echo site_url('assets/img/favicon.png'); ?>" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="<?php echo site_url('assets/images/favicon.png'); ?>">
        <?php
        foreach ($css as $file) {
            echo "\n    ";
            echo '<link href="' . $file . '" rel="stylesheet" type="text/css" />';
        } echo "\n";
        ?>
        <script>
            var base_url = '<?php echo site_url(); ?>';
            var current_url = '<?php echo current_url(); ?>';
        </script>
    </head>
    <body class="login_page">

        <?php echo $output; ?>
        <?php
        foreach ($js as $file) {
            echo "\n    ";
            echo '<script src="' . $file . '"></script>';
        } echo "\n";
        ?>

        <script>
            // check for theme
            if (typeof (Storage) !== "undefined") {
                var root = document.getElementsByTagName('html')[0],
                        theme = localStorage.getItem("altair_theme");
                if (theme == 'app_theme_dark' || root.classList.contains('app_theme_dark')) {
                    root.className += ' app_theme_dark';
                }
            }
        </script>
    </body>
</html>