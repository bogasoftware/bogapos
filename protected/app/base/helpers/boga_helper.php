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

if (!function_exists('number')) {

    function number($val) {
        $value = number_format($val, 0, ',', '.');
        return $value;
    }

}

if (!function_exists('date_indo')) {

    function date_indo($fulldate) {
        $date = substr($fulldate, 8, 2);
        $month = get_month(substr($fulldate, 5, 2));
        $year = substr($fulldate, 0, 4);
        return $date . ' ' . $month . ' ' . $year;
    }

}

if (!function_exists('date_simple')) {

    function date_simple($fulldate) {
        $date = substr($fulldate, 8, 2);
        $month = substr($fulldate, 5, 2);
        $year = substr($fulldate, 0, 4);
        return $date . '-' . $month . '-' . $year;
    }

}

if (!function_exists('normal_date')) {

    function normal_date($fulldate) {
        $date = substr($fulldate, 8, 2);
        $month = get_month3(substr($fulldate, 5, 2));
        $year = substr($fulldate, 0, 4);
        return $date . '/' . $month . '/' . $year;
    }

}

if (!function_exists('date_time')) {

    function date_time($fulldate) {
        $date = substr($fulldate, 8, 2);
        $month = get_month3(substr($fulldate, 5, 2));
        $year = substr($fulldate, 0, 4);
        $time = substr($fulldate, 11, 5);
        return $date . '/' . $month . '/' . $year . ' ' . $time;
    }

}

if (!function_exists('mysql_date')) {

    function mysql_date($fulldate) {
        $date = substr($fulldate, 0, 2);
        $month = get_month2(substr($fulldate, 3, 3));
        $year = substr($fulldate, 7, 4);
        return $year . '-' . $month . '-' . $date;
    }

}

if (!function_exists('get_month')) {

    function get_month($month) {
        $CI = get_instance();
        return $CI->lang->line($month);
    }

}

if (!function_exists('trx_code')) {

    function trx_code($store, $type, $trx) {
        $CI = get_instance();
        $CI->load->database();
        $month = date('m');
        $year = date('y');
        $ym = $trx . '/' . $store . '/' . $month . $year;
        $j = strlen($ym);
        $CI->db->select('MAX(SUBSTR(code,-4)) count', FALSE)
                ->where('SUBSTR(code,1,' . $j . ')', $ym);
        $query = $CI->db->get($type);
        if ($query->num_rows() > 0)
            $count = $query->row()->count;

        $count = ($count == NULL) ? 1 : $count + 1;
        if ($count < 10) {
            $count = '000' . $count;
        } elseif ($count < 100) {
            $count = '00' . $count;
        } elseif ($count < 1000) {
            $count = '0' . $count;
        }
        return $ym . '/' . $count;
    }

}

if (!function_exists('get_number')) {

    function get_number($string) {
        return str_replace('.', '', $string);
    }

}

if (!function_exists('send_email')) {

    function smtp_send_email($from, $to, $subject, $message) {
        $CI = get_instance();
        $CI->load->library('email');
        $CI->email->initialize(array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.sendgrid.net',
            'smtp_user' => 'rifkysya',
            'smtp_pass' => '121fkysyaripudin',
            'smtp_port' => 587,
            'crlf' => "\r\n",
            'newline' => "\r\n",
            'mailtype' => 'html'
        ));
        $CI->email->from($from);
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);

        $CI->email->send();
    }

}

function settings($key) {
    if ($key) {
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('settings', array('key' => $key));
        if ($query->num_rows() > 0) {
            return $query->row()->value;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function remove_space($string){
    return str_replace(' ', '', $string);
}

/* End of file common_helper.php */
/* Location: ./system/helpers/common_helper.php */
