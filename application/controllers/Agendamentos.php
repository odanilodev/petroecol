<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Agendamentos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // INICIO controle sessão
         $this->load->library('Controle_sessao');
         $res = $this->controle_sessao->controle();
         if ($res == 'erro') {
             redirect('login/erro', 'refresh');
         }
         //FIM controle sessão

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

        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/agendamentos/agendamentos');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function cadastraAgendamento()
    {
        $dados['id_cliente'] = $this->input->post('cliente');
        $dados['data_coleta'] = $this->input->post('data');
        $dados['hora_coleta'] = $this->input->post('horario');
        $dados['observacao'] = $this->input->post('obs');
        $dados['id_empresa'] = $this->session->userdata('id_empresa');
        $id = $this->input->post('id');

        $clienteAgendado = $this->Agendamentos_model->recebeClienteAgendado($dados['id_cliente'], $dados['data_coleta']);

        if (
            in_array($dados['id_cliente'], array_column($clienteAgendado, 'id_cliente')) &&
            in_array($dados['data_coleta'], array_column($clienteAgendado, 'data_coleta')) && !$id
        ) {

            $response = array(
                'success' => false,
                'message' => 'Este cliente já está agendado para este dia.'
            );

            return $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }

        $retorno = $id ? $this->Agendamentos_model->editaAgendamento($id, $dados) : $this->Agendamentos_model->insereAgendamento($dados); // se tiver ID edita se não INSERE

        if ($retorno) { // inseriu ou editou

            $response = array(
                'success' => true
            );
        } else { // erro ao inserir ou editar

            $response = array(
                'success' => false
            );
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
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function recebeClientesAgendados()
    {
        $dataColeta = $this->input->post('dataColeta');

        $clientesAgendados = $this->Agendamentos_model->recebeClientesAgendados($dataColeta);
        echo json_encode($clientesAgendados);
    }

    public function cancelaAgendamentoCliente()
    {
        $idAgendamento = $this->input->post('idAgendamento');

        $this->Agendamentos_model->cancelaAgendamentoCliente($idAgendamento);
    }
}