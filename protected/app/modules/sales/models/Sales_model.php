<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_model extends CI_Model {

    function get_all($page = 0, $size, $filter = array(), $sort = array()) {
        if ($page)
            $page = $page * $size;
        if ($filter) {
            foreach ($filter as $key => $value) {
                $key = $this->get_alias_key($key);
                $this->db->like($key, $value);
            }
        }
        if ($sort) {
            $key = key($sort);
            $order = ($sort[$key] == 1) ? 'desc' : 'asc';
            $sort = $this->get_alias_key($key);
            $this->db->order_by($sort, $order);
        } else {
            $this->db->order_by('date DESC');
            $this->db->order_by('code DESC');
        }
        $this->db->select('id, code, date, customer_name, grand_total, cash, credit, pos')
                ->limit($size, $page);

        $query = $this->db->get('sales');
        return($query->num_rows() > 0) ? $query : false;
    }

    function get_alias_key($key) {
        switch ($key) {
            case 1: $key = 'code';
                break;
            case 2: $key = 'date';
                break;
            case 3: $key = 'customer_name';
                break;
            case 4: $key = 'grand_total';
                break;
            case 5: $key = 'cash';
                break;
            case 6: $key = 'credit';
                break;
        }
        return $key;
    }

    function count_all($filter = array()) {
        if ($filter) {
            foreach ($filter as $key => $value) {
                $key = $this->get_alias_key($key);
                $this->db->like($key, $value);
            }
        }
        $this->db->select('IFNULL(COUNT(id),0) count');
        $query = $this->db->get('sales');
        return $query->row()->count;
    }

    function get_sale_products($sale) {
        $this->db->select('sp.product id, sp.product_name name, sp.product_code code, sp.quantity, sp.discount, sp.fix_price price, p.image')
                ->join('products p','p.id = sp.product','left')
                ->where('sale', $sale);
        return $this->db->get('sale_product sp');
    }

    function get_all_products($page = 0, $size, $filter = array(), $sort = array()) {
        if ($page)
            $page = $page * $size;
        if ($filter) {
            foreach ($filter as $key => $value) {
                $key = $this->get_alias_key_products($key);
                $this->db->like($key, $value);
            }
        }
        if ($sort) {
            $key = key($sort);
            $order = ($sort[$key] == 1) ? 'desc' : 'asc';
            $sort = $this->get_alias_key($key);
            $this->db->order_by($sort, $order);
        }
        $this->db->select('p.id, code, name, image, price, cost, quantity')
                ->limit($size, $page);                

        $query = $this->db->get('products p');
        return($query->num_rows() > 0) ? $query : false;
    }

    function get_alias_key_products($key) {
        switch ($key) {
            case 1: $key = 'code';
                break;
            case 2: $key = 'name';
                break;
            case 3: $key = 'cost';
                break;
            case 4: $key = 'price';
                break;
            case 5: $key = 'ps.quantity';
                break;
        }
        return $key;
    }

    function count_all_products($filter = array()) {
        if ($filter) {
            foreach ($filter as $key => $value) {
                $key = $this->get_alias_key_products($key);
                $this->db->like($key, $value);
            }
        }
        $this->db->select('IFNULL(COUNT(id),0) count');
        $query = $this->db->get('products');
        return $query->row()->count;
    }

    function get_customers($search = '') {
        $this->db->select('id, name, city')
                ->limit(10)
                ->like('name', $search);
        return $this->db->get('customers');
    }

    function check_code($code, $id = 0) {
        $this->db->select('code')
                ->where('code', $code);
        if ($id)
            $this->db->where('id !=', $id);
        return $this->db->get('sales');
    }

}
