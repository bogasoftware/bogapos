<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Pos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');

        $this->lang->load('sales', settings('language'));
        $this->lang->load('products', settings('language'));
        $this->load->model('sales_model', 'sales');

        $this->data['menu'] = array('menu' => 'sales', 'submenu' => 'pos');
    }

    public function index() {
        $this->template->_default('pos');
        $this->template->table();
        $this->load->js('assets/js/modules/sales/pos.js');

        $this->data['data'] = array();

        $this->output->set_title(lang('sale_cashier_title'));
        $this->load->view('pos/pos', $this->data);
    }

    public function get_product() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $code = $this->input->post('code');
        $product = $this->main->get('products', array('code' => $code));
        if ($product) {
            $product->id = encode($product->id);
            $response = array('success' => true, 'data' => json_encode($product));
        } else {
            $response = array('success' => false);
        }
        echo json_encode($response);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $this->form_validation->set_rules('customer', 'lang:sale_customer_label', 'trim|required');

        if ($this->form_validation->run() === true) {
            $product_size = sizeof($this->input->post('product_id'));
            $products = array();
            $total = 0;
            //products
            for ($i = 0; $i < $product_size; $i++) {
                $product_id = decode($this->input->post('product_id')[$i]);
                if ($product_id != '' || $product_id != 0) {
                    $product_data = $this->main->get('products', array('id' => $product_id));
                    if ($product_data) {
                        $price = get_number($this->input->post('product_price')[$i]);
                        $quantity = get_number($this->input->post('product_quantity')[$i]);
                        $discount = ($this->input->post('product_discount')[$i]) ? get_number($this->input->post('product_discount')[$i]) : 0;
                        $subtotal = $price * $quantity;
                        $discount_value = $subtotal * $discount / 100;
                        $subtotal = $subtotal - $discount_value;

                        $total += $subtotal;

                        $product = array(
                            'store' => $this->session->userdata('store')->id,
                            'product' => $product_id,
                            'product_code' => $product_data->code,
                            'product_name' => $product_data->name,
                            'cost' => $product_data->cost,
                            'net_price' => $product_data->price,
                            'fix_price' => $price,
                            'quantity' => $quantity,
                            'discount' => $discount,
                            'subtotal' => $subtotal,
                        );
                        array_push($products, $product);
                    }
                }
            }
            do {
                if ($this->session->userdata('store')->id == 'all') {
                    $return = array('message' => lang('sale_not_choose_store_message'), 'status' => 'danger');
                    break;
                }
                if (empty($products)) {
                    $return = array('message' => lang('sale_products_empty_message'), 'status' => 'danger');
                    break;
                }
                $customer = $this->main->get('customers', array('id' => $this->input->post('customer')));
                $data = array(
                    'store' => $this->session->userdata('store')->id,
                    'date' => date('Y-m-d H:i:s'),
                    'code' => trx_code($this->session->userdata('store')->code, 'sales', 'CSR'),
                    'customer' => $customer->id,
                    'customer_name' => $customer->name,
                    'pos' => 1,
                    'subtotal' => $total,
                    'status' => 'completed',
                    'created_by' => $this->data['user']->id
                );
                //sale discount
                if ($discount = get_number($this->input->post('discount'))) {
                    $total = $total - $discount;
                    $data['discount'] = $discount;
                }
                //tax
                if ($tax = get_number($this->input->post('tax'))) {
                    $tax_value = $total * $tax / 100;
                    $total = $total + $tax_value;
                    $data['tax'] = $tax;
                }
                //total
                $data['grand_total'] = $total;
                $data['cash'] = get_number($this->input->post('cash-value'));

                //change
                if ($data['cash'] > $data['grand_total']) {
                    $data['change'] = $data['cash'] - $data['grand_total'];
                }

                //save
                $sale = $this->main->insert('sales', $data);
                foreach ($products as $product) {
                    $product['sale'] = $sale;
                    $this->main->insert('sale_product', $product);
                    $this->db->query("UPDATE product_store SET quantity = quantity - $product[quantity] WHERE product = $product[product] AND store = " . $this->session->userdata('store')->id);
                    $this->db->query("UPDATE products SET quantity = quantity - $product[quantity] WHERE id = $product[product]");
                }
                $return = array('message' => sprintf(lang('sale_save_success_message'), $data['code']), 'status' => 'success', 'id' => encode($sale));
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'danger');
        }
        echo json_encode($return);
    }

    public function receipt($id = '') {
        $id or exit('Not found');
        $id = decode($id);

        $this->data['data'] = $this->main->get('sales', array('id' => $id)) or exit('Not found');

        $this->template->_default('pos');
        $this->data['store'] = $this->main->get('stores', array('id' => $this->data['data']->store));
        $this->data['products'] = $this->main->gets('sale_product', array('sale' => $id));

        $this->output->set_title(lang('sale_cashier_receipt_title'));
        $this->load->view('pos/receipt', $this->data);
    }

}
