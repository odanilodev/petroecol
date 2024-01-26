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

    public function recebeLogs($filtro)
    {
        $this->db->select('L.*, U.nome');
        $this->db->from('ci_log as L');
        $this->db->join('ci_usuarios U', 'L.id_usuario = U.id', 'left');
        $this->db->like('L.classe', $filtro['tela']);
        $this->db->like('L.metodo', $filtro['acao']);

        if ($filtro['usuario']) {

            $this->db->where('L.id_usuario', $filtro['usuario']);
        }

        if ($filtro['data-inicio']) {
            $filtro['data-inicio'] .= ' 00:00:00'; // Início do dia
            $this->db->where('L.criado_em >=', $filtro['data-inicio']);
        }

        if ($filtro['data-fim']) {
            $filtro['data-fim'] .= ' 23:59:59'; // Final do dia
            $this->db->where('L.criado_em <=', $filtro['data-fim']);
        }

        $this->db->order_by('L.criado_em', 'desc');

        $query = $this->db->get();

        return $query->result_array();
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
