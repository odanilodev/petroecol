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
        $query = $this->db->query("
            SELECT *, CASE WHEN `ordem` = 0 THEN 1 ELSE 0 END AS is_zero
            FROM `ci_menu`
            ORDER BY `sub` ASC, is_zero ASC, `ordem` ASC, `id` ASC
        ");
        $menus = $query->result_array();

        // Organize os menus em um array hierárquico
        $menuHierarquia = [];
        foreach ($menus as $menu) {
            $menu['sub_menus'] = [];
            if ($menu['sub'] == 0) {
                $menuHierarquia[$menu['id']] = $menu;
            } else {
                $menuHierarquia[$menu['sub']]['sub_menus'][$menu['id']] = $menu;
            }
        }

        // Ordene os menus em ordem crescente de acordo com a ordem 'ordem'
        foreach ($menuHierarquia as &$menuPai) {
            ksort($menuPai['sub_menus']);
        }

        return array_values($menuHierarquia);
    }

    public function recebeCategoriasPai()
    {
        $this->db->where('link', null);
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
        $this->db->update('ci_menu', $dados);

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

    public function deletaSubMenus($idPai)
    {
        $this->db->where('sub', $idPai);
        $this->db->delete('ci_menu');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($idPai);
        }

        return $this->db->affected_rows() > 0;
    }
}
