<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

if (!function_exists('encode')) {

    function encode($string) {
        return encrypt_decrypt('encrypt', $string);
    }

}

if (!function_exists('decode')) {

    function decode($string) {
        return encrypt_decrypt('decrypt', $string);
    }

}

if (!function_exists('encrypt_decrypt')) {

    function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'rifkysyaripudin';
        $secret_iv = 'bogapos';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

}

function number($val) {
    $value = number_format($val, settings('number_of_decimal'), settings('separator_decimal'), settings('separator_thousand'));
    return $value;
}

function parse_number($number, $dec_point = null) {
    $dec_point = settings('separator_decimal');
    if (empty($dec_point)) {
        $locale = localeconv();
        $dec_point = $locale['decimal_point'];
    }
    return floatval(str_replace($dec_point, '.', preg_replace('/[^\d' . preg_quote($dec_point) . ']/', '', $number)));
}

function get_date($date) {
    $format = settings('date_format');
    $timestamp = strtotime($date);
    return date($format, $timestamp);
}

function get_date_mysql($date) {
    return date_format(date_create_from_format(settings('date_format'), $date), 'Y-m-d');
}

function get_month($month) {
    $CI = get_instance();
    return $CI->lang->line($month);
}

function trx_code($type) {
    $CI = get_instance();
    $CI->load->database();
    $format = settings('code_format_' . $type);
    if ($type == 'cash_in') {
        $table = 'cash';
        $CI->db->where('type', 'in');
    } elseif ($type == 'cash_out') {
        $table = 'cash';
        $CI->db->where('type', 'out');
    } elseif ($type == 'pos') {
        $table = 'sales';
        $CI->db->where('pos', 1);
    } else {
        $table = $type;
    }
    $month = date('m');
    $year = date('y');
    $my = $month . $year;
    $in = $CI->db->where('YEAR(date)', date('Y'))->count_all_results($table);
    $in = ($in == 0) ? 1 : $in + 1;
    if ($in < 10) {
        $in = '000' . $in;
    } elseif ($in < 100) {
        $in = '00' . $in;
    } elseif ($in < 1000) {
        $in = '0' . $in;
    }
    $code = str_replace('[IN]', $in, $format);
    $code = str_replace('[MONTH]', $month, $code);
    $code = str_replace('[YEAR]', $year, $code);
    $code = str_replace('[MY]', $my, $code);
    return $code;
}

function settings($key) {
    if ($key) {
        $CI = get_instance();
        $CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $CI->cache->delete('settings');
        if ($CI->cache->get('settings')) {
            return $CI->cache->get('settings')[$key];
        } else {
            $CI->load->database();
            $settings = $CI->db->get('settings');
            foreach ($settings->result() as $setting) {
                $data[$setting->key] = $setting->value;
            }
            $CI->cache->save('settings', $data, 7200);
            return $data[$key];
            $query = $CI->db->get_where('settings', array('key' => $key));
            if ($query->num_rows() > 0) {
                return $query->row()->value;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}

function remove_space($string) {
    return str_replace(' ', '', $string);
}

/* End of file common_helper.php */
/* Location: ./system/helpers/common_helper.php */
