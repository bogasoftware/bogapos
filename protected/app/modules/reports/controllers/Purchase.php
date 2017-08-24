<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Purchase extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');
        $this->lang->load('reports', settings('language'));
        $this->load->model('purchase_model', 'purchase');

        $this->data['menu'] = array('menu' => 'report', 'submenu' => 'purchase');
    }

    public function index() {
        $this->template->_default();

        $this->load->css('assets/components/c3js-chart/c3.min.css');
        $this->load->js('assets/components/d3/d3.min.js');
        $this->load->js('assets/components/c3js-chart/c3.min.js');
        $this->load->js('assets/js/modules/reports/purchase/chart.js');

        $this->output->set_title(lang('report_purchase_chart_title'));

        $this->data['years'] = $this->purchase->get_years();
        $this->data['products'] = $this->purchase->get_products();

        $this->load->view('purchase/chart', $this->data);
    }

    public function recap() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/purchase/recap.js');

        $this->output->set_title(lang('report_purchase_recap_title'));

        $this->load->view('purchase/recap', $this->data);
    }

    public function daily() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/purchase/daily.js');

        $this->output->set_title(lang('report_purchase_daily_title'));

        $this->load->view('purchase/daily', $this->data);
    }

    public function monthly_chart() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $purchase = $this->purchase->monthly($this->input->post('year'));

        $data = array();
        foreach ($purchase->result() as $purchase) {
            $data[$purchase->month] = $purchase->total;
        }

        for ($i = 1; $i <= 12; $i++) {
            $output[] = array('Pembelian' => (isset($data[$i])) ? $data[$i] : 0);
        }
        echo json_encode($output);
    }

    public function product_monthly_chart() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $purchase = $this->purchase->product_monthly($this->input->post('year'), $this->input->post('product'));

        $data = array();
        foreach ($purchase->result() as $purchase) {
            $data[$purchase->month] = array('total' => $purchase->total, 'quantity' => $purchase->quantity);
        }
        $output['quantity'] = array();
        for ($i = 1; $i <= 12; $i++) {
            $output['data'][] = array(lang('report_purchase_text') => (isset($data[$i])) ? $data[$i]['total'] : 0);
            $quantity[($i - 1)] = (isset($data[$i])) ? $data[$i]['quantity'] : 0;
        }
        array_push($output['quantity'], $quantity);
        echo json_encode($output);
    }

    public function recap_data() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $purchases = $this->purchase->recap(get_date_mysql($this->input->post('start')), get_date_mysql($this->input->post('end')));
        $output = '';
        if ($purchases) {
            foreach ($purchases->result() as $purchase) {
                $output .= '<tr>';
                $output .= '<td>' . $purchase->code . '</td>';
                $output .= '<td>' . get_date($purchase->date) . '</td>';
                $output .= '<td>' . $purchase->supplier_name . '</td>';
                $output .= '<td class="uk-text-right subtotal">' . number($purchase->subtotal) . '</td>';
                $output .= '<td class="uk-text-right discount">' . number($purchase->discount) . '</td>';
                $tax = ($purchase->subtotal - $purchase->discount) * $purchase->tax / 100;
                $output .= '<td class="uk-text-right tax">' . number($tax) . '</td>';
                $output .= '<td class="uk-text-right shipping">' . number($purchase->shipping) . '</td>';
                $output .= '<td class="uk-text-right total">' . number($purchase->grand_total) . '</td>';
                $output .= '<td class="uk-text-right cash">' . number($purchase->cash) . '</td>';
                $output .= '<td class="uk-text-right credit">' . number($purchase->credit) . '</td>';
                $output .= '</tr>';
            }
        }
        echo $output;
    }

    public function daily_data() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $purchases = $this->purchase->daily(get_date_mysql($this->input->post('start')), get_date_mysql($this->input->post('end')));
        $output = '';
        if ($purchases) {
            foreach ($purchases->result() as $purchase) {
                $output .= '<tr>';
                $output .= '<td>' . get_date($purchase->date) . '</td>';
                $output .= '<td class="uk-text-right trans">' . number($purchase->trans) . '</td>';
                $output .= '<td class="uk-text-right total">' . number($purchase->total) . '</td>';
                $output .= '<td class="uk-text-right cash">' . number($purchase->cash) . '</td>';
                $output .= '<td class="uk-text-right credit">' . number($purchase->credit) . '</td>';
                $output .= '</tr>';
            }
        }
        echo $output;
    }

}
