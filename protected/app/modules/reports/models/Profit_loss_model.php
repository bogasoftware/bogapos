<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profit_loss_model extends CI_Model {

    function total_this_month($store = 'all') {
        $this->db->select('IFNULL(SUM(s.subtotal),0) sales, IFNULL(SUM(sp.cost),0) cost, IFNULL(p.shipping_cost,0) shipping_cost', FALSE)
                ->join('(SELECT SUM(quantity * cost) cost, sale FROM sale_product GROUP BY sale) sp', 'sp.sale = s.id', 'left')
                ->join('(SELECT SUM(shipping) shipping_cost, date FROM purchases WHERE YEAR(date) = \'' . date('Y') . '\' GROUP BY MONTH(date)) p', 'MONTH(p.date) = MONTH(s.date)', 'left')
                ->group_by('MONTH(s.date)')
                ->where('YEAR(s.date)', date('Y'))
                ->where('MONTH(s.date)', date('m'));

        if ($store != 'all')
            $this->db->where('s.store', $store);

        $query = $this->db->get('sales s');
        return $query->row();
    }

    function monthly($store = 'all', $year) {
        $this->db->select('SUM(s.subtotal) sales, SUM(sp.cost) cost, p.shipping_cost, MONTH(s.date) month', FALSE)
                ->join('(SELECT SUM(quantity * cost) cost, sale FROM sale_product GROUP BY sale) sp', 'sp.sale = s.id', 'left')
                ->join('(SELECT SUM(shipping) shipping_cost, date FROM purchases WHERE YEAR(date) = \'' . $year . '\' GROUP BY MONTH(date)) p', 'MONTH(p.date) = MONTH(s.date)', 'left')
                ->group_by('MONTH(s.date)')
                ->where('YEAR(s.date)', $year)
                ->order_by('MONTH(s.date) ASC');

        if ($store != 'all')
            $this->db->where('s.store', $store);

        $query = $this->db->get('sales s');
        return($query->num_rows() > 0) ? $query : false;
    }

    function recap($store = 'all', $start, $end) {
        $this->db->select('s.code, ms.name store_name, s.date, s.customer_name, s.subtotal, s.discount, SUM(sp.cost) cost', FALSE)
                ->where('s.status', 'completed')
                ->where("(s.date BETWEEN '$start' AND '$end 23:59:59')")
                ->join('(SELECT SUM(quantity * cost) cost, sale FROM sale_product GROUP BY sale) sp', 'sp.sale = s.id', 'left')
                ->join('stores ms', 's.store = ms.id', 'left')
                ->group_by('s.id')
                ->order_by('s.date ASC')
                ->order_by('s.code ASC');

        if ($store != 'all')
            $this->db->where('s.store', $store);

        $query = $this->db->get('sales s');
        return($query->num_rows() > 0) ? $query : false;
    }

    function detail($store = 'all', $start, $end) {
        $this->db->select('s.code, s.date, sp.product_code, sp.product_name, sp.subtotal, (sp.cost * sp.quantity) cost', FALSE)
                ->where('s.status', 'completed')
                ->where("(s.date BETWEEN '$start' AND '$end 23:59:59')")
                ->join('sales s', 's.id = sp.sale AND s.store = sp.store', 'left')
                ->order_by('s.date ASC')
                ->order_by('s.code ASC');

        if ($store != 'all')
            $this->db->where('sp.store', $store);

        $query = $this->db->get('sale_product sp');
        return($query->num_rows() > 0) ? $query : false;
    }

    function net($store = 'all', $start, $end, $method) {
        if ($method == 'income') {
            $this->db->select('SUM(s.subtotal) sales, SUM(sp.cost) cost, SUM(s.discount) discount, SUM(s.shipping) shipping')
                    ->from('sales s')
                    ->join('(SELECT SUM(quantity * cost) cost, sale FROM sale_product GROUP BY sale) sp', 'sp.sale = s.id', 'left')
                    ->where('s.status', 'completed')
                    ->where("(s.date BETWEEN '$start' AND '$end 23:59:59')");
            if ($store != 'all')
                $this->db->where('s.store', $store);
        } elseif ($method == 'shipping_cost') {
            $this->db->select('SUM(shipping) shipping')
                    ->from('purchases')
                    ->where('status', 'completed')
                    ->where("(date BETWEEN '$start' AND '$end 23:59:59')");
            if ($store != 'all')
                $this->db->where('store', $store);
        }
        return $this->db->get()->row();
    }

    function get_years($store = 'all') {
        $this->db->select('YEAR(date) year')
                ->group_by('YEAR(date)')
                ->order_by('year ASC');

        if ($store != 'all')
            $this->db->where('store', $store);

        return $this->db->get('sales');
    }

    function get_products() {
        $this->db->select('id, name')
                ->order_by('name ASC');

        return $this->db->get('products');
    }

}
