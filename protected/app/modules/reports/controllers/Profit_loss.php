<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Profit_loss extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login');
        if (!$this->ion_auth->in_group(2))
            redirect('404');
        $this->load->model('profit_loss_model', 'profit_loss');

        $this->data['menu'] = array('menu' => 'report', 'submenu' => '');
    }

    public function index() {
        $this->template->_default();

        $this->load->css('assets/components/c3js-chart/c3.min.css');
        $this->load->js('assets/components/d3/d3.min.js');
        $this->load->js('assets/components/c3js-chart/c3.min.js');
        $this->load->js('assets/js/modules/reports/profit_loss/chart.min.js');

        $this->output->set_title('Laporan Grafik Labar/Rugi - Bogatoko');

        $this->data['years'] = $this->profit_loss->get_years($this->data['user']->merchant, $this->session->userdata('store')->id);

        $this->load->view('profit_loss/chart', $this->data);
    }

    public function recap() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/profit_loss/recap.min.js');

        $this->output->set_title('Laporan Rekap Laba Kotor Penjualan - Bogatoko');

        $this->load->view('profit_loss/recap', $this->data);
    }

    public function detail() {
        $this->template->_default();

        $this->load->js('assets/components/tablesorter/dist/js/jquery.tablesorter.min.js');
        $this->load->js('assets/components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js');
        $this->load->js('assets/js/modules/reports/profit_loss/detail.min.js');

        $this->output->set_title('Laporan Detail Laba Penjualan - Bogatoko');

        $this->load->view('profit_loss/detail', $this->data);
    }

    public function net() {
        $this->template->_default();

        $this->load->js('assets/js/modules/reports/profit_loss/net.min.js');

        $this->output->set_title('Laporan Laba/Rugi Bersih - Bogatoko');

        $this->load->view('profit_loss/net', $this->data);
    }

    public function monthly_chart() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $profit_loss = $this->profit_loss->monthly($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('year'));

        $data = array();
        foreach ($profit_loss->result() as $pl) {
            $data[$pl->month] = $pl->sales - $pl->cost - $pl->expense - $pl->shipping_cost;
        }

        for ($i = 1; $i <= 12; $i++) {
            $output[] = array('Laba/Rugi' => (isset($data[$i])) ? $data[$i] : 0);
        }
        echo json_encode($output);
    }

    public function product_monthly_chart() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $profit_loss = $this->profit_loss->product_monthly($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('year'), $this->input->post('product'));
//        $profit_loss = $this->profit_loss->product_monthly($this->data['user']->merchant, $this->session->userdata('store')->id, 2016, 1);

        $data = array();
        foreach ($profit_loss->result() as $pl) {
            $data[$pl->month] = array('total' => $pl->total, 'quantity' => $pl->quantity);
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

        $profit_loss = $this->profit_loss->recap($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('start'), $this->input->post('end'));
        $output = '';
        if ($profit_loss) {
            foreach ($profit_loss->result() as $pl) {
                $output .= '<tr>';
                $output .= '<td>' . $pl->code . '</td>';
                $output .= '<td>' . date_simple($pl->date) . '</td>';
                $output .= '<td>' . $pl->store_name . '</td>';
                $output .= '<td>' . $pl->customer_name . '</td>';
                $output .= '<td class="uk-text-right subtotal">' . number($pl->subtotal) . '</td>';
                $output .= '<td class="uk-text-right hpp">' . number($pl->cost) . '</td>';
                $output .= '<td class="uk-text-right gross-profit">' . number($pl->subtotal - $pl->cost) . '</td>';
                $output .= '<td class="uk-text-right discount">' . number($pl->discount) . '</td>';
                $output .= '<td class="uk-text-right net-profit">' . number($pl->subtotal - $pl->cost - $pl->discount) . '</td>';
                $output .= '</tr>';
            }
        }
        echo $output;
    }

    public function detail_data() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $profit_loss = $this->profit_loss->detail($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('start'), $this->input->post('end'));
        $output = '';
        if ($profit_loss) {
            foreach ($profit_loss->result() as $pl) {
                $output .= '<tr>';
                $output .= '<td>' . $pl->code . '</td>';
                $output .= '<td>' . date_simple($pl->date) . '</td>';
                $output .= '<td>' . $pl->product_code . '</td>';
                $output .= '<td>' . $pl->product_name . '</td>';
                $output .= '<td class="uk-text-right">' . number($pl->subtotal) . '</td>';
                $output .= '<td class="uk-text-right">' . number($pl->cost) . '</td>';
                $output .= '<td class="uk-text-right">' . number($profit = $pl->subtotal - $pl->cost) . '</td>';
                $output .= '<td class="uk-text-right">' . number($profit / $pl->cost * 100) . '</td>';
                $output .= '</tr>';
            }
        }
        echo $output;
    }

    public function net_data() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $income = $this->profit_loss->net($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('start'), $this->input->post('end'), 'income');
        $output = '<tr>
                    <td><strong>Pendapatan</strong></td>
                    <td></td>
                    </tr>';
        if ($income->sales > 0) {
            $output .= '<tr>
                    <td><label class="uk-margin-left">Pendapatan Jual</label></td>
                    <td class="uk-text-right">' . number($income->sales + $income->shipping + $income->discount) . '</td>
                    </tr>';
        }
        if ($income->discount > 0) {
            $output .= '<tr>
                    <td><label class="uk-margin-left">Potongan Penjualan</label></td>
                    <td class="uk-text-right">-' . number($income->discount) . '</td>
                    </tr>';
        }
        if ($income->shipping > 0) {
            $output .= '<tr>
                    <td><label class="uk-margin-left">Biaya Kirim Penjualan</label></td>
                    <td class="uk-text-right">-' . number($income->shipping) . '</td>
                    </tr>';
        }
        $output .= '<tr>
                    <td><strong>Total Pendapatan</strong></td>
                    <td class="uk-text-right"><strong>' . number($profit_loss = $income->sales) . '</strong></td>
                    </tr>';
        $output .= '<tr>
                    <td><strong>HPP</strong></td>
                    <td></td>
                    </tr>';
        if ($income->cost > 0) {
            $output .= '<tr>
                    <td><label class="uk-margin-left">Harga Pokok Penjualan</label></td>
                    <td class="uk-text-right">' . number($income->cost) . '</td>
                    </tr>';
        }
        $output .= '<tr>
                    <td><strong>Total HPP</strong></td>
                    <td class="uk-text-right"><strong>' . number($income->cost) . '</strong></td>
                    </tr>';
        $output .= '<tr>
                    <td><strong>Laba Kotor</strong></td>
                    <td class="uk-text-right"><strong>' . number($profit_loss = $profit_loss - $income->cost) . '</strong></td>
                    </tr>
                    <tr>';
        $output .= '<td><strong>Biaya</strong></td>
                    <td></td>
                    </tr>
                    <tr>';

        $shipping_cost = $this->profit_loss->net($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('start'), $this->input->post('end'), 'shipping_cost');
        if ($shipping_cost->shipping > 0) {
            $output .= '<td><label class="uk-margin-left">Biaya Kirim Pembelian</label></td>
                    <td class="uk-text-right">' . number($shipping_cost->shipping) . '</td>
                    </tr>';
        }
        $cost = $this->profit_loss->net($this->data['user']->merchant, $this->session->userdata('store')->id, $this->input->post('start'), $this->input->post('end'), 'cost');
        if ($cost->amount > 0) {
            $output .= '<tr>
                    <td><label class="uk-margin-left">Biaya Umum Pengeluaran</label></td>
                    <td class="uk-text-right">' . number($cost->amount) . '</td>
                    </tr>';
        }
        $output .= '<tr>
                    <td><strong>Total Biaya</strong></td>
                    <td class="uk-text-right"><strong>' . number($shipping_cost->shipping + $cost->amount) . '</strong></td>
                    </tr>
                    <tr>
                    <td><strong>Laba / Rugi</strong></td>
                    <td class="uk-text-right"><strong>' . number($profit_loss - $cost->amount - $shipping_cost->shipping) . '</strong></td>
                    </tr>';
        echo $output;
    }

}
