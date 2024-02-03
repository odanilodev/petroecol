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
            $this->load->helper('cache_helper');
            limparCache('clientesinativar');
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

    public function recebeIdColetasClientes($id_cliente, $data_inicio, $data_fim)
    {
        $this->db->select('id');
        $this->db->from('ci_coletas');
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('data_coleta >=', $data_inicio);
        $this->db->where('data_coleta <=', $data_fim);
        $this->db->order_by('data_coleta');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeColetasCliente($idCliente)
    {
        $this->db->select('ci_coletas.*, ci_coletas.id as ID_COLETA, ci_funcionarios.nome as nome_responsavel');
        $this->db->from('ci_coletas');
        $this->db->join('ci_funcionarios', 'ci_coletas.id_responsavel = ci_funcionarios.id', 'left');
        $this->db->where('ci_coletas.id_cliente', $idCliente);
        $this->db->where('ci_coletas.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('data_coleta', 'desc');
        $this->db->group_by('ci_coletas.id');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeColetaCliente($idColeta)
    {

        $this->db->select('CO.*, C.*, FU.nome as nome_responsavel');
        $this->db->from('ci_coletas as CO');
        $this->db->join('ci_clientes C', 'CO.id_cliente = C.id', 'left');
        $this->db->join('ci_funcionarios FU', 'CO.id_responsavel = FU.id', 'left');
        $this->db->where('CO.id', $idColeta);

        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();

        return $query->row_array();
    }
    
    public function contaResiduosColetadosMes($mes = null)
    {
        
        $this->db->select('quantidade_coletada');
        $this->db->from('ci_coletas');

        if($mes){
            $this->db->where('MONTH(criado_em)', $mes);
        }

        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
    
        $query = $this->db->get();
        
        return $query->result_array();
    }

}
