<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DocumentoEmpresa_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    /**
     * Retorna todos os documentos da empresa atual ordenados pelo nome.
     *
     * @return array Lista de documentos da empresa
     */
    public function recebeDocumentosEmpresa()
    {
        $this->db->order_by('nome');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_documento_empresa');

        return $query->result_array();
    }

    /**
     * Retorna um documento específico com base no ID e na empresa atual.
     *
     * @param int $id ID do documento
     * @return array|null Dados do documento encontrado ou NULL se não encontrado
     */
    public function recebeDocumentoEmpresa($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get('ci_documento_empresa');

        return $query->row_array();
    }

    /**
     * Verifica se existe algum documento com o mesmo nome, excluindo o documento atual.
     *
     * @param string $nome Nome do documento a ser verificado
     * @param int $id ID do documento atual (para exclusão)
     * @return array|null Documento encontrado com o mesmo nome ou NULL se não encontrado
     */
    public function recebeDocumentoNome($nome, $id)
    {
        $this->db->where('nome', $nome);
        $this->db->where('id <>', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_documento_empresa');

        return $query->row_array();
    }

    /**
     * Insere um novo documento na base de dados.
     *
     * @param array $dados Dados do documento a serem inseridos
     * @return bool true se o documento foi inserido com sucesso, false caso contrário
     */
    public function insereDocumentoEmpresa($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_documento_empresa', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    /**
     * Retorna o documento antigo com base no nome do documento atual.
     *
     * @param string $documento Nome do documento atual
     * @return array|null Dados do documento antigo encontrado ou NULL se não encontrado
     */
    public function imagemAntiga($documento)
    {
        $this->db->where('documento', $documento);

        if ($this->session->userdata('id_empresa') > 1) {
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        }

        $query = $this->db->get('ci_documento_empresa');

        return $query->row_array();
    }

    /**
     * Edita um documento existente na base de dados.
     *
     * @param int $id ID do documento a ser editado
     * @param array $dados Novos dados do documento
     * @return bool true se o documento foi editado com sucesso, false caso contrário
     */
    public function editaDocumentoEmpresa($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_documento_empresa', $dados);

        return $this->db->affected_rows() > 0;
    }

    /**
     * Deleta um documento da base de dados.
     *
     * @param int $id ID do documento a ser deletado
     * @return bool true se o documento foi deletado com sucesso, false caso contrário
     */
    public function deletaDocumentoEmpresa($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_documento_empresa');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}
