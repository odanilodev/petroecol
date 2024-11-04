<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
        $this->load->model('Dashboard_model');
        $this->load->model('Coletas_model');
        $this->load->model('Agendamentos_model');
    }

    public function index()
    {
        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        // scripts dashboard
        $scriptsDashboardHead = scriptsDashboardHead();
        $scriptsDashboardFooter = scriptsDashboardFooter();

        add_scripts('header', array_merge($scriptsPadraoHead, $scriptsDashboardHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsDashboardFooter));

        // ====================================================        

        // Define as datas padrão caso não sejam recebidas via POST
        $dataInicio = new DateTime();
        $dataInicio->modify('-31 days'); // Modifica para 31 dias atrás para incluir ontem
        $dataInicioFormatada = $dataInicio->format('Y-m-d');

        $dataFim = new DateTime();
        $dataFim->modify('-1 days'); // Modifica para 1 dia atrás para incluir até ontem
        $dataFimFormatada = $dataFim->format('Y-m-d');

        $agendamentosAtrasados = $this->Agendamentos_model->recebeAgendamentosAtrasados($dataInicioFormatada, $dataFimFormatada, null, null, null);

        $data['agendamentosAtrasados'] = count($agendamentosAtrasados);

        // ====================================================

        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/dashboard');
        $this->load->view('admin/includes/painel/rodape');
    }
}
