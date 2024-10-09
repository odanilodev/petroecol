<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Certificados_coleta_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function insereCertificado($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        // Gerar código do certificado
        $dados['codigo_certificado'] = $this->gerarCodigoCertificado();

        // Insere o certificado no banco de dados
        $this->db->insert('ci_certificados_coleta', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        // Retorna o código do certificado inserido, caso a inserção tenha sucesso
        if ($this->db->affected_rows() > 0) {
            return $dados['codigo_certificado'];
        }

        return false;
    }

    public function gerarCodigoCertificado()
    {
        // Pegar o último ID de certificado
        $this->db->select_max('id');
        $query = $this->db->get('ci_certificados_coleta');
        $ultimoId = $query->row()->id;

        // Gerar um código único baseado no último ID + timestamp
        $novoCodigo = ($ultimoId + 1) . '-' . time();

        // Verificar se o código já existe
        while ($this->verificaCodigoExistente($novoCodigo)) {
            $novoCodigo = ($ultimoId + 1) . '-' . time();
        }

        return $novoCodigo;
    }

    public function verificaCodigoExistente($codigo)
    {
        $this->db->where('codigo_certificado', $codigo);
        $query = $this->db->get('ci_certificados_coleta');

        return $query->num_rows() > 0;
    }

}
