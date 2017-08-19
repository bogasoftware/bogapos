<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Sales extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');
        if (!$this->ion_auth->in_group(2))
            redirect('404');
        $this->load->model('sales_model', 'sales');

        $this->data['menu'] = array('menu' => 'report', 'submenu' => 'sales');
    }

    public function index() {
        $this->template->_default();

        $this->load->css('assets/components/c3js-chart/c3.min.css');
        $this->load->js('assets/components/d3/d3.min.js');
        $this->load->js('assets/components/c3js-chart/c3.min.js');
        $this->load->js('assets/js/modules/reports/sales/chart.min.js');

        $this->output->set_title('Laporan Grafik Penjualan - Bogatoko');

        $this->data['years'] = $this->sales->get_years($this->data['user']->merchant, $this->session->userdata('store')->id);
        $this->data['products'] = $this->sales->get_products($this->data['user']->merchant);

        $this->load->view('sales/chart', $this->data);
    }

    public function recap() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/sales/recap.min.js');

        $this->output->set_title('Laporan Rekap Penjualan - Bogatoko');

        $this->load->view('sales/recap', $this->data);
    }

    public function daily() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/sales/daily.min.js');

        $this->output->set_title('Laporan Penjualan Harian - Bogatoko');

        $this->load->view('sales/daily', $this->data);
    }

    public function monthly_chart() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $sales = $this->sales->monthly($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('year'));

        $data = array();
        foreach ($sales->result() as $sale) {
            $data[$sale->month] = $sale->total;
        }

        for ($i = 1; $i <= 12; $i++) {
            $output[] = array('Penjualan' => (isset($data[$i])) ? $data[$i] : 0);
        }
        echo json_encode($output);
    }

    public function product_monthly_chart() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $sales = $this->sales->product_monthly($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('year'), $this->input->post('product'));
//        $sales = $this->sales->product_monthly($this->data['user']->merchant, $this->session->userdata('store')->id, 2016, 1);

        $data = array();
        foreach ($sales->result() as $sale) {
            $data[$sale->month] = array('total' => $sale->total, 'quantity' => $sale->quantity);
        }
        $output['quantity'] = array();
        for ($i = 1; $i <= 12; $i++) {
            $output['data'][] = array('Penjualan' => (isset($data[$i])) ? $data[$i]['total'] : 0);
            $quantity[($i - 1)] = (isset($data[$i])) ? $data[$i]['quantity'] : 0;
        }
        array_push($output['quantity'], $quantity);
        echo json_encode($output);
    }

    public function recap_data() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $sales = $this->sales->recap($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('start'), $this->input->post('end'));
        $output = '';
        if ($sales) {
            foreach ($sales->result() as $sale) {
                $output .= '<tr>';
                $output .= '<td>' . $sale->code . '</td>';
                $output .= '<td>' . date_simple($sale->date) . '</td>';
                $output .= '<td>' . $sale->customer_name . '</td>';
                $output .= '<td class="uk-text-right subtotal">' . number($sale->subtotal) . '</td>';
                $output .= '<td class="uk-text-right discount">' . number($sale->discount) . '</td>';
                $tax = ($sale->subtotal - $sale->discount) * $sale->tax / 100;
                $output .= '<td class="uk-text-right tax">' . number($tax) . '</td>';
                $output .= '<td class="uk-text-right shipping">' . number($sale->shipping) . '</td>';
                $output .= '<td class="uk-text-right total">' . number($sale->grand_total) . '</td>';
                $output .= '<td class="uk-text-right cash">' . number($sale->cash) . '</td>';
                $output .= '<td class="uk-text-right credit">' . number($sale->credit) . '</td>';
                $output .= '</tr>';
            }
        }
        echo $output;
    }

    public function daily_data() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $sales = $this->sales->daily($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('start'), $this->input->post('end'));
        $output = '';
        if ($sales) {
            foreach ($sales->result() as $sale) {
                $output .= '<tr>';
                $output .= '<td>' . date_simple($sale->date) . '</td>';
                $output .= '<td class="uk-text-right trans">' . number($sale->trans) . '</td>';
                $output .= '<td class="uk-text-right total">' . number($sale->total) . '</td>';
                $output .= '<td class="uk-text-right cash">' . number($sale->cash) . '</td>';
                $output .= '<td class="uk-text-right credit">' . number($sale->credit) . '</td>';
                $output .= '</tr>';
            }
        }
        echo $output;
    }

}
