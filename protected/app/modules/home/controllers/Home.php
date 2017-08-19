<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->lang->load('home', settings('language'));
        $this->load->model('home_model', 'home');
        $this->load->model('reports/profit_loss_model', 'profit_loss');
        $this->data['menu'] = array('menu' => 'home', 'submenu' => '');
    }

    public function index() {
        $this->template->_default();

        $this->load->css('assets/components/c3js-chart/c3.min.css');
        $this->load->js('assets/components/d3/d3.min.js');
        $this->load->js('assets/components/c3js-chart/c3.min.js');
        $this->load->js('assets/js/modules/home.js');
        $this->data['sales'] = $this->home->sales($this->session->userdata('store')->id);
        $this->data['purchase'] = $this->home->purchase($this->session->userdata('store')->id);

        $profit_loss = $this->profit_loss->total_this_month($this->session->userdata('store')->id);
        $this->data['profit_loss'] = ($profit_loss) ? $profit_loss->sales - $profit_loss->cost - $profit_loss->shipping_cost : 0;

        $this->output->set_title(lang('home_title'));
        $this->load->view('home', $this->data);
    }

    public function sales_chart() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $this->home->sales_purchase(($i < 10 ? '0' . $i : $i), $this->session->userdata('store')->id);
        }

        echo json_encode($data);
    }

}
