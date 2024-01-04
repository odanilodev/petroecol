<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('emailMaster')) {
    function emailMaster(): string
    {
        $CI = &get_instance();
        $CI->load->model('Empresas_model');
        
        $dadosMaster = $CI->Empresas_model->recebeEmpresa(1);
        $emailMaster = $dadosMaster['email'];

        return $emailMaster;
    }
}