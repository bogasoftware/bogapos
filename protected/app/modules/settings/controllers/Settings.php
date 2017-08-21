<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');

        $this->lang->load('settings', settings('language'));
        $this->data['menu'] = array('menu' => 'setting', 'submenu' => '');
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
                $this->config->set_item('language', $data['language']);
                $return = array('message' => lang('setting_save_success_message'), 'status' => 'success');
            } else {
                $return = array('message' => lang('setting_save_failed_message'), 'status' => 'danger');
            }
        } else {
            $return = array('message' => validation_errors(), 'status' => 'danger');
        }
        echo json_encode($return);
    }

    public function change_store() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = $this->input->post('id');
        if ($id != 'all') {
            $id = decode($id);
            $this->session->set_userdata('store', $this->main->get('merchant_store', array('merchant' => $this->data['user']->merchant, 'id' => $id)));
        } else {
            $data = (object) array('id' => 'all', 'name' => 'Semua Toko');
            $this->session->set_userdata('store', $data);
        }
    }

}
