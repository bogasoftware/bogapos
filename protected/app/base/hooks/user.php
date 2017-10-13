<?php

function get_user() {
    $CI = & get_instance();
    $CI->lang->load('boga', settings('language'));
    $CI->data['user'] = $CI->ion_auth->user()->row();
    $CI->data['logo'] = $CI->main->get('settings', array('key' => 'store_logo'));
}
