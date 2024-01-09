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

        $data['coletas'] = $this->Coletas_model->recebeColetasCliente($id);

        $data['cliente'] = $this->Clientes_model->recebeCliente($id);

        // verifica se existe cliente
        if (empty($data['cliente'])) {

            redirect('clientes');
        }

        // modelos dos certificados
        $this->load->model('Certificados_model');
        $data['modelos_certificado'] = $this->Certificados_model->recebeCertificados();

        // etiquetas
        $this->load->model('EtiquetaCliente_model');
        $data['etiquetas'] = $this->EtiquetaCliente_model->recebeEtiquetaCliente($id);

        // residuos
        $this->load->model('ResiduoCliente_model');
        $data['residuos'] = $this->ResiduoCliente_model->recebeResiduoCliente($id);

        $this->load->model('ResiduoCliente_model');
        $data['residuosClientes'] = $this->ResiduoCliente_model->recebeResiduosClientes();

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

        add_scripts('header', array_merge($scriptsPadraoHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsClienteFooter));

        $id = $this->uri->segment(3);

        $data['cliente'] = $this->Clientes_model->recebeCliente($id);

        $this->load->model('FrequenciaColeta_model');
        $this->load->model('FormaPagamento_model');
        $this->load->model('ClassificacaoEmpresa_model');

        $data['frequencia'] = $this->FrequenciaColeta_model->recebeFrequenciasColeta();
        $data['formapagamento'] = $this->FormaPagamento_model->recebeFormasPagamento();
        $data['classificacoes'] = $this->ClassificacaoEmpresa_model->recebeClassificacoes();

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

    public function cadastraComodato()
    {
        $this->load->library('upload_imagem');

        $id = $this->input->post('id');

        $cliente = $this->Clientes_model->recebeCliente($id);

        $arrayUpload = [
            'comodato' => ['clientes/comodato', $cliente['comodato'] ?? null],
        ];

        $dados = $this->upload_imagem->uploadImagem($arrayUpload);

        $retorno = $this->Clientes_model->editaCliente($id, $dados);

        if ($retorno) {
            $this->session->set_flashdata('tipo_retorno_funcao', 'success');
            $this->session->set_flashdata('redirect_retorno_funcao', '#');
            $this->session->set_flashdata('titulo_retorno_funcao', 'Cadastrado com sucesso!');
            $this->session->set_flashdata('texto_retorno_funcao', 'Comodato cadastrado com sucesso!');
        } else {

            $this->session->set_flashdata('tipo_retorno_funcao', 'error');
            $this->session->set_flashdata('redirect_retorno_funcao', '#');
            $this->session->set_flashdata('titulo_retorno_funcao', 'Não foi possivel deletar!');
            $this->session->set_flashdata('texto_retorno_funcao', 'O comodato nao pode ser deletado no momento!');
        }

        redirect('clientes/detalhes/' . $id);
    }

    public function  deletaComodato()
    {
        $id = $this->uri->segment(3);

        $nome_arquivo = urldecode($this->uri->segment(4));

        $dados['comodato'] = null;
        $retorno = $this->Clientes_model->editaCliente($id, $dados);

        if ($retorno) {
            $caminho = './uploads/' . $this->session->userdata('id_empresa') . '/' . 'clientes/comodato/' . $nome_arquivo;
            unlink($caminho);
            $deletou = true;
            $this->session->set_flashdata('tipo_retorno_funcao', 'success');
            $this->session->set_flashdata('redirect_retorno_funcao', '#');
            $this->session->set_flashdata('texto_retorno_funcao', 'Deletado com sucesso!');
            $this->session->set_flashdata('titulo_retorno_funcao', 'Sucesso!');
        } else {
            $this->session->set_flashdata('tipo_retorno_funcao', 'error');
            $this->session->set_flashdata('redirect_retorno_funcao', '#');
            $this->session->set_flashdata('texto_retorno_funcao', 'Não foi possivel deletar o comodato!');
            $this->session->set_flashdata('titulo_retorno_funcao', 'Algo deu errado!');
        }

        redirect('clientes/detalhes/' . $id);
    }

    public function insereSql()
    {
        $this->load->view('admin/paginas/clientes/sql-cliente');
    }

    public function enviaAlertaCliente()
    {
        $id_cliente = $this->input->post('id_cliente');
        $id_alerta = $this->input->post('id_alerta');

        $this->load->library('NotificacaoZap');
        $notificacao = new NotificacaoZap();
        $notificacao->enviarTexto($id_cliente,$id_alerta);
        
        $response = array(
            'success' => true,
            'message' => "Alerta enviado com sucesso!"
        );

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function deletaCliente()
    {
        $id = $this->input->post('id');

        $this->Clientes_model->deletaCliente($id);

        $this->Clientes_model->deletaEtiquetaCliente($id);
    }

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
