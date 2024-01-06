<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('emailMaster')) {
    function emailSenhaMaster(): array
    {
        $CI = &get_instance();
        $CI->load->model('Empresas_model');
        
        $dados = $CI->Empresas_model->recebeEmpresaMaster();

        return array(
            'email' => $dados['email'],
            'senha' => $dados['senha']
        );
    }

}

if (!function_exists('nomeMaster')) {
    function nomeMaster(): string
    {
        $CI = &get_instance();
        $CI->load->model('Empresas_model');

        return $CI->Empresas_model->recebeEmpresaMaster()['nome'] ?? '';
    }
}