<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClientesSemAtividade extends CI_Controller
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
        $this->load->model('Clientes_model');
    }

    public function index($page = 1)
    {
        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        // Scripts para clientes
        $scriptsClientesSemAtividadeHead = scriptsClientesSemAtividadeHead();
        $scriptsClientesSemAtividadeFooter = scriptsClientesSemAtividadeFooter();

        add_scripts('header', array_merge($scriptsPadraoHead, $scriptsClientesSemAtividadeHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsClientesSemAtividadeFooter));

        $this->load->helper('cookie');
        $this->load->model('Funcionarios_model');
        $this->load->model('Veiculos_model');
        $this->load->model('Etiquetas_model');

        if ($this->input->post()) {
            $this->input->set_cookie('filtro_clientes_sem_atividade', json_encode($this->input->post()), 3600);
        }

        if (is_numeric($page)) {
            $cookie_filtro_clientes_sem_atividade = count($this->input->post()) > 0 ? json_encode($this->input->post()) : $this->input->cookie('filtro_clientes_sem_atividade');
        } else {
            $page = 1;
            delete_cookie('filtro_clientes_sem_atividade');
            $cookie_filtro_clientes_sem_atividade = json_encode([]);
        }

        $data['cookie_filtro_clientes_sem_atividade'] = json_decode($cookie_filtro_clientes_sem_atividade, true);

        // >>>> PAGINAÇÃO <<<<<
        $limit = 12; // Número de clientes por página
        $this->load->library('pagination');
        $config['base_url'] = base_url('clientesSemAtividade/index');
        $config['total_rows'] = $this->Clientes_model->recebeClientesSemAtividades($cookie_filtro_clientes_sem_atividade, $limit, $page, true); // true para contar
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
        $this->pagination->initialize($config);
        // >>>> FIM PAGINAÇÃO <<<<<

        //clientes
        $cidadeFiltro = $this->input->post('cidadeFiltro');
        $data['clientes'] = $this->Clientes_model->recebeClientesSemAtividades($cookie_filtro_clientes_sem_atividade, $limit, $page);

        $data['dataInicio'] = $this->input->post('data_inicio');
        $data['dataFim'] = $this->input->post('data_fim');
        $data['idSetor'] = $this->input->post('setor');
        $data['cidadeFiltro'] = $cidadeFiltro;
        $data['etiquetaFiltro'] = $this->input->post('etiquetaFiltro');

        // Carrega os setores da empresa
        $this->load->model('SetoresEmpresa_model');
        $data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

        // cidades
        $data['cidades'] = $this->Clientes_model->recebeCidadesClientesSemAtividades();

        $data['responsaveis'] = $this->Funcionarios_model->recebeResponsavelAgendamento();
        $data['veiculos'] = $this->Veiculos_model->recebeVeiculos();

        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/clientes/sem-atividades');
        $this->load->view('admin/includes/painel/rodape');
    }
}
