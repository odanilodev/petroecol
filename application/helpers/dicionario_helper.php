<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('chave')) {
    function chave(string $chave): string
    {
        $CI = &get_instance();
        $CI->load->model('Dicionario_model');
        $dicionario_global = $CI->Dicionario_model->recebeDicionario($chave ?? '');
        $dicionario_empresa = $CI->Dicionario_model->recebeDicionarioEmpresas($chave ?? '');

        $dicionario = '$chave["' . $chave . '"]';
        if ($dicionario_global) {
            $dicionario = $dicionario_empresa['valor_' . $CI->session->userdata('idioma')] ??
                $dicionario_global['valor_' . $CI->session->userdata('idioma')];
        }

        return $dicionario;
    }
}
