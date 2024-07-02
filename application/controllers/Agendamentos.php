<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Agendamentos extends CI_Controller
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

        $this->load->model('Agendamentos_model');
    }

    public function index()
    {
        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        // scripts para agendamento
        $scriptsAgendamentoHead = scriptsAgendamentoHead();
        $scriptsAgendamentoFooter = scriptsAgendamentoFooter();

        add_scripts('header', array_merge($scriptsPadraoHead, $scriptsAgendamentoHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsAgendamentoFooter));

        $this->load->model('Clientes_model');
        $data['clientes'] = $this->Clientes_model->recebeTodosClientes();

        $this->load->model('EtiquetaCliente_model');
        $data['etiquetas'] = $this->EtiquetaCliente_model->recebeTodasEtiquetasClientes();

        $this->load->model('SetoresEmpresaCliente_model');
        $data['setores'] = $this->SetoresEmpresaCliente_model->recebeSetoresEmpresaClientes();

        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/agendamentos/agendamentos');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function agendamentosAtrasados()
    {
        $this->load->model('Funcionarios_model');
        $this->load->model('Veiculos_model');

        // Carrega scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        // Carrega scripts específicos para agendamento
        $scriptsAgendamentoHead = scriptsAgendamentoHead();
        $scriptsAgendamentoFooter = scriptsAgendamentoFooter();

        // Adiciona scripts ao cabeçalho e rodapé
        add_scripts('header', array_merge($scriptsPadraoHead, $scriptsAgendamentoHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsAgendamentoFooter));

        // Define as datas padrão caso não sejam recebidas via POST
        $dataInicio = new DateTime();
        $dataInicio->modify('-31 days'); // Modifica para 31 dias atrás para incluir ontem
        $dataInicioFormatada = $dataInicio->format('Y-m-d');

        $dataFim = new DateTime();
        $dataFim->modify('-1 days'); // Modifica para 1 dia atrás para incluir até ontem
        $dataFimFormatada = $dataFim->format('Y-m-d');

        // Verifica se as datas foram recebidas via POST
        if ($this->input->post('data_inicio') && $this->input->post('data_fim')) {
            // Recebe as datas do POST
            $dataInicioFormatada = $this->input->post('data_inicio');
            $dataFimFormatada = $this->input->post('data_fim');

            // Converte as datas para o formato americano (Y-m-d)
            $dataInicioFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataInicioFormatada)));
            $dataFimFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataFimFormatada)));
        }

        // Prepara os dados para a view
        $data['dataInicio'] = $this->input->post('data_inicio');
        $data['dataFim'] = $this->input->post('data_fim');
        $data['idSetor'] = $this->input->post('setor');
        $data['responsaveis'] = $this->Funcionarios_model->recebeResponsavelAgendamento();
        $data['veiculos'] = $this->Veiculos_model->recebeVeiculos();

        // Carrega os setores da empresa
        $this->load->model('SetoresEmpresa_model');
        $data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

        // Carrega os agendamentos atrasados com base nos parâmetros
        $data['agendamentosAtrasados'] = $this->Agendamentos_model->recebeAgendamentosAtrasados($dataInicioFormatada, $dataFimFormatada, $data['idSetor']);

        // Carrega as views
        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/agendamentos/agendamentos-atrasados');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function cadastraAgendamento()
    {
        $clientes = $this->input->post('cliente');
        $idsClientes = explode(',', $clientes);

        $dados['data_coleta'] = $this->input->post('data');
        $dados['hora_coleta'] = $this->input->post('horario');
        $dados['periodo_coleta'] = $this->input->post('periodo');
        $dados['observacao'] = $this->input->post('obs');
        $dados['prioridade'] = $this->input->post('prioridade');
        $dados['id_setor_empresa'] = $this->input->post('setorEmpresa');
        $dados['id_empresa'] = $this->session->userdata('id_empresa');
        $id = $this->input->post('id');

        $response = array('success' => true);

        for ($i = 0; $i < count($idsClientes); $i++) {

            // verifica se já existe o cliente agendado nessa data
            $clienteAgendado = $this->Agendamentos_model->recebeClienteAgendado($idsClientes[$i], $dados['data_coleta'], $dados['id_setor_empresa']);

            if (!$clienteAgendado) {

                // Se o cliente não está agendado, realiza a inserção ou edição
                $dados['id_cliente'] = $idsClientes[$i];
                $retorno = $id ? $this->Agendamentos_model->editaAgendamento($id, $dados) : $this->Agendamentos_model->insereAgendamento($dados);

                if (!$retorno) {
                    $response = array(
                        'success' => false,
                        'message' => 'Erro ao inserir ou editar agendamento para o cliente:'
                    );
                    break; // para o loop se der erro
                }
            } else if ($clienteAgendado['id'] == $id) {

                $retorno = $id ? $this->Agendamentos_model->editaAgendamento($id, $dados) : $this->Agendamentos_model->insereAgendamento($dados);

                if (!$retorno) {
                    $response = array(
                        'success' => false,
                        'message' => 'Erro ao inserir ou editar agendamento para o cliente:'
                    );
                    break; // para o loop se der erro
                }
            } else {

                // Se o cliente já está agendado, atualiza a mensagem de erro
                $response = array(
                    'success' => false,
                    'message' => 'Este cliente já está agendado para este dia.'
                );
            }
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }



    public function exibirAgendamentos()
    {
        $anoAtual = $this->input->post('anoAtual');
        $mesAtual = $this->input->post('mesAtual');

        $agendamentos = $this->Agendamentos_model->recebeAgendamentos($anoAtual, $mesAtual);

        $data = array(
            'agendamentos' => $agendamentos
        );

        // Responda com os dados em formato JSON
        return $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function recebeClientesAgendados()
    {
        $dataColeta = $this->input->post('dataColeta');
        $prioridade = $this->input->post('prioridade');
        $status = $this->input->post('status');

        $clientesAgendados = $this->Agendamentos_model->recebeClientesAgendados($dataColeta, $prioridade, $status);

        $data = array(
            'agendados' => $clientesAgendados
        );

        // Responda com os dados em formato JSON
        return $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function cancelaAgendamentoCliente()
    {
        $idAgendamento = $this->input->post('idAgendamento');

        $this->Agendamentos_model->cancelaAgendamentoCliente($idAgendamento);
    }
}
