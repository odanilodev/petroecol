<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinSaldoBancario_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Log_model');
  }

  public function insereSaldoBancario($id_conta_bancaria, $saldo)
  {
    // Dados a serem inseridos na tabela
    $data = array(
      'id_conta_bancaria' => $id_conta_bancaria,
      'saldo' => $saldo,
      'id_empresa' => $this->session->userdata('id_empresa')
    );

    // Insere os dados na tabela fin_saldo_bancario
    $this->db->insert('fin_saldo_bancario', $data);

    // Retorna o ID gerado pela inserção
    return $this->db->affected_rows() > 0;
  }


  public function recebeSaldoBancario($id)
  {
    $this->db->where('id_conta_bancaria', $id);
    $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
    $query = $this->db->get('fin_saldo_bancario');

    return $query->row_array();
  }
}
