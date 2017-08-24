<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Sales extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');

        $this->lang->load('reports', settings('language'));
        $this->load->model('sales_model', 'sales');

        $this->data['menu'] = array('menu' => 'report', 'submenu' => 'sales');
    }

    public function index() {
        $this->template->_default();

        $this->load->css('assets/components/c3js-chart/c3.min.css');
        $this->load->js('assets/components/d3/d3.min.js');
        $this->load->js('assets/components/c3js-chart/c3.min.js');
        $this->load->js('assets/js/modules/reports/sales/chart.js');

        $this->output->set_title(lang('report_sales_chart_title'));

        $this->data['years'] = $this->sales->get_years();
        $this->data['products'] = $this->sales->get_products();

        $this->load->view('sales/chart', $this->data);
    }

    public function recap() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/sales/recap.js');

        $this->output->set_title(lang('report_sales_recap_title'));

        $this->load->view('sales/recap', $this->data);
    }

    public function daily() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/sales/daily.js');

        $this->output->set_title(lang('report_sales_daily_title'));

        $this->load->view('sales/daily', $this->data);
    }

    public function monthly_chart() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $sales = $this->sales->monthly($this->input->post('year'));

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
        $sales = $this->sales->product_monthly($this->input->post('year'), $this->input->post('product'));

        $data = array();
        if ($sales) {
            foreach ($sales->result() as $sale) {
                $data[$sale->month] = array('total' => $sale->total, 'quantity' => $sale->quantity);
            }
        }
        $output['quantity'] = array();
        for ($i = 1; $i <= 12; $i++) {
            $output['data'][] = array(lang('report_sales_text') => (isset($data[$i])) ? $data[$i]['total'] : 0);
            $quantity[($i - 1)] = (isset($data[$i])) ? $data[$i]['quantity'] : 0;
        }
        array_push($output['quantity'], $quantity);
        echo json_encode($output);
    }

    public function recap_data() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $sales = $this->sales->recap(get_date_mysql($this->input->post('start')), get_date_mysql($this->input->post('end')));
        $output = '';
        if ($sales) {
            foreach ($sales->result() as $sale) {
                $output .= '<tr>';
                $output .= '<td>' . $sale->code . '</td>';
                $output .= '<td>' . get_date($sale->date) . '</td>';
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

        $sales = $this->sales->daily(get_date_mysql($this->input->post('start')), get_date_mysql($this->input->post('end')));
        $output = '';
        if ($sales) {
            foreach ($sales->result() as $sale) {
                $output .= '<tr>';
                $output .= '<td>' . get_date($sale->date) . '</td>';
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
