<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('aprovacaoInativacao')) {
    function aprovacaoInativacao()
    {
        $CI = &get_instance();
        $CI->load->model('Clientes_model');
        $clientesAprovacaoInativacao = $CI->Clientes_model->recebeClientesAprovacaoInativacao();
        return $clientesAprovacaoInativacao;
    }
}
