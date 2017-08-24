<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profit_loss_model extends CI_Model {

    function total_this_month() {
        $this->db->select('IFNULL(SUM(s.subtotal),0) sales, IFNULL(SUM(sp.cost),0) cost, IFNULL(c.expense,0) expense, IFNULL(p.shipping_cost,0) shipping_cost', FALSE)
                ->join('(SELECT IFNULL(SUM(quantity * cost),0) cost, sale FROM sale_product GROUP BY sale) sp', 'sp.sale = s.id', 'left')
                ->join('(SELECT SUM(amount) expense, date FROM cash WHERE YEAR(date) = \'' . date('Y') . '\' AND type="out" AND sale IS NULL AND `return` IS NULL AND purchase IS NULL GROUP BY MONTH(date)) c', 'MONTH(c.date) = MONTH(s.date)', 'left')
                ->join('(SELECT IFNULL(SUM(shipping),0) shipping_cost, date FROM purchases WHERE YEAR(date) = \'' . date('Y') . '\' GROUP BY MONTH(date)) p', 'MONTH(p.date) = MONTH(s.date)', 'left')
                ->group_by('MONTH(s.date)')
                ->where('YEAR(s.date)', date('Y'))
                ->where('MONTH(s.date)', date('m'));

        $query = $this->db->get('sales s');
        return ($query) ? $query->row() : false;
    }

    function monthly($year) {
        $this->db->select('SUM(s.subtotal) sales, SUM(sp.cost) cost, c.expense, p.shipping_cost, MONTH(s.date) month', FALSE)
                ->join('(SELECT SUM(quantity * cost) cost, sale FROM sale_product GROUP BY sale) sp', 'sp.sale = s.id', 'left')
                ->join('(SELECT SUM(amount) expense, date FROM cash WHERE YEAR(date) = \'' . $year . '\' AND type="out" AND sale IS NULL AND `return` IS NULL AND purchase IS NULL GROUP BY MONTH(date)) c', 'MONTH(c.date) = MONTH(s.date)', 'left')
                ->join('(SELECT SUM(shipping) shipping_cost, date FROM purchases WHERE YEAR(date) = \'' . $year . '\' GROUP BY MONTH(date)) p', 'MONTH(p.date) = MONTH(s.date)', 'left')
                ->group_by('MONTH(s.date)')
                ->where('YEAR(s.date)', $year)
                ->order_by('MONTH(s.date) ASC');

        $query = $this->db->get('sales s');
        return($query->num_rows() > 0) ? $query : false;
    }

    function recap($start, $end) {
        $this->db->select('s.code, s.date, s.customer_name, s.subtotal, s.discount, SUM(sp.cost) cost', FALSE)
                ->where('s.status', 'completed')
                ->where("(s.date BETWEEN '$start' AND '$end 23:59:59')")
                ->join('(SELECT SUM(quantity * cost) cost, sale FROM sale_product GROUP BY sale) sp', 'sp.sale = s.id', 'left')
                ->group_by('s.id')
                ->order_by('s.date ASC')
                ->order_by('s.code ASC');

        $query = $this->db->get('sales s');
        return($query->num_rows() > 0) ? $query : false;
    }

    function detail($start, $end) {
        $this->db->select('s.code, s.date, sp.product_code, sp.product_name, sp.subtotal, (sp.cost * sp.quantity) cost', FALSE)
                ->where('s.status', 'completed')
                ->where("(s.date BETWEEN '$start' AND '$end 23:59:59')")
                ->join('sales s', 's.id = sp.sale', 'left')
                ->order_by('s.date ASC')
                ->order_by('s.code ASC');

        $query = $this->db->get('sale_product sp');
        return($query->num_rows() > 0) ? $query : false;
    }

    function net($start, $end, $method) {
        if ($method == 'income') {
            $this->db->select('SUM(s.subtotal) sales, SUM(sp.cost) cost, SUM(s.discount) discount, SUM(s.shipping) shipping')
                    ->from('sales s')
                    ->join('(SELECT SUM(quantity * cost) cost, sale FROM sale_product GROUP BY sale) sp', 'sp.sale = s.id', 'left')
                    ->where('s.status', 'completed')
                    ->where("(s.date BETWEEN '$start' AND '$end 23:59:59')");
        } elseif ($method == 'cost') {
            $this->db->select('SUM(amount) amount')
                    ->from('cash')
                    ->where('type', 'out')
                    ->where('sale IS NULL AND `return` IS NULL AND purchase IS NULL')
                    ->where("(date BETWEEN '$start' AND '$end 23:59:59')");
        } elseif ($method == 'shipping_cost') {
            $this->db->select('SUM(shipping) shipping')
                    ->from('purchases')
                    ->where('status', 'completed')
                    ->where("(date BETWEEN '$start' AND '$end 23:59:59')");
        }
        return $this->db->get()->row();
    }

    function get_years() {
        $this->db->select('YEAR(date) year')
                ->group_by('YEAR(date)')
                ->order_by('year ASC');

        return $this->db->get('sales');
    }

    function get_products() {
        $this->db->select('id, name')
                ->order_by('name ASC');

        return $this->db->get('products');
    }

}
