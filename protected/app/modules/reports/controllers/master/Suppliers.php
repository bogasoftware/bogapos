<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Suppliers extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');
        if (!$this->ion_auth->in_group(2))
            redirect('404');
        $this->load->model('master/suppliers_model', 'suppliers');

        $this->data['menu'] = array('menu' => 'report', 'submenu' => '');
    }

    public function index() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/master/supplier.min.js');

        $this->output->set_title('Laporan Master Data Pemasok - Bogatoko');
        $this->load->view('master/supplier', $this->data);
    }

    public function data() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $suppliers = $this->suppliers->get_all($this->data['user']->merchant, $this->input->post('terms'));
        $output = '';
        if ($suppliers) {
            foreach ($suppliers->result() as $supplier) {
                $output .= '<tr>';
                $output .= '<td>' . $supplier->name . '</td>';
                $output .= '<td>' . $supplier->address . '</td>';
                $output .= '<td>' . $supplier->city . '</td>';
                $output .= '<td>' . $supplier->postcode . '</td>';
                $output .= '<td>' . $supplier->phone . '</td>';
                $output .= '<td>' . $supplier->email . '</td>';
                $output .= '</tr>';
            }
        }
        echo $output;
    }

}
