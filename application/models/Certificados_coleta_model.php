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

        // Incrementar o ID
        $novoId = $ultimoId + 1;

        // Formatar o ID com zeros à esquerda (6 dígitos)
        $idFormatado = str_pad($novoId, 6, '0', STR_PAD_LEFT);

        // Obter o ano atual
        $anoAtual = date('Y');

        // Gerar o código no formato "ANO-ID"
        $novoCodigo = $anoAtual . '/' . $idFormatado;

        // Verificar se o código já existe
        while ($this->verificaCodigoExistente($novoCodigo)) {
            $novoId++;
            $idFormatado = str_pad($novoId, 6, '0', STR_PAD_LEFT);
            $novoCodigo = $anoAtual . '-' . $idFormatado;
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
