<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('base_url_upload')) {
    function base_url_upload($uri = '')
    {
        $CI =& get_instance();
        $base_url = $CI->config->base_url();
        $custom_base_url = $base_url . 'uploads/' . $CI->session->userdata('id_empresa') . '/';
        return $custom_base_url . ltrim($uri, '/');
    }
}

