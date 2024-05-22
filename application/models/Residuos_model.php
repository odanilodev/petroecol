<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Residuos_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeResiduos($limit, $page, $count = null)
    {
        if ($count) {
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
            $query = $this->db->get('ci_residuos');
            return $query->num_rows();
        }

        $offset = ($page - 1) * $limit;
        $this->db->select('R.*, GR.nome_grupo, SE.nome as SETOR');
        $this->db->from('ci_residuos R');
        $this->db->join('ci_grupo_residuos GR', 'R.id_grupo = GR.id', 'inner');
        $this->db->join('ci_setores_empresa SE', 'R.id_setor_empresa = SE.id', 'inner');
        $this->db->order_by('R.nome', 'ASC');
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeTodosResiduos()
    {
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('nome', 'ASC'); 
        $query = $this->db->get('ci_residuos');
    
        return $query->result_array();
    }
    
    public function recebeResiduo($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_residuos');

        return $query->row_array();
    }
    public function recebeResiduoSetor($idSetor)
    {
        $this->db->where('id_setor_empresa', $idSetor);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_residuos');

        return $query->result_array();
    }

    public function recebeResiduoNome($nome,$id)
    {
        $this->db->where('nome', $nome);
        $this->db->where('id <>', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_residuos');

        return $query->row_array();
    }

    public function recebeGruposResiduo()
    {
        $query = $this->db->get('ci_grupo_residuos');

        return $query->result_array();
    }

    public function insereResiduo($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_residuos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaResiduo($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_residuos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaResiduo($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_residuos');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function verificaResiduoCliente($id)
    {
        $this->db->where('id_residuo', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->get('ci_residuo_cliente');

        return $this->db->affected_rows() > 0;
    }

}
