<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');

        $this->lang->load('settings', settings('language'));
        $this->data['menu'] = array('menu' => 'setting', 'submenu' => 'setting');
    }

    public function index() {
        $this->template->_default();
        $this->template->form();

        $this->output->set_title(lang('setting_title'));

        $this->data['customers'] = $this->main->gets('customers');
        $this->data['suppliers'] = $this->main->gets('suppliers');
        $settings = $this->main->gets('settings');
        foreach ($settings->result() as $setting) {
            $this->data['settings'][$setting->key] = $setting->value;
        }
        $this->data['settings'] = (object) $this->data['settings'];
        $this->data['timezones'] = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        $this->load->view('settings', $this->data);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $this->form_validation->set_rules('store_name', 'lang:setting_name_label', 'trim|required');
        $this->form_validation->set_rules('store_address', 'lang:setting_address_label', 'trim|required');
        $this->form_validation->set_rules('store_phone', 'lang:setting_phone_label', 'trim|required');
        $this->form_validation->set_rules('default_customer', 'lang:setting_default_customer_label', 'trim|required');
        $this->form_validation->set_rules('default_supplier', 'lang:setting_default_supplier_label', 'trim|required');
        $this->form_validation->set_rules('language', 'lang:setting_language_label', 'trim|required');
        $this->form_validation->set_rules('timezone', 'lang:setting_timezone_label', 'trim|required');
        $this->form_validation->set_rules('enable_tax', 'lang:setting_enable_tax_label', 'trim');
        $this->form_validation->set_rules('duedate_payment', 'lang:setting_duedate_label', 'trim|required');
        $this->form_validation->set_rules('number_of_decimal', 'lang:setting_number_decimal_label', 'trim');

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            foreach ($data as $key => $value) {
                $settings[] = array(
                    'key' => $key,
                    'value' => $value
                );
            }
            $save = $this->db->update_batch('settings', $settings, 'key');

            if ($save !== false) {
                $return = array('message' => lang('setting_save_success_message'), 'status' => 'success');
            } else {
                $return = array('message' => lang('setting_save_failed_message'), 'status' => 'danger');
            }
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $this->cache->delete('settings');
        } else {
            $return = array('message' => validation_errors(), 'status' => 'danger');
        }
        echo json_encode($return);
    }

    public function code() {
        $this->template->_default();
        $this->template->form();
        $this->load->js('assets/js/modules/settings/code.js');

        $this->data['menu'] = array('menu' => 'setting', 'submenu' => 'code');
        $this->output->set_title(lang('setting_code_title'));

        $this->data['modules'] = array('sales', 'purchases', 'pos', 'cash_in', 'cash_out');

        $this->load->view('settings_code', $this->data);
    }

    public function save_code() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $modules = array('sales', 'purchases', 'pos', 'cash_in', 'cash_out');
        foreach ($modules as $module) {
            $this->form_validation->set_rules('code_format_' . $module, 'lang:setting_code_format_' . $module . '_label', 'trim|required');
        }

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            foreach ($data as $key => $value) {
                $settings[] = array(
                    'key' => $key,
                    'value' => $value
                );
            }
            $save = $this->db->update_batch('settings', $settings, 'key');

            if ($save !== false) {
                $return = array('message' => lang('setting_save_success_message'), 'status' => 'success');
            } else {
                $return = array('message' => lang('setting_save_failed_message'), 'status' => 'danger');
            }
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $this->cache->delete('settings');
        } else {
            $return = array('message' => validation_errors(), 'status' => 'danger');
        }
        echo json_encode($return);
    }

}
