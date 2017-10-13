<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');

        $this->lang->load('products', settings('language'));

        $this->load->model('products_model', 'products');

        $this->data['menu'] = array('menu' => 'product', 'submenu' => 'product');
    }

    public function index() {
        $this->load->css('assets/skins/dropify/css/dropify.css');
        $this->template->_default();
        $this->template->table();
        $this->load->js('assets/skins/dropify/dropify.min.js');
        $this->template->form();
        $this->load->js('assets/js/modules/products/products.js');


        $this->data['categories'] = $this->products->get_categories();

        $this->output->set_title(lang('product_title'));
        $this->load->view('products', $this->data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $page = $this->input->get('page');
        $filter = $this->input->get('fcol');
        $sort = $this->input->get('col');
        $size = $this->input->get('size');

        $output = array();
        $headers = array('', lang('product_image_label'), lang('product_code_label'), lang('product_name_label'), lang('product_cost_label'), lang('product_price_label'), lang('product_stock_label'));
        $rows = array();

        $datas = $this->products->get_all($page, $size, $filter, $sort);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $row = array(
                    '' => '<td class="uk-text-center">'
                    . '<a href="#" class="btn-edit" data-id="' . encode($data->id) . '"><i class="md-icon material-icons">&#xE254;</i></a>'
                    . '<a href="' . site_url('products/delete/' . encode($data->id)) . '" class="ts_remove_row" data-name="' . $data->name . '"><i class="md-icon material-icons">&#xE872;</i></a>'
                    . '</td>',
                );
                $row[remove_space(lang('product_image_label'))] = '<td class="uk-text-center"><a href="' . $data->image . '" data-uk-lightbox=""><img class="md-user-image" src="' . $data->image . '"></a></td>';
                $row[remove_space(lang('product_code_label'))] = $data->code;
                $row[remove_space(lang('product_name_label'))] = $data->name;
                $row[remove_space(lang('product_cost_label'))] = '<td class="uk-text-right">' . number($data->cost) . '</td>';
                $row[remove_space(lang('product_price_label'))] = '<td class="uk-text-right">' . number($data->price) . '</td>';
                $row[remove_space(lang('product_stock_label'))] = '<td class="uk-text-right">' . number($data->quantity) . '</td>';
                array_push($rows, $row);
            }
        }
        $output['total_rows'] = $this->products->count_all($filter);
        $output['headers'] = $headers;
        $output['rows'] = $rows;
        echo json_encode($output);
    }

    public function get($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $data = $this->main->get('products', array('id' => $id));
        $data->id = encode($data->id);

        $output = json_encode($data);
        echo $output;
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->form_validation->set_rules('code', 'lang:product_code_label', 'trim|required');
        $this->form_validation->set_rules('name', 'lang:product_name_label', 'trim|required');
        $this->form_validation->set_rules('description', 'lang:product_description_label', 'trim');
        $this->form_validation->set_rules('cost', 'lang:product_cost_label', 'trim|required|numeric');
        $this->form_validation->set_rules('price', 'lang:product_price_label', 'trim|required|numeric');
        $this->form_validation->set_rules('image', 'lang:product_image_label', 'trim');
        $this->form_validation->set_rules('category', 'lang:product_category_label', 'trim|required');
        $this->form_validation->set_rules('quantity', 'lang:product_stock_label', 'trim|numeric');

        //validate the form
        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            $method = $data['save_method'];
            unset($data['save_method']);

            if ($method == 'edit'){
                $data['id'] = decode($data['id']);
                unset($data['quantity']);
            }
            do {
                if (isset($_FILES['image']['name']) != null) {
                    $config['upload_path'] = './files/images/products/';
                    $config['allowed_types'] = "gif|jpg|png|jpeg|bmp";
                    $config['max_size'] = 2048;
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path']);
                    }

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('image')) {
                        $return = array('message' => lang('product_upload_image_failed_message') . "<br>" . $this->upload->display_errors(), 'status' => 'danger');
                        break;
                    } else {
                        $data['image'] = $config['upload_path'] . $this->upload->data('file_name');
                        if ($method == 'edit') {
                            $data_exist = $this->main->get('products', array('id' => $data['id']));
                            if (file_exists($data_exist->image)) {
                                unlink($data_exist->image);
                            }
                        }
                    }

                } else {
                    unset($data['image']);
                }

                if ($method == 'add') {
                    $save = $this->main->insert('products', $data);
                } else if ($method == 'edit') {
                    $save = $this->main->update('products', $data, array('id' => $data['id']));
                }

                $return = array('message' => sprintf(lang('product_save_success_message'), $data['name']), 'status' => 'success');
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'danger');
        }
        echo json_encode($return);
    }





    public function import(){
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        
        $this->form_validation->set_rules('import_data', 'Import Data', 'trim');
        
        
        if ($this->form_validation->run() == true) {
            do {
                if ($_FILES['import_data']['name'] != null) {

                    $config['upload_path']   = './files/product/import/';
                    $config['allowed_types'] = 'xls|xlsx';
                    $config['max_size']      = '10000';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    
                    
                    $inputFileName = $config['upload_path'] . $_FILES['import_data']['name'];
                    if (file_exists($inputFileName)) {
                        unlink($inputFileName);
                    }

                    if (!$this->upload->do_upload('import_data')) {
                        $return = array(
                            'message' => $this->upload->display_errors(),
                            'status' => 'danger'
                        );
                        break;
                    } else {
                        $media         = $this->upload->data();
                        $inputFileName = $config['upload_path'] . $media['file_name'];
                        
                        $this->load->library('PHPExcel');
                        $this->load->library('PHPExcel/IOFactory');
                        try {
                            $inputFileType = IOFactory::identify($inputFileName);
                            $objReader     = IOFactory::createReader($inputFileType);
                            $objPHPExcel   = $objReader->load($inputFileName);
                        }
                        catch (Exception $e) {
                            $return = array(
                                'message' => 'Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage(),
                                'status' => 'danger'
                            );
                            break;
                        }
                        $sheet         = $objPHPExcel->getSheet(0);
                        $highestRow    = $sheet->getHighestRow();
                        $highestColumn = $sheet->getHighestColumn();
                        do {
                            if ($highestRow > 0) {
                                for ($row = 2; $row <= $highestRow; $row++) {
                                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                                    if ($rowData[0][0] != '' && $rowData[0][6] != '') {
                                        $data['code']    = $rowData[0][0];
                                        $data['name']    = $rowData[0][1];
                                        $data['description']    = $rowData[0][2];
                                        $data['quantity']    = $rowData[0][3];
                                        $data['image']    = $rowData[0][4];
                                        $data['price']    = $rowData[0][5];
                                        $data['cost']    = $rowData[0][6];
                                        
                                        $this->main->insert('products', $data);
                                        
                                    }
                                }
                                $return = array(
                                    'message' => 'Data Fields berhasil di Import.',
                                    'status' => 'success'
                                );
                            }
                        } while (0);
                    }
                } else {
                    $return = array(
                        'message' => 'Tidak ada file yang diupload.',
                        'status' => 'danger'
                    );
                }
            } while (0);
        } else {
            $return = array(
                'message' => validation_errors(),
                'status' => 'danger'
            );
        }
        echo json_encode($return);
        
    }





    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $data = $this->main->get('products', array('id' => $id));
        $delete = $this->main->delete('products', array('id' => $id));
        if ($delete) {
            if (file_exists($data->image))
                unlink($data->image);
            $return = array('message' => sprintf(lang('product_delete_success_message'),$data->name), 'status' => 'success');
        } else {
            $return = array('message' => sprintf(lang('product_delete_failed_message'),$data->name), 'status' => 'danger');
        }
        echo json_encode($return);
    }

}
