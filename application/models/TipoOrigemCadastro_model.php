<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TipoOrigemCadastro_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Log_model');
  }

  /**
   * Retorna uma lista de tipos de origem cadastro ordenados pelo nome.
   * 
   * @return array
   */
  public function recebeTiposOrigemCadastros(): array
  {
    $this->db->order_by('nome');
    $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
    $query = $this->db->get('ci_tipo_origem_cadastro');

    return $query->result_array();
  }

  /**
   * Retorna um tipo de origem cadastro específico pelo ID.
   * 
   * @param int $id
   * @return array
   */
  public function recebeTipoOrigemCadastro(?int $id): array
  {
    $this->db->where('id', $id);
    $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
    $query = $this->db->get('ci_tipo_origem_cadastro');

    return $query->row_array() ?? [];
  }

  /**
   * Retorna um tipo de origem cadastro específico pelo nome, excluindo um ID específico.
   * 
   * @param string $nome
   * @param int $id
   * @return array
   */
  public function recebeNomeTipoOrigemCadastro(string $nome, int $id): array
  {
    $this->db->where('nome', $nome);
    $this->db->where('id <>', $id);
    $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
    $query = $this->db->get('ci_tipo_origem_cadastro');

    return $query->row_array() ?? [];
  }

  /**
   * Insere um novo tipo de origem cadastro e registra o log.
   * 
   * @param array $dados
   * @return bool
   */
  public function insereTipoOrigemCadastro(array $dados): bool
  {
    $dados['criado_em'] = date('Y-m-d H:i:s');

    $this->db->insert('ci_tipo_origem_cadastro', $dados);

    if ($this->db->affected_rows() > 0) {
      $this->Log_model->insereLog($this->db->insert_id());
      return true;
    }

    return false;
  }

  /**
   * Edita um tipo de origem cadastro existente e registra o log.
   * 
   * @param int $id
   * @param array $dados
   * @return bool
   */
  public function editaTipoOrigemCadastro(int $id, array $dados): bool
  {
    $dados['editado_em'] = date('Y-m-d H:i:s');

    $this->db->where('id', $id);
    $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
    $this->db->update('ci_tipo_origem_cadastro', $dados);

    if ($this->db->affected_rows() > 0) {
      $this->Log_model->insereLog($id);
      return true;
    }

    return false;
  }

  /**
   * Deleta um tipo de origem cadastro e registra o log.
   * 
   * @param int $id
   * @return bool
   */
  public function deletaTipoOrigemCadastro(int $id): bool
  {
    $this->db->where('id', $id);
    $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
    $this->db->delete('ci_tipo_origem_cadastro');

    if ($this->db->affected_rows() > 0) {
      $this->Log_model->insereLog($id);
      return true;
    }

    return false;
  }
}
