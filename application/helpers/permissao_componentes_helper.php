<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('permissaoComponentes')) {
    function permissaoComponentes(string $componente): bool
    {
        $CI = &get_instance();
        $CI->load->model('Permissao_model');
        $clientesPermissao = $CI->Permissao_model->recebeClientesPermissao($componente);
        $usuarios = json_decode($clientesPermissao['usuarios'], true);
        $permissao = false;
        
        if ($usuarios) {
            foreach ($usuarios as $v) {
                if ($v == $CI->session->userdata('id_usuario') || $v === '*') {
                    $permissao = true;
                }
            }
        }

        return $permissao;
    }
}
