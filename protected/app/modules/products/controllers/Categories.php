<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Categories extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');

        $this->lang->load('categories', settings('language'));

        $this->load->model('categories_model', 'categories');

        $this->data['menu'] = array('menu' => 'product', 'submenu' => 'categories');
    }

    public function index() {
        $this->template->_default();
        $this->template->table();
        $this->template->form();
        $this->load->js('assets/js/modules/products/categories.js');

        $this->output->set_title(lang('categories_title'));
        $this->load->view('categories', $this->data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $page = $this->input->get('page');
        $filter = $this->input->get('fcol');
        $sort = $this->input->get('col');
        $size = $this->input->get('size');

        $output = array();
        $headers = array('', lang('categories_name_label'), lang('categories_status_label'));
        $rows = array();

        $datas = $this->categories->get_all($page, $size, $filter, $sort);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $row = array(
                    '' => '<td class="uk-text-center">'
                    . '<a href="#" class="btn-edit" data-id="' . encode($data->id) . '"><i class="md-icon material-icons">&#xE254;</i></a>'
                    . '<a href="' . site_url('products/categories/delete/' . encode($data->id)) . '" class="ts_remove_row" data-name="' . $data->name . '"><i class="md-icon material-icons">&#xE872;</i></a>'
                    . '</td>',
                );
                $row[remove_space(lang('categories_name_label'))] = $data->name;

                if ($data->status == 0) {
                    $data->status = lang('categories_active_label');
                } else {
                    $data->status = lang('categories_inactive_label');
                }
                $row[remove_space(lang('categories_status_label'))] = $data->status;
                array_push($rows, $row);
            }
        }
        $output['total_rows'] = $this->categories->count_all($filter);
        $output['headers'] = $headers;
        $output['rows'] = $rows;
        echo json_encode($output);
    }

    public function get($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $data = $this->main->get('product_categories', array('id' => $id));
        $data->id = encode($data->id);

        $output = json_encode($data);
        echo $output;
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->form_validation->set_rules('name', 'lang:categories_name_label', 'trim|required');


        //validate the form
        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            $method = $data['save_method'];
            $data['id'] = decode($data['id']);
            unset($data['save_method']);


                if ($method == 'add') {
                    if (empty($data['status'])) {
                        $data['status'] = 1;
                    } else {
                        $data['status'] = 0;
                    }
                    $save = $this->main->insert('product_categories', $data);
                } else if ($method == 'edit') {
                    if (empty($data['status'])) {
                        $data['status'] = 1;
                    } else {
                        $data['status'] = 0;
                    }
                    $save = $this->main->update('product_categories', $data, array('id' => $data['id']));
                }

                    if ($save !== false) {
                        $return = array('message' => sprintf(lang('categories_save_success_message'), $data['name']), 'status' => 'success');
                    } else {
                        $return = array('message' => lang('categories_save_failed_message'), 'status' => 'danger');
                    }

        } else {
            $return = array('message' => validation_errors(), 'status' => 'danger');
        }
        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $data = $this->main->get('product_categories', array('id' => $id));
        $delete = $this->main->delete('product_categories', array('id' => $id));
        if ($delete) {
            $return = array('message' => sprintf(lang('categories_delete_success_message'),$data->name), 'status' => 'success');
        } else {
            $return = array('message' => sprintf(lang('categories_delete_failed_message'),$data->name), 'status' => 'danger');
        }
        echo json_encode($return);
    }

}
