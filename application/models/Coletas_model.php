<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coletas_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function insereColeta($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_coletas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeColetas()
    {
        $this->db->order_by('data_coleta', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        
        $query = $this->db->get('ci_coletas');

        return $query->result_array();
    }

    public function recebeColeta($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get('ci_coletas');

        return $query->row_array();
    }

    public function recebeColetasCliente($idCliente)
    {
        $this->db->select('ci_coletas.*, ci_funcionarios.nome as nome_motorista');
        $this->db->from('ci_coletas');
        $this->db->join('ci_funcionarios', 'ci_coletas.id_motorista = ci_funcionarios.id', 'left');
        $this->db->where('ci_coletas.id_cliente', $idCliente);
        $this->db->where('ci_coletas.id_empresa', $this->session->userdata('id_empresa'));
    
        $query = $this->db->get();
    
        return $query->result_array();
    }
    

    
}