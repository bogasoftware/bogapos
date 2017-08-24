<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchases_model extends CI_Model {

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
        $this->db->select('id, code, date, supplier_name, grand_total, cash, credit')
                ->limit($size, $page);

        $query = $this->db->get('purchases');
        return($query->num_rows() > 0) ? $query : false;
    }

    function get_alias_key($key) {
        switch ($key) {
            case 1: $key = 'code';
                break;
            case 2: $key = 'date';
                break;
            case 3: $key = 'supplier_name';
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
        $query = $this->db->get('purchases');
        return $query->row()->count;
    }

    function get_purchase_products($purchase) {
        $this->db->select('pp.product id, pp.product_name name, pp.product_code code, pp.quantity, pp.discount, pp.cost price, p.image')
                ->join('products p', 'p.id = pp.product', 'left')
                ->where('purchase', $purchase);
        return $this->db->get('purchase_product pp');
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

    function get_suppliers($search = '') {
        $this->db->select('id, name, city')
                ->limit(10)
                ->like('name', $search);
        return $this->db->get('suppliers');
    }

    function check_code($code, $id = 0) {
        $this->db->select('code')
                ->where('code', $code);
        if ($id)
            $this->db->where('id !=', $id);
        return $this->db->get('purchases');
    }

}
