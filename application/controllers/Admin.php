<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //INICIO controle sessão
        $this->load->library('Controle_sessao');
        $res = $this->controle_sessao->controle();
        if ($res == 'erro') {
            if ($this->input->is_ajax_request()) {
                $this->output->set_status_header(403);
                exit();
            } else {
                redirect('login/erro', 'refresh');
            }
        }
        // FIM controle sessão
    }

    private function verificaExibicaoAlerta()
    {
        if (!$this->session->userdata('alerta_documentos_exibido')) {
            $this->session->set_userdata('alerta_documentos_exibido', true);
            return true;
        }
        return false;
    }

    public function index()
    {
        $data['mostrar_alerta'] = $this->verificaExibicaoAlerta();

        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        add_scripts('header', $scriptsPadraoHead);
        add_scripts('footer', $scriptsPadraoFooter);

        $this->load->view('admin/includes/painel/cabecalho');
        $this->load->view('admin/paginas/admin', $data);
        $this->load->view('admin/includes/painel/rodape');
    }

    public function recebeDocumentos()
    {
        $this->load->helper('documentos_vencendo_helper');
        $documentos = documentosVencendo();

        if (empty($documentos['vencendo']) && empty($documentos['vencido'])) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false]));
        }

        $mensagem = 'Os seguintes documentos precisam ser atualizados:<br><br>';

        // Documentos Vencidos
        if (!empty($documentos['vencido'])) {
            $mensagem .= '<div class="card mb-2" style="background: #efecec; border-color: #efecec; margin:0; padding:5px;">';
            foreach ($documentos['vencido'] as $doc) {
                $mensagem .= '<p class="mb-1">';
                $mensagem .= $doc['nome'] . ' <br><span style="color:#ee3434 !important;" class="badge badge-phoenix badge-phoenix-danger rounded-pill fs-10 ms-2 mb-1"><span class="badge-label">Vencido em: ' . date('d/m/Y', strtotime($doc['validade'])) . '</span></span>';
                $mensagem .= '</p><hr class="m-0 p-0" style="color: #bbb7b7;">';
            }
            $mensagem .= '</div>';
        }

        // Documentos Vencendo
        if (!empty($documentos['vencendo'])) {
            $mensagem .= '<div class="card" style="background: #efecec; border-color: #efecec; margin:0; padding:5px;">'; 
            foreach ($documentos['vencendo'] as $doc) {
                $mensagem .= '<p class="mb-1">';
                $mensagem .= $doc['nome'] . ' <br><span  class="badge badge-phoenix badge-phoenix-warning rounded-pill fs-10 ms-2 mb-1"><span class="badge-label" style="color: #ffb500;">Válido até: ' . date('d/m/Y', strtotime($doc['validade'])) . '</span></span>';
                $mensagem .= '</p><hr class="m-0 p-0" style="color: #bbb7b7;">';
            }
            $mensagem .= '</div>';
        }

        // Preparando a resposta
        $data = [
            'success' => true,
            'mensagem' => $mensagem,
            'documentos' => $documentos
        ];

        return $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}
