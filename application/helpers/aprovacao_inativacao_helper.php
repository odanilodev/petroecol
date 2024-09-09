<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('aprovacaoInativacao')) {
    function aprovacaoInativacao($limitarRegistros = true)
    {
        $CI = &get_instance();
        $CI->load->model('Clientes_model');

        $clientesAprovacaoInativacao = $CI->Clientes_model->recebeClientesAprovacaoInativacao($limitarRegistros);
        return $clientesAprovacaoInativacao;
    }
}
