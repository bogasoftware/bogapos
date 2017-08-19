<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends CI_Model {

    function total_this_month($store = 'all') {
        $this->db->select('IFNULL(SUM(grand_total),0) total', FALSE)
                ->where('YEAR(date)', date('Y'))
                ->where('MONTH(date)', date('m'));                

        if ($store != 'all')
            $this->db->where('store', $store);

        $query = $this->db->get('purchases');
        return $query->row()->total;
    }

    function monthly($store = 'all', $year) {
        $this->db->select('SUM(grand_total) total, MONTH(date) month', FALSE)
                ->group_by('MONTH(date)')
                ->where('YEAR(date)', $year)                
                ->order_by('MONTH(date) ASC');

        if ($store != 'all')
            $this->db->where('store', $store);

        $query = $this->db->get('purchases');
        return($query->num_rows() > 0) ? $query : false;
    }

    function product_monthly($store = 'all', $year, $product) {
        $this->db->select('MONTH(p.date) month, SUM(pp.subtotal) total, SUM(pp.quantity) quantity', FALSE)
                ->join('purchase_product pp', 'p.id = pp.purchase AND p.store = pp.store', 'right')
                ->group_by('MONTH(p.date)')
                ->where('YEAR(p.date)', $year)
                ->where('pp.product', $product)                
                ->order_by('MONTH(p.date) ASC');

        if ($store != 'all')
            $this->db->where('p.store', $store);

        $query = $this->db->get('purchases p');
        return($query->num_rows() > 0) ? $query : false;
    }

    function recap($store = 'all', $start, $end) {
        $this->db->select('id, code, date, supplier_name, subtotal, discount, tax, shipping, grand_total, cash, credit', FALSE)
                ->where('status', 'completed')
                ->where("(date BETWEEN '$start' AND '$end 23:59:59')")                
                ->order_by('date ASC')
                ->order_by('code ASC');

        if ($store != 'all')
            $this->db->where('store', $store);

        $query = $this->db->get('purchases');
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

        $query = $this->db->get('purchases');
        return($query->num_rows() > 0) ? $query : false;
    }

    function get_years($store = 'all') {
        $this->db->select('YEAR(date) year')
                ->group_by('YEAR(date)')
                ->order_by('year ASC');                

        if ($store != 'all')
            $this->db->where('store', $store);

        return $this->db->get('purchases');
    }

    function get_products() {
        $this->db->select('id, name')
                ->order_by('name ASC');

        return $this->db->get('products');
    }

}
