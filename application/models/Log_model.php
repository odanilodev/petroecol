<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log_model extends CI_Model
{

    public function insereLog($id)
    {
        $dados['id_empresa'] = $this->session->userdata('id_empresa');
        $dados['id_usuario'] = $this->session->userdata('id_usuario');
        $dados['item']       = $id;
        $dados['classe']     = debug_backtrace()[1]['class'];
        $dados['metodo']     = debug_backtrace()[1]['function'];
        $dados['criado_em']  = date('Y-m-d H:i:s');
        $this->db->insert('ci_log', $dados);
    }

    public function insereLogSenha($id, $id_empresa)
    {
        $dados['id_empresa'] = $id_empresa;
        $dados['id_usuario'] = $id;
        $dados['item']       = $id;
        $dados['classe']     = debug_backtrace()[1]['class'];
        $dados['metodo']     = debug_backtrace()[1]['function'];
        $dados['criado_em']  = date('Y-m-d H:i:s');
        $this->db->insert('ci_log', $dados);
    }
}
