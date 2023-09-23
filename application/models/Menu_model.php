<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
	public function recebeMenu($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('ci_menu');
		return $query->row_array();
	}
}
