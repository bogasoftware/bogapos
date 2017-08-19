<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    function sales($store = 'all') {
        $this->db->select('IFNULL(SUM(grand_total),0) total')
                ->where('SUBSTR(date,1,7)', date('Y-m'))
                ->where('status', 'completed');

        if ($store != 'all')
            $this->db->where('store', $store);

        $query = $this->db->get('sales');
        return $query->row();
    }

    function purchase($store = 'all') {
        $this->db->select('IFNULL(SUM(grand_total),0) total')
                ->where('SUBSTR(date,1,7)', date('Y-m'))
                ->where('status', 'completed');

        if ($store != 'all')
            $this->db->where('store', $store);

        $query = $this->db->get('purchases');
        return $query->row();
    }

    function sales_purchase($month, $store = 'all') {
        if ($store != 'all')
            $store = ' AND store = ' . $store;
        else {
            $store = '';
        }
        $query = $this->db->query("SELECT (SELECT IFNULL(SUM(grand_total),0) FROM sales WHERE SUBSTR(date,1,7) = '" . date('Y-') . $month . "' $store) " . lang('home_sales_chart_label') . ", (SELECT IFNULL(SUM(grand_total),0) FROM purchases WHERE SUBSTR(date,1,7) = '" . date('Y-') . $month . "' $store) " . lang('home_purchases_chart_label'));
        return $query->row();
    }

}
