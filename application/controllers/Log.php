<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log extends CI_Controller
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

        $this->load->model('Log_model');
    }

    public function index()
    {
        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        add_scripts('header', $scriptsPadraoHead);
        add_scripts('footer', $scriptsPadraoFooter);

        $this->load->model('Usuarios_model');

        $data['usuarios'] = $this->Usuarios_model->recebeTodosUsuarios();

        if ($this->session->userdata('id_empresa') == 1) {

            $this->load->model('Empresas_model');

            $data['empresas'] = $this->Empresas_model->recebeEmpresas();
        }

        if (!empty($_POST)) {

            $filtro['usuario'] = $this->input->post('usuario');
            $filtro['tela'] = $this->input->post('tela');
            $filtro['acao'] = $this->input->post('acao');
            $filtro['data-inicio'] = $this->input->post('data-inicio');
            $filtro['data-fim'] = $this->input->post('data-fim');
            $filtro['empresa'] = $this->input->post('empresa');


            $data['logs'] = $this->Log_model->recebeLogs($filtro);

        }

        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/log/logs');
        $this->load->view('admin/includes/painel/rodape');
    }
}
