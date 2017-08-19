<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Purchase extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');
        if (!$this->ion_auth->in_group(2))
            redirect('404');
        $this->load->model('purchase_model', 'purchase');

        $this->data['menu'] = array('menu' => 'report', 'submenu' => 'purchase');
    }

    public function index() {
        $this->template->_default();

        $this->load->css('assets/components/c3js-chart/c3.min.css');
        $this->load->js('assets/components/d3/d3.min.js');
        $this->load->js('assets/components/c3js-chart/c3.min.js');
        $this->load->js('assets/js/modules/reports/purchase/chart.min.js');

        $this->output->set_title('Laporan Grafik Pembelian - Bogatoko');

        $this->data['years'] = $this->purchase->get_years($this->data['user']->merchant, $this->session->userdata('store')->id);
        $this->data['products'] = $this->purchase->get_products($this->data['user']->merchant);

        $this->load->view('purchase/chart', $this->data);
    }

    public function recap() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/purchase/recap.min.js');

        $this->output->set_title('Laporan Rekap Pembelian - Bogatoko');

        $this->load->view('purchase/recap', $this->data);
    }

    public function daily() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/purchase/daily.min.js');

        $this->output->set_title('Laporan Pembelian Harian - Bogatoko');

        $this->load->view('purchase/daily', $this->data);
    }

    public function monthly_chart() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $purchase = $this->purchase->monthly($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('year'));

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
        $purchase = $this->purchase->product_monthly($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('year'), $this->input->post('product'));
//        $purchase = $this->purchase->product_monthly($this->data['user']->merchant, $this->session->userdata('store')->id, 2016, 1);

        $data = array();
        foreach ($purchase->result() as $purchase) {
            $data[$purchase->month] = array('total' => $purchase->total, 'quantity' => $purchase->quantity);
        }
        $output['quantity'] = array();
        for ($i = 1; $i <= 12; $i++) {
            $output['data'][] = array('Pembelian' => (isset($data[$i])) ? $data[$i]['total'] : 0);
            $quantity[($i - 1)] = (isset($data[$i])) ? $data[$i]['quantity'] : 0;
        }
        array_push($output['quantity'], $quantity);
        echo json_encode($output);
    }

    public function recap_data() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $purchases = $this->purchase->recap($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('start'), $this->input->post('end'));
        $output = '';
        if ($purchases) {
            foreach ($purchases->result() as $purchase) {
                $output .= '<tr>';
                $output .= '<td>' . $purchase->code . '</td>';
                $output .= '<td>' . date_simple($purchase->date) . '</td>';
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

        $purchases = $this->purchase->daily($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('start'), $this->input->post('end'));
        $output = '';
        if ($purchases) {
            foreach ($purchases->result() as $purchase) {
                $output .= '<tr>';
                $output .= '<td>' . date_simple($purchase->date) . '</td>';
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
