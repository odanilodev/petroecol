<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('dadosEmpresa')) {
    function dadosEmpresa($dados)
    {
        $CI = &get_instance();
        $CI->load->model('Empresas_model');
        
        $resultado = $CI->Empresas_model->recebeDadosMaster($dados);

        return $resultado;
    }
}
