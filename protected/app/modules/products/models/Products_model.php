<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

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
        }
        $this->db->select('p.id, code, name, image, price, cost, quantity')
                ->limit($size, $page);

        $query = $this->db->get('products p');
        return($query->num_rows() > 0) ? $query : false;
    }

    function get_alias_key($key) {
        switch ($key) {
            case 2: $key = 'code';
                break;
            case 3: $key = 'name';
                break;
            case 4: $key = 'cost';
                break;
            case 5: $key = 'price';
                break;
            case 6: $key = 'quantity';
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
        $query = $this->db->get('products');
        return $query->row()->count;
    }

}
