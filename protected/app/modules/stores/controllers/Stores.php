<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Stores extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');

        $this->lang->load('stores', settings('language'));

        $this->load->model('stores_model', 'stores');

        $this->data['menu'] = array('menu' => 'store', 'submenu' => '');
    }

    public function index() {
        $this->template->_default();
        $this->template->table();
        $this->template->form();
        $this->load->js('assets/js/modules/stores.min.js');

        $this->output->set_title('Daftar Toko - Bogatoko');
        $this->load->view('stores', $this->data);
    }

    public function get_list() {
        $page = $this->input->get('page');
        $filter = $this->input->get('fcol');
        $sort = $this->input->get('col');
        $size = $this->input->get('size');

        $output = array();
        $headers = array('', lang('store_code_label'), lang('store_name_label'), lang('store_phone_label'), lang('store_city_label'));
        $rows = array();

        $datas = $this->stores->get_all($page, $size, $filter, $sort);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $row = array(
                    '' => '<td class="uk-text-center">'
                    . '<a href="#" class="btn-edit" data-id="' . encode($data->id) . '"><i class="md-icon material-icons">&#xE254;</i></a>'
                    . '<a href="' . site_url('stores/delete/' . encode($data->id)) . '" class="ts_remove_row" data-name="' . $data->name . '"><i class="md-icon material-icons">&#xE872;</i></a>'
                    . '</td>',
                );
                $row[remove_space(lang('store_code_label'))] = $data->code;
                $row[remove_space(lang('store_name_label'))] = $data->name;
                $row[remove_space(lang('store_phone_label'))] = $data->telephone;
                $row[remove_space(lang('store_city_label'))] = $data->city;
                array_push($rows, $row);
            }
        }
        $output['total_rows'] = $this->stores->count_all($filter);
        $output['headers'] = $headers;
        $output['rows'] = $rows;
        echo json_encode($output);
    }

    public function get($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $data = $this->main->get('stores', array('id' => $id));

        $output = json_encode($data);
        echo $output;
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $this->form_validation->set_rules('code', 'lang:store_code_label', 'trim|required|max_length[3]');
        $this->form_validation->set_rules('name', 'lang:store_name_label', 'trim|required');
        $this->form_validation->set_rules('address', 'lang:store_address_label', 'trim|required');
        $this->form_validation->set_rules('telephone', 'lang:store_phone_label', 'trim|required');
        $this->form_validation->set_rules('city', 'lang:store_city_label', 'trim|required');
        $this->form_validation->set_rules('postcode', 'lang:store_postcode_label', 'trim|required');

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            $method = $data['save_method'];
            unset($data['save_method']);

            if ($method == 'add') {
                $save = $this->main->insert('stores', $data);
                $this->db->query("INSERT INTO product_store (product, store) SELECT id, $save FROM products");
            } else if ($method == 'edit') {
                $save = $this->main->update('stores', array('id' => $data['id']), $data);
            }

            if ($save !== false) {
                $return = array('message' => sprintf(lang('store_save_success_message'), $data['name']), 'status' => 'success');
            } else {
                $return = array('message' => sprintf(lang('store_save_failed_message'), $data['name']), 'status' => 'danger');
            }
        } else {
            $return = array('message' => validation_errors(), 'status' => 'danger');
        }
        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        do {
            $data = $this->main->get('stores', array('id' => $id));
            if (!$data)
                exit('Data not found');
            $delete = $this->main->delete('stores', array('id' => $id));
            $this->main->delete('product_store', array('store' => $id));
            if ($delete) {
                $return = array('message' => sprintf(lang('store_delete_success_message'), $data->name), 'status' => 'success');
            } else {
                $return = array('message' => sprintf(lang('store_delete_failed_message'), $data->name), 'status' => 'danger');
            }
        } while (0);
        echo json_encode($return);
    }

}
