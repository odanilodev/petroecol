<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientes extends CI_Controller
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
        $scriptsClienteHead = scriptsClienteHead();
        $scriptsClienteFooter = scriptsClienteFooter();

        add_scripts('header', array_merge($scriptsPadraoHead, $scriptsClienteHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsClienteFooter));

        $this->load->helper('cookie');

        if ($this->input->post()) {
            $this->input->set_cookie('filtro_clientes', json_encode($this->input->post()), 3600);
        }

        if (is_numeric($page)) {
            $cookie_filtro_clientes = count($this->input->post()) > 0 ? json_encode($this->input->post()) : $this->input->cookie('filtro_clientes');
        } else {
            $page = 1;
            delete_cookie('filtro_clientes');
            $cookie_filtro_clientes = json_encode([]);
        }

        $data['cookie_filtro_clientes'] = json_decode($cookie_filtro_clientes, true);

        // >>>> PAGINAÇÃO <<<<<
        $limit = 12; // Número de clientes por página
        $this->load->library('pagination');
        $config['base_url'] = base_url('clientes/index');
        $config['total_rows'] = $this->Clientes_model->recebeClientes($cookie_filtro_clientes, $limit, $page, true); // true para contar
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
        $this->pagination->initialize($config);
        // >>>> FIM PAGINAÇÃO <<<<<

        //clientes
        $data['clientes'] = $this->Clientes_model->recebeClientes($cookie_filtro_clientes, $limit, $page);

        // cidades
        $data['cidades'] = $this->Clientes_model->recebeCidadesCliente();

        // etiquetas 
        $this->load->model('Etiquetas_model');
        $data['etiquetas'] = $this->Etiquetas_model->recebeEtiquetas();

        $this->load->model('EtiquetaCliente_model');
        $data['etiquetasClientes'] = $this->EtiquetaCliente_model->recebeEtiquetasClientes();

        // residuos
        $this->load->model('Residuos_model');
        $data['residuos'] = $this->Residuos_model->recebeTodosResiduos();

        $this->load->model('ResiduoCliente_model');
        $data['residuosClientes'] = $this->ResiduoCliente_model->recebeResiduosClientes();

        // recipientes
        $this->load->model('Recipientes_model');
        $data['recipientes'] = $this->Recipientes_model->recebeTodosRecipientes();

        $this->load->model('RecipienteCliente_model');
        $data['recipientesClientes'] = $this->RecipienteCliente_model->recebeRecipientesClientes();

        // formas de pagamento
        $this->load->model('FormaPagamento_model');
        $data['formasPagamento'] = $this->FormaPagamento_model->recebeFormasPagamento();
        
        // grupos
        $this->load->model('Grupos_model');
        $data['grupos'] = $this->Grupos_model->recebeGrupos();

        $this->load->model('GrupoCliente_model');
        $data['grupoClientes'] = $this->GrupoCliente_model->recebeGrupoClientes();


        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/clientes/clientes');
        $this->load->view('admin/paginas/clientes/modals');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function detalhes()
    {
        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        // scripts para clientes
        $scriptsClienteHead = scriptsClienteHead();
        $scriptsClienteFooter = scriptsClienteFooter();

        add_scripts('header', array_merge($scriptsPadraoHead, $scriptsClienteHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsClienteFooter));

        $id = $this->uri->segment(3);

        $this->load->model('Coletas_model');
        $this->load->model('ComodatoCliente_model');


        $data['coletas'] = $this->Coletas_model->recebeColetasCliente($id);

        $data['cliente'] = $this->Clientes_model->recebeCliente($id);

        $data['comodatos'] = $this->ComodatoCliente_model->recebeComodatosCliente($id);

        // verifica se existe cliente
        if (empty($data['cliente'])) {

            redirect('clientes');
        }

        // modelos dos certificados
        $this->load->model('Certificados_model');
        $data['modelos_certificado'] = $this->Certificados_model->recebeCertificados();

        // etiquetas do cliente
        $this->load->model('EtiquetaCliente_model');
        $data['etiquetas_cliente'] = $this->EtiquetaCliente_model->recebeEtiquetaCliente($id);

        // todos residuos
        $this->load->model('Residuos_model');
        $data['residuos'] = $this->Residuos_model->recebeTodosResiduos();

        // todos recipientes
        $this->load->model('Recipientes_model');
        $data['recipientes'] = $this->Recipientes_model->recebeTodosRecipientes();

        // todas etiquetas 
        $this->load->model('Etiquetas_model');
        $data['etiquetas'] = $this->Etiquetas_model->recebeEtiquetas();
        
        // grupos
        $this->load->model('Grupos_model');
        $data['grupos'] = $this->Grupos_model->recebeGrupos();

        $this->load->model('GrupoCliente_model');
        $data['grupoClientes'] = $this->GrupoCliente_model->recebeGrupoClientes();

        // todos alertas ou alertas ativos (status)
        $statusAlerta = true;
        $this->load->model('AlertasWhatsapp_model');
        $data['alertas'] = $this->AlertasWhatsapp_model->recebeAlertasWhatsApp($statusAlerta);


        $this->load->model('Agendamentos_model');
        $data['quantidade_agendado'] = $this->Agendamentos_model->contaAgendamentoCLiente($id);

        $data['quantidade_atrasado'] = $this->Agendamentos_model->contaAgendamentoAtrasadoCLiente($id);

        $data['quantidade_finalizado'] = $this->Agendamentos_model->contaAgendamentoFinalizadoCLiente($id);

        $this->load->helper('formatar');

        $data['ultima_coleta'] = formatarData($this->Agendamentos_model->ultimaColetaCLiente($id));

        // formas de pagamento
        $this->load->model('FormaPagamento_model');
        $data['formasPagamento'] = $this->FormaPagamento_model->recebeFormasPagamento();

        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/clientes/detalhes-cliente');
        $this->load->view('admin/paginas/clientes/modals');
        $this->load->view('admin/includes/painel/rodape');
    }


    public function formulario()
    {
        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        // scripts para clientes
        $scriptsClienteFooter = scriptsClienteFooter();
        $scriptsClienteHead = scriptsClienteHead();

        add_scripts('header', array_merge($scriptsClienteHead, $scriptsPadraoHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsClienteFooter));

        $id = $this->uri->segment(3);

        $data['cliente'] = $this->Clientes_model->recebeCliente($id);

        $this->load->model('FrequenciaColeta_model');
        $this->load->model('FormaPagamento_model');
        $this->load->model('ClassificacaoCliente_model');

        $data['frequencia'] = $this->FrequenciaColeta_model->recebeFrequenciasColeta();
        $data['formapagamento'] = $this->FormaPagamento_model->recebeFormasPagamento();
        $data['classificacoes'] = $this->ClassificacaoCliente_model->recebeClassificacoes();

        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/clientes/cadastra-cliente');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function cadastraCliente()
    {
        $dadosEmpresa = $this->input->post('dadosEmpresa');
        $dadosEndereco = $this->input->post('dadosEndereco');
        $dadosResponsavel = $this->input->post('dadosResponsavel');
        $id = $this->input->post('id');

        // Coloca os arrays em uma única variável
        $dados = array_merge($dadosEmpresa, $dadosEndereco, $dadosResponsavel);

        $dados['id_empresa'] = $this->session->userdata('id_empresa');

        $retorno = $id ? $this->Clientes_model->editaCliente($id, $dados) : $this->Clientes_model->insereCliente($dados); // se tiver ID edita se não INSERE

        if ($retorno) { // inseriu ou editou

            $response = array(
                'success' => true,
                'message' => $id ? 'Cliente editado com sucesso!' : 'Cliente cadastrado com sucesso!'
            );
        } else { // erro ao inserir ou editar

            $response = array(
                'success' => false,
                'message' => $id ? "Erro ao editar o cliente!" : "Erro ao cadastrar o cliente!"
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function insereSql()
    {
        $this->load->view('admin/paginas/clientes/sql-cliente');
    }

    public function enviaAlertaCliente()
    {
        $id_cliente = $this->input->post('id_cliente');
        $mensagem = $this->input->post('mensagem');

        $this->load->library('NotificacaoZap');
        $notificacao = new NotificacaoZap();
        $retorno = $notificacao->enviarTexto($id_cliente, $mensagem);

        $response = array(
            'success' => false,
            'message' => $retorno
        );

        if ($retorno === 'true') {
            $response = array(
                'success' => true,
                'message' => 'Mensagem enviada com sucesso'
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function deletaCliente()
    {
        $id = $this->input->post('id');

        $this->Clientes_model->deletaCliente($id);

        $this->Clientes_model->deletaEtiquetaCliente($id);
    }

    // Verifica se o recipiente está vinculado a um cliente
    public function verificaRecipienteCliente()
    {
        $id = $this->input->post('id');
        $recipienteCliente = $this->Clientes_model->verificaRecipienteCliente($id);

        if (!$recipienteCliente) {

            $response = array(
                'success' => true
            );
        } else {

            $response = array(
                'success' => false,
                'message' => "Parece que não podemos excluir este cliente, pois há recipientes associados a ele. Por favor, solicite a coleta ou justifique uma perda de recipiente."
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function alteraStatusCliente()
    {
        $id = $this->input->post('id');
        $dados['status'] = $this->input->post('status');

        $retorno = $this->Clientes_model->editaCliente($id, $dados);

        if ($retorno) { // alterou status

            $response = array(
                'success' => true,
                'message' => 'Status alterado com sucesso!',
                'type' => "success",
                'title' => "Sucesso!"
            );
        } else { // erro ao deletar

            $response = array(
                'success' => false,
                'message' => 'Erro ao alterar status',
                'type' => "error",
                'title' => "Algo deu errado!"
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}
