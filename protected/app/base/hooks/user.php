<?php

function get_user() {
    $CI = & get_instance();
    $CI->lang->load('boga', settings('language'));
    $CI->data['user'] = $CI->ion_auth->user()->row();
    if ($CI->ion_auth->logged_in()) {
        if ($CI->data['user']->store == 0) {
            $CI->data['stores'] = $CI->main->gets('stores');
        } else {
            $CI->data['stores'] = $CI->main->gets('stores', array('id' => $CI->data['user']->store));
        }
    }
}
