<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

class Template {

    public function __construct() {
        $this->ci = & get_instance();
    }

    public function _default($default = 'default') {
        $this->ci->output->set_template($default);

        $this->ci->load->css('assets/components/uikit/css/uikit.almost-flat.min.css');
        $this->ci->load->css('assets/css/main.min.css');
        $this->ci->load->css('assets/css/themes/themes_combined.min.css');
        $this->ci->load->css('assets/css/custom.min.css');

        $this->ci->load->js('assets/js/language/' . settings('language') . '.js');
        $this->ci->load->js('assets/js/common.min.js');
        $this->ci->load->js('assets/js/uikit_custom.min.js');
        $this->ci->load->js('assets/js/altair_admin_common.min.js');
        $this->ci->load->js('assets/js/jquery.form.js');
        $this->ci->load->js('assets/js/jquery.number.min.js');
        $this->ci->load->js('assets/js/app.js');
    }

    public function table() {
        $this->ci->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->ci->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.widgets.min.js');
        $this->ci->load->js('assets/components/tablesorter/dist/js/widgets/widget-alignChar.min.js');
        $this->ci->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->ci->load->js('assets/js/table.js');
    }

    public function form() {
        $this->ci->load->js('assets/js/form.js');
        $this->ci->load->js('assets/components/parsleyjs/dist/parsley.min.js');
    }

    public function _auth($default = 'auth') {
        $this->ci->output->set_template($default);
        $this->ci->load->css('http://fonts.googleapis.com/css?family=Roboto:300,400,500');
        $this->ci->load->css('assets/components/uikit/css/uikit.almost-flat.min.css');
        $this->ci->load->css('assets/css/login_page.min.css');

        $this->ci->load->js('assets/js/common.min.js');
        $this->ci->load->js('assets/js/uikit_custom.min.js');
        $this->ci->load->js('assets/js/altair_admin_common.min.js');
        $this->ci->load->js('assets/js/jquery.form.js');
    }

}
