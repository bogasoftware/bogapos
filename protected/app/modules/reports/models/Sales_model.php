<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_model extends CI_Model {

    function total_this_month($store = 'all') {
        $this->db->select('IFNULL(SUM(grand_total),0) total', FALSE)
                ->where('YEAR(date)', date('Y'))
                ->where('MONTH(date)', date('m'));                

        if ($store != 'all')
            $this->db->where('store', $store);

        $query = $this->db->get('sales');
        return $query->row()->total;
    }

    function monthly($store = 'all', $year) {
        $this->db->select('SUM(grand_total) total, MONTH(date) month', FALSE)
                ->group_by('MONTH(date)')
                ->where('YEAR(date)', $year)                
                ->order_by('MONTH(date) ASC');

        if ($store != 'all')
            $this->db->where('store', $store);

        $query = $this->db->get('sales');
        return($query->num_rows() > 0) ? $query : false;
    }

    function product_monthly($store = 'all', $year, $product) {
        $this->db->select('MONTH(s.date) month, SUM(sp.subtotal) total, SUM(sp.quantity) quantity', FALSE)
                ->join('sale_product sp', 's.id = sp.sale AND s.store = sp.store', 'right')
                ->group_by('MONTH(s.date)')
                ->where('YEAR(s.date)', $year)
                ->where('sp.product', $product)                
                ->order_by('MONTH(s.date) ASC');

        if ($store != 'all')
            $this->db->where('s.store', $store);

        $query = $this->db->get('sales s');
        return($query->num_rows() > 0) ? $query : false;
    }

    function recap($store = 'all', $start, $end) {
        $this->db->select('id, code, date, customer_name, subtotal, discount, tax, shipping, grand_total, cash, credit', FALSE)
                ->where('status', 'completed')
                ->where("(date BETWEEN '$start' AND '$end 23:59:59')")                
                ->order_by('date ASC')
                ->order_by('code ASC');

        if ($store != 'all')
            $this->db->where('store', $store);

        $query = $this->db->get('sales');
        return($query->num_rows() > 0) ? $query : false;
    }

    function daily($store = 'all', $start, $end) {
        $this->db->select('DATE(date) date, COUNT(id) trans, SUM(grand_total) total, SUM(cash) cash, SUM(credit) credit', FALSE)
                ->where('status', 'completed')
                ->where("(date BETWEEN '$start' AND '$end 23:59:59')")                
                ->group_by('DATE(date)')
                ->order_by('date ASC');

        if ($store != 'all')
            $this->db->where('store', $store);

        $query = $this->db->get('sales');
        return($query->num_rows() > 0) ? $query : false;
    }

    function get_years($store = 'all') {
        $this->db->select('YEAR(date) year')
                ->group_by('YEAR(date)')
                ->order_by('year ASC');                

        if ($store != 'all')
            $this->db->where('store', $store);

        return $this->db->get('sales');
    }

    function get_products($merchant) {
        $this->db->select('id, name')
                ->order_by('name ASC');                

        return $this->db->get('products');
    }

}
