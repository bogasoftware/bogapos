<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');
        if (!$this->ion_auth->in_group(2))
            redirect('404');
        $this->load->model('master/products_model', 'products');

        $this->data['menu'] = array('menu' => 'report', 'submenu' => 'master_product');
    }

    public function index() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/master/product.min.js');

        $this->output->set_title('Laporan Master Data Produk - Bogatoko');
        $this->load->view('master/product', $this->data);
    }

    public function data() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $products = $this->products->get_all($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('terms'), $this->input->post('stock_only'));
        $output = '';
        if ($products) {
            foreach ($products->result() as $product) {
                $output .= '<tr>';
                $output .= '<td>' . $product->code . '</td>';
                $output .= '<td>' . $product->name . '</td>';
                $output .= '<td class="uk-text-right">' . number($product->quantity) . '</td>';
                $output .= '<td class="uk-text-right">' . number($product->cost) . '</td>';
                $output .= '<td class="uk-text-right">' . number($product->price) . '</td>';
                $output .= '</tr>';
            }
        }
        echo $output;
    }

}
