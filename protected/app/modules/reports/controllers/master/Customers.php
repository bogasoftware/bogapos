<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Customers extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');
        if (!$this->ion_auth->in_group(2))
            redirect('404');
        $this->load->model('master/customers_model', 'customers');

        $this->data['menu'] = array('menu' => 'report', 'submenu' => 'master_customer');
    }

    public function index() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/master/customer.min.js');

        $this->output->set_title('Laporan Master Data Konsumen - Bogatoko');
        $this->load->view('master/customer', $this->data);
    }

    public function data() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $customers = $this->customers->get_all($this->data['user']->merchant, $this->input->post('terms'));
        $output = '';
        if ($customers) {
            foreach ($customers->result() as $customer) {
                $output .= '<tr>';
                $output .= '<td>' . $customer->name . '</td>';
                $output .= '<td>' . $customer->address . '</td>';
                $output .= '<td>' . $customer->city . '</td>';
                $output .= '<td>' . $customer->postcode . '</td>';
                $output .= '<td>' . $customer->phone . '</td>';
                $output .= '<td>' . $customer->email . '</td>';
                $output .= '</tr>';
            }
        }
        echo $output;
    }

}
