<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Reports extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');

        $this->lang->load('reports', settings('language'));
        $this->load->model('sales_model', 'sales');
        $this->load->model('purchase_model', 'purchase');
        $this->load->model('profit_loss_model', 'profit_loss');
//        $this->load->model('master/products_model', 'products');
//        $this->load->model('master/customers_model', 'customers');
//        $this->load->model('master/suppliers_model', 'suppliers');

        $this->data['menu'] = array('menu' => 'report', 'submenu' => '');
    }

    public function index() {
        $this->template->_default();

        $this->data['total_sales'] = $this->sales->total_this_month();
        $this->data['total_purchase'] = $this->purchase->total_this_month();
//        $this->data['total_products'] = $this->products->total();
//        $this->data['total_customers'] = $this->customers->total();
//        $this->data['total_suppliers'] = $this->suppliers->total();
        $profit_loss = $this->profit_loss->total_this_month();
        $this->data['total_profit_loss'] = ($profit_loss) ? ($profit_loss->sales - $profit_loss->cost - $profit_loss->expense - $profit_loss->shipping_cost) : 0;

        $this->output->set_title(lang('report_title'));
        $this->load->view('report', $this->data);
    }

}
