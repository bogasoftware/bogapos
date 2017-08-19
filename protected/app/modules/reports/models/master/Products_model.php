<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

    function total() {
        return $this->db->count_all_results('products');
    }

    function get_all($store = 'all', $terms = '', $stock_only = '') {
        $this->db->select('code, name, quantity, cost, price', FALSE)
                ->order_by('code ASC');

        if ($store != 'all')
            $this->db->where('store', $store);
        if ($stock_only != '')
            $this->db->where('quantity >', 0);
        if ($terms != '') {
            $this->db->like('code', $terms);
            $this->db->or_like('name', $terms);
        }
        $query = $this->db->get('products');
        return($query->num_rows() > 0) ? $query : false;
    }

}
