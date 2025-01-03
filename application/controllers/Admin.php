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
            foreach ($documentos['vencido'] as $doc) {
                $mensagem .= '
                <span class="badge badge-phoenix fs-10 badge-phoenix-danger" style="background: transparent !important; color: #fa3b1d !important">
                    <span class="badge-label">
                        ' . $doc['nome'] . ' - Vencido em: ' . date('d/m/Y', strtotime($doc['validade'])) . '
                    </span>
                </span>';
            }
        }

        // Documentos Vencendo
        if (!empty($documentos['vencendo'])) {
            foreach ($documentos['vencendo'] as $doc) {
                $mensagem .= '
                <span class="badge badge-phoenix fs-10 badge-phoenix-warning" style="background: transparent !important; color: #e5780b !important">
                    <span class="badge-label">
                        ' . $doc['nome'] . ' - Válido até: ' . date('d/m/Y', strtotime($doc['validade'])) . '
                    </span>
                </span>';
            }
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
