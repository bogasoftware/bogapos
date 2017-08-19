<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers_model extends CI_Model {

    function total() {
        return $this->db->count_all_results('suppliers');
    }

    function get_all($terms = '') {
        $this->db->order_by('name ASC');

        if ($terms != '') {
            $this->db->like('name', $terms)
                    ->or_like('email', $terms)
                    ->or_like('phone', $terms)
                    ->or_like('address', $terms)
                    ->or_like('city', $terms)
                    ->or_like('postcode', $terms);
        }
        $query = $this->db->get('suppliers');
        return($query->num_rows() > 0) ? $query : false;
    }

}
