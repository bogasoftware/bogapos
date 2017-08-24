<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    function sales() {
        $this->db->select('IFNULL(SUM(grand_total),0) total')
                ->where('SUBSTR(date,1,7)', date('Y-m'))
                ->where('status', 'completed');

        $query = $this->db->get('sales');
        return $query->row();
    }

    function purchase() {
        $this->db->select('IFNULL(SUM(grand_total),0) total')
                ->where('SUBSTR(date,1,7)', date('Y-m'))
                ->where('status', 'completed');

        $query = $this->db->get('purchases');
        return $query->row();
    }

    function sales_purchase($month) {
        $query = $this->db->query("SELECT (SELECT IFNULL(SUM(grand_total),0) FROM sales WHERE SUBSTR(date,1,7) = '" . date('Y-') . $month . "') " . lang('home_sales_chart_label') . ", (SELECT IFNULL(SUM(grand_total),0) FROM purchases WHERE SUBSTR(date,1,7) = '" . date('Y-') . $month . "') " . lang('home_purchases_chart_label'));
        return $query->row();
    }

}
