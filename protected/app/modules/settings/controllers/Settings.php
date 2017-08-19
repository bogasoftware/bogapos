<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');
        if (!$this->ion_auth->in_group(2))
            redirect('404');

        $this->data['menu'] = array('menu' => 'setting', 'submenu' => '');
    }

    public function index() {
        $this->template->_default();
        $this->template->form();

        $this->output->set_title('Pengaturan - Bogatoko');

        $this->data['customers'] = $this->main->gets('customers', array('merchant' => $this->data['user']->merchant));
        $this->data['suppliers'] = $this->main->gets('suppliers', array('merchant' => $this->data['user']->merchant));

        $this->load->view('settings', $this->data);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $this->form_validation->set_rules('name', 'Nama Perusahaan', 'trim|required');
        $this->form_validation->set_rules('description', 'Deskripsi Perusahaan', 'trim|required');
        $this->form_validation->set_rules('address', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('telephone', 'Telepon', 'trim|required');
        $this->form_validation->set_rules('default_customer', 'Konsumen Default', 'trim|required');
        $this->form_validation->set_rules('default_supplier', 'Pemasok Default', 'trim|required');
        $this->form_validation->set_rules('enable_tax', 'Pajak', 'trim');

        //validate the form
        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);
            $save = $this->main->update('merchants', $data, array('id' => $this->data['user']->merchant));
//
            if ($save !== false) {
                $this->data['merchant'] = $this->main->get('merchants', array('id' => $this->data['user']->merchant));
                $return = array('message' => "Konfigurasi berhasil disimpan.", 'status' => 'success');
            } else {
                $return = array('message' => 'Gagal menyimpan data.', 'status' => 'danger');
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
