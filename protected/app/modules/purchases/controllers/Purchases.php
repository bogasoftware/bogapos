<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Purchases extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');
        $this->lang->load('purchases', settings('language'));
        $this->lang->load('products', settings('language'));
        $this->load->model('purchases_model', 'purchases');

        $this->data['menu'] = array('menu' => 'purchase', 'submenu' => 'purchase');
    }

    public function index() {
        $this->template->_default();
        $this->template->table();
        $this->load->js('assets/js/modules/purchases/purchases.js');

        $this->output->set_title(lang('purchase_title'));
        $this->load->view('purchase/purchases', $this->data);
    }

    public function add() {
        $this->template->_default();
        $this->template->table();
        $this->load->js('assets/js/modules/purchases/purchase_form.js');

        $this->output->set_title(lang('purchase_add_title'));

        $this->data['data'] = array();
        $this->data['default_supplier'] = $this->main->get('suppliers', array('id' => settings('default_supplier')));

        $this->load->view('purchase/purchase_form', $this->data);
    }

    public function edit($id) {
        $id = decode($id);
        $data = $this->main->get('purchases', array('id' => $id)) or exit('Page not found!');

        $this->template->_default();
        $this->template->table();
        $this->load->js('assets/js/modules/purchases/purchase_form.js');

        $this->output->set_title(lang('purchase_update_title'));

        $this->data['data'] = $data;
        $products = $this->purchases->get_purchase_products($id);
        foreach ($products->result() as $product) {
            $product->id = encode($product->id);
            $pr[$product->id] = (array) $product;
        }
        $this->data['products'] = $pr;
        $this->data['default_supplier'] = $this->main->get('suppliers', array('id' => settings('default_supplier')));

        $this->load->view('purchase/purchase_form', $this->data);
    }

    public function modal_products($search = '') {
        $data = array('search' => $search);
        $this->load->view('purchase/modal_product_list', $data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $page = $this->input->get('page');
        $filter = $this->input->get('fcol');
        $sort = $this->input->get('col');
        $size = $this->input->get('size');

        $output = array();
        $headers = array('', lang('purchase_code_label'), lang('purchase_date_label'), lang('purchase_supplier_label'), lang('purchase_total_label'), lang('purchase_cash_label'), lang('purchase_credit_label'));
        $rows = array();

        $datas = $this->purchases->get_all($page, $size, $filter, $sort);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $row = array(
                    '' => '<td class="uk-text-center">'
                    . '<a href="' . site_url('purchases/edit/' . encode($data->id)) . '"><i class="md-icon material-icons">&#xE254;</i></a>'
                    . '<a href="' . site_url('purchases/delete/' . encode($data->id)) . '" class="ts_remove_row" data-name="' . $data->code . '"><i class="md-icon material-icons">&#xE872;</i></a>'
                    . '</td>',
                );
                $row[remove_space(lang('purchase_code_label'))] = $data->code;
                $row[remove_space(lang('purchase_date_label'))] = get_date($data->date);
                $row[remove_space(lang('purchase_supplier_label'))] = $data->supplier_name;
                $row[remove_space(lang('purchase_total_label'))] = '<td class="uk-text-right">' . number($data->grand_total) . '</td>';
                $row[remove_space(lang('purchase_cash_label'))] = '<td class="uk-text-right">' . number($data->cash) . '</td>';
                $row[remove_space(lang('purchase_credit_label'))] = '<td class="uk-text-right">' . number($data->credit) . '</td>';
                array_push($rows, $row);
            }
        }
        $output['total_rows'] = $this->purchases->count_all($filter);
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

        $datas = $this->purchases->get_all_products($page, $size, $filter, $sort);
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
        $output['total_rows'] = $this->purchases->count_all_products($filter);
        $output['headers'] = $headers;
        $output['rows'] = $rows;
        echo json_encode($output);
    }

    public function get_suppliers() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $suppliers = $this->purchases->get_suppliers($this->input->post('search'));
        $output = array();
        if ($suppliers) {
            foreach ($suppliers->result() as $supplier) {
                $row = array('value' => $supplier->id, 'title' => $supplier->name, 'city' => $supplier->city);
                array_push($output, $row);
            }
        }
        echo json_encode($output);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $this->form_validation->set_rules('date', 'lang:purchase_date_label', 'trim|required');
        $this->form_validation->set_rules('code', 'lang:purchase_code_label', 'trim|required');
        $this->form_validation->set_rules('supplier', 'lang:purchase_supplier_label', 'trim|required');

        if ($this->form_validation->run() === true) {
            $method = $this->input->post('save_method');
            $product_size = sizeof($this->input->post('product_id'));
            $id = $this->input->post('id');
            $purchase = $this->main->get('purchases', array('id' => $id));
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
                            'cost' => $price,
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
                    $return = array('message' => lang('purchase_products_empty_message'), 'status' => 'danger');
                    break;
                }
                if (!$this->purchases->check_code($this->input->post('code'), ($method == 'edit') ? $this->input->post('id') : 0)) {
                    $return = array('message' => lang('purchase_code_exist_message'), 'status' => 'danger');
                    break;
                }
                $supplier = $this->main->get('suppliers', array('id' => $this->input->post('supplier')));
                $data = array(
                    'date' => get_date_mysql($this->input->post('date')),
                    'code' => $this->input->post('code'),
                    'supplier' => $supplier->id,
                    'supplier_name' => $supplier->name,
                    'note' => $this->input->post('note'),
                    'subtotal' => $total,
                    'status' => 'completed',
                    'discount' => 0,
                    'tax' => 0,
                    'shipping' => 0,
                );
                if ($method == 'add') {
                    $data['created_by'] = $this->data['user']->id;
                } else {
                    $data['modified_by'] = $this->data['user']->id;
                }
                //purchase discount
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
                if ($this->input->post('shipping_check')) {
                    if ($shipping_cost = parse_number($this->input->post('shipping'), settings('separator_decimal'))) {
                        $total += $shipping_cost;
                        $data['shipping'] = $shipping_cost;
                    }
                }
                //total
                $data['grand_total'] = $total;
                //cash payment
                if ($method == 'edit') {
                    $this->main->delete('cash', array('purchase' => $id));
                }
                $data['cash'] = parse_number($this->input->post('cash'), settings('separator_decimal'));
                if ($data['cash'] > 0) {
                    $data_cash = array(
                        'date' => $data['date'],
                        'code' => trx_code('cash_out'),
                        'type' => 'out',
                        'amount' => $data['cash'],
                        'note' => $data['code'],
                        'created_by' => $this->data['user']->id
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
                    $data['credit'] = $data['grand_total'];
                }

                //save
                if ($method == 'add')
                    $purchase = $this->main->insert('purchases', $data);
                else {
                    $purchase = $this->main->update('purchases', $data, array('id' => $id));
                    $purchase = $id;
                }
                
                $data_cash['purchase'] = $purchase;
                if ($data['cash'] > 0)
                    $this->main->insert('cash', $data_cash);

                if ($method == 'edit') {
                    $list_products = $this->main->gets('purchase_product', array('purchase' => $id));
                    if ($list_products) {
                        foreach ($list_products->result() as $p) {
                            $this->db->query("UPDATE products SET quantity = quantity - $p->quantity WHERE id = $p->product");
                        }
                    }
                    $this->main->delete('purchase_product', array('purchase' => $id));
                }
                foreach ($products as $product) {
                    $product['purchase'] = $purchase;
                    $this->main->insert('purchase_product', $product);
                    $this->db->query("UPDATE products SET quantity = quantity + $product[quantity] WHERE id = $product[product]");
                    $this->db->update('products', array('cost' => $product['cost']), array('id' => $product['product']));
                }
                $return = array('message' => sprintf(lang('purchase_save_success_message'), $data['code']), 'status' => 'success');
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'danger');
        }
        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $data = $this->main->get('purchases', array('id' => $id));
        $delete = $this->main->delete('purchases', array('id' => $id));
        if ($delete) {
            $list_products = $this->main->gets('purchase_product', array('purchase' => $id));
            if ($list_products) {
                foreach ($list_products->result() as $p) {
                    $this->db->query("UPDATE products SET quantity = quantity - $p->quantity WHERE id = $p->product");
                }
            }
            $this->main->delete('purchase_product', array('purchase' => $id));
            $this->main->delete('cash', array('purchase' => $id));
            $return = array('message' => sprintf(lang('purchase_delete_success_message'), $data->code), 'status' => 'success');
        } else {
            $return = array('message' => sprintf(lang('purchase_delete_failed_message'), $data->code), 'status' => 'danger');
        }
        echo json_encode($return);
    }

}
