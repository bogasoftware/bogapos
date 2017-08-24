<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Sales extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');

        $this->lang->load('sales', settings('language'));
        $this->lang->load('products', settings('language'));
        $this->load->model('sales_model', 'sales');

        $this->data['menu'] = array('menu' => 'sales', 'submenu' => 'sales');
    }

    public function index() {
        $this->template->_default();
        $this->template->table();
        $this->load->js('assets/js/modules/sales/sales.js');

        $this->output->set_title(lang('sale_title'));
        $this->load->view('sale/sales', $this->data);
    }

    public function add() {
        $this->template->_default();
        $this->template->table();
        $this->load->js('assets/js/modules/sales/sale_form.js');

        $this->output->set_title(lang('sale_add_title'));

        $this->data['data'] = array();
        $this->data['default_customer'] = $this->main->get('customers', array('id' => settings('default_customer')));

        $this->load->view('sale/sale_form', $this->data);
    }

    public function edit($id) {
        $id = decode($id);
        $data = $this->main->get('sales', array('id' => $id)) or exit('Page not found!');

        $this->template->_default();
        $this->template->table();
        $this->load->js('assets/js/modules/sales/sale_form.js');

        $this->output->set_title(lang('sale_update_title'));

        $this->data['data'] = $data;
        $products = $this->sales->get_sale_products($id);
        foreach ($products->result() as $product) {
            $product->id = encode($product->id);
            $pr[$product->id] = (array) $product;
        }
        $this->data['products'] = $pr;
        $this->data['shipping'] = $this->main->get('sale_shipping', array('sale' => $id));
        $this->data['default_customer'] = $this->main->get('customers', array('id' => settings('default_customer')));

        $this->load->view('sale/sale_form', $this->data);
    }

    public function modal_products($search = '') {
        $data = array('search' => $search);
        $this->load->view('sale/modal_product_list', $data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $page = $this->input->get('page');
        $filter = $this->input->get('fcol');
        $sort = $this->input->get('col');
        $size = $this->input->get('size');

        $output = array();
        $headers = array('', lang('sale_code_label'), lang('sale_date_label'), lang('sale_customer_label'), lang('sale_total_label'), lang('sale_cash_label'), lang('sale_credit_label'));
        $rows = array();

        $datas = $this->sales->get_all($page, $size, $filter, $sort);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $row = array(
                    '' => '<td class="uk-text-center">'
                    . ($data->pos == 0 ? '<a href="' . site_url('sales/edit/' . encode($data->id)) . '"><i class="md-icon material-icons">&#xE254;</i></a>' : '<a href="' . site_url('sales/pos/receipt/' . encode($data->id)) . '" target="_blank"><i class="md-icon material-icons">print</i></a>')
                    . '<a href="' . site_url('sales/sales/delete/' . encode($data->id)) . '" class="ts_remove_row" data-name="' . $data->code . '"><i class="md-icon material-icons">&#xE872;</i></a>'
                    . '</td>',
                );
                $row[remove_space(lang('sale_code_label'))] = $data->code;
                $row[remove_space(lang('sale_date_label'))] = get_date($data->date);
                $row[remove_space(lang('sale_customer_label'))] = $data->customer_name;
                $row[remove_space(lang('sale_total_label'))] = '<td class="uk-text-right">' . number($data->grand_total) . '</td>';
                $row[remove_space(lang('sale_cash_label'))] = '<td class="uk-text-right">' . number($data->cash) . '</td>';
                $row[remove_space(lang('sale_credit_label'))] = '<td class="uk-text-right">' . number($data->credit) . '</td>';
                array_push($rows, $row);
            }
        }
        $output['total_rows'] = $this->sales->count_all($filter);
        $output['headers'] = $headers;
        $output['rows'] = $rows;
        echo json_encode($output);
    }

    public function get_list_modal_products() {
        $page = $this->input->get('page');
        $filter = $this->input->get('fcol');
        $sort = $this->input->get('col');
        $size = $this->input->get('size');

        $output = array();
        $headers = array(lang('product_image_label'), lang('product_code_label'), lang('product_name_label'), lang('product_cost_label'), lang('product_price_label'), lang('product_stock_label'));
        $rows = array();

        $datas = $this->sales->get_all_products($page, $size, $filter, $sort);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $data->id = encode($data->id);
                $row[remove_space(lang('product_image_label'))] = '<td class="uk-text-center" onclick="selectProduct(\'' . htmlentities(json_encode($data)) . '\')"><a href="' . site_url($data->image) . '" data-uk-lightbox=""><img class="md-user-image" src="' . site_url($data->image) . '"></a></td>';
                $row[remove_space(lang('product_code_label'))] = '<td onclick="selectProduct(\'' . htmlentities(json_encode($data)) . '\')">' . $data->code . '</td>';
                $row[remove_space(lang('product_name_label'))] = '<td onclick="selectProduct(\'' . htmlentities(json_encode($data)) . '\')">' . $data->name . '</td>';
                $row[remove_space(lang('product_cost_label'))] = '<td class="uk-text-right" onclick="selectProduct(\'' . htmlentities(json_encode($data)) . '\')">' . number($data->cost) . '</td>';
                $row[remove_space(lang('product_price_label'))] = '<td class="uk-text-right" onclick="selectProduct(\'' . htmlentities(json_encode($data)) . '\')">' . number($data->price) . '</td>';
                $row[remove_space(lang('product_stock_label'))] = '<td class="uk-text-right" onclick="selectProduct(\'' . htmlentities(json_encode($data)) . '\')">' . number($data->quantity) . '</td>';
                array_push($rows, $row);
            }
        }
        $output['total_rows'] = $this->sales->count_all_products($filter);
        $output['headers'] = $headers;
        $output['rows'] = $rows;
        echo json_encode($output);
    }

    public function get_customers() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $customers = $this->sales->get_customers($this->input->post('search'));
        $output = array();
        if ($customers) {
            foreach ($customers->result() as $customer) {
                $row = array('value' => $customer->id, 'title' => $customer->name, 'city' => $customer->city);
                array_push($output, $row);
            }
        }
        echo json_encode($output);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $this->form_validation->set_rules('date', 'lang:sale_date_label', 'trim|required');
        $this->form_validation->set_rules('code', 'lang:sale_code_label', 'trim|required');
        $this->form_validation->set_rules('customer', 'lang:sale_customer_label', 'trim|required');

        if ($this->form_validation->run() === true) {
            $method = $this->input->post('save_method');
            $product_size = sizeof($this->input->post('product_id'));
            $id = $this->input->post('id');
            $sale = $this->main->get('sales', array('id' => $id));
            $products = array();
            $total = 0;
            //products
            for ($i = 0; $i < $product_size; $i++) {
                $product_id = decode($this->input->post('product_id')[$i]);
                if ($product_id != '' || $product_id != 0) {
                    $product_data = $this->main->get('products', array('id' => $product_id));
                    if ($product_data) {
                        $price = parse_number($this->input->post('product_price')[$i], settings('separator_decimal'));
                        $quantity = parse_number($this->input->post('product_quantity')[$i], settings('separator_decimal'));
                        $discount = ($this->input->post('product_discount')[$i]) ? parse_number($this->input->post('product_discount')[$i], settings('separator_decimal')) : 0;
                        $subtotal = $price * $quantity;
                        $discount_value = $subtotal * $discount / 100;
                        $subtotal = $subtotal - $discount_value;
                        $total += $subtotal;

                        $product = array(
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
                if (empty($products)) {
                    $return = array('message' => lang('sale_products_empty_message'), 'status' => 'danger');
                    break;
                }
                if (!$this->sales->check_code($this->input->post('code'), ($method == 'edit') ? $this->input->post('id') : 0)) {
                    $return = array('message' => lang('sale_code_exist_message'), 'status' => 'danger');
                    break;
                }
                $customer = $this->main->get('customers', array('id' => $this->input->post('customer')));
                $data = array(
                    'date' => get_date_mysql($this->input->post('date')),
                    'code' => $this->input->post('code'),
                    'customer' => $customer->id,
                    'customer_name' => $customer->name,
                    'note' => $this->input->post('note'),
                    'subtotal' => $total,
                    'status' => 'completed',
                    'credit' => 0,
                    'change' => 0,
                    'tax' => 0,
                    'discount' => 0,
                    'shipping' => 0,
                );
                if ($method == 'add') {
                    $data['created_by'] = $this->data['user']->id;
                } else {
                    $data['modified_by'] = $this->data['user']->id;
                }
                //sale discount
                if ($discount = parse_number($this->input->post('discount'), settings('separator_decimal'))) {
                    $total = $total - $discount;
                    $data['discount'] = $discount;
                }
                //tax
                if ($tax = parse_number($this->input->post('tax'), settings('separator_decimal'))) {
                    $tax_value = $total * $tax / 100;
                    $total = $total + $tax_value;
                    $data['tax'] = $tax;
                }
                //shipping
                if ($method == 'edit')
                    $this->main->delete('sale_shipping', array('sale' => $id));
                if ($this->input->post('shipping_check')) {
                    if ($shipping_cost = parse_number($this->input->post('shipping'), settings('separator_decimal'))) {
                        $total += $shipping_cost;
                        $data['shipping'] = $shipping_cost;
                    }
                    $data_shipping = array(
                        'code' => trx_code('sale_shipping'),
                        'date' => get_date_mysql($this->input->post('shipping_date')),
                        'recipient' => $this->input->post('shipping_recipient'),
                        'address' => $this->input->post('shipping_address'),
                    );
                }
                //total
                $data['grand_total'] = $total;

                //cash payment
                if ($method == 'edit') {
                    $this->main->delete('cash', array('sale' => $id));
                }
                $data['cash'] = parse_number($this->input->post('cash'), settings('separator_decimal'));
                if ($data['cash'] > 0) {
                    $data_cash = array(
                        'date' => $data['date'],
                        'code' => trx_code('cash_in'),
                        'type' => 'in',
                        'amount' => $data['cash'],
                        'created_by' => $this->data['user']->id,
                        'note' => $data['code']
                    );
                    if ($data['cash'] >= $data['grand_total']) {
                        $data['payment_status'] = 'paid';
                        $data['change'] = $data['cash'] - $data['grand_total'];
                    } elseif ($data['cash'] < $data['grand_total']) {
                        $data['credit'] = $data['grand_total'] - $data['cash'];
                        $data['payment_status'] = 'partial';
                    }
                } else {
                    $data['payment_status'] = 'pending';
                }

                //save
                if ($method == 'add')
                    $sale = $this->main->insert('sales', $data);
                else {
                    $sale = $this->main->update('sales', $data, array('id' => $id));
                    $sale = $id;
                }

                $data_shipping['sale'] = $sale;
                $data_cash['sale'] = $sale;
                if ($this->input->post('shipping_check')) {
                    $this->main->insert('sale_shipping', $data_shipping);
                }
                if ($data['cash'] > 0)
                    $this->main->insert('cash', $data_cash);

                if ($method == 'edit') {
                    $list_products = $this->main->gets('sale_product', array('sale' => $id));
                    if ($list_products) {
                        foreach ($list_products->result() as $p) {
                            $this->db->query("UPDATE products SET quantity = quantity + $p->quantity WHERE id = $p->product");
                        }
                    }
                    $this->main->delete('sale_product', array('sale' => $id));
                }
                foreach ($products as $product) {
                    $product['sale'] = $sale;
                    $this->main->insert('sale_product', $product);
                    $this->db->query("UPDATE products SET quantity = quantity - $product[quantity] WHERE id = $product[product]");
                }
                $return = array('message' => sprintf(lang('sale_save_success_message'), $data['code']), 'status' => 'success');
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'danger');
        }

        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $data = $this->main->get('sales', array('id' => $id));
        $delete = $this->main->delete('sales', array('id' => $id));
        if ($delete) {
            $list_products = $this->main->gets('sale_product', array('sale' => $id));
            if ($list_products) {
                foreach ($list_products->result() as $p) {
                    $this->db->query("UPDATE products SET quantity = quantity + $p->quantity WHERE id = $p->product");
                }
            }
            $this->main->delete('sale_product', array('sale' => $id));
            $this->main->delete('sale_shipping', array('sale' => $id));
            $this->main->delete('cash', array('sale' => $id));
            $return = array('message' => sprintf(lang('sale_delete_success_message'), $data->code), 'status' => 'success');
        } else {
            $return = array('message' => sprintf(lang('sale_delete_failed_message'), $data->code), 'status' => 'danger');
        }

        echo json_encode($return);
    }

}
