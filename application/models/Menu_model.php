<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }
    
	public function recebeMenus()
    {
        $this->db->order_by('nome', 'DESC');
        $query = $this->db->get('ci_menu');

        return $query->result_array();
    }
	
	public function recebeMenu($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('ci_menu');
		return $query->row_array();
	}

	public function insereMenu($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_menu', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaMenu($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);

        if($this->session->userdata('id_empresa') > 1){
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        }

        $this->db->update('ci_usuarios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaMenu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ci_menu');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}
