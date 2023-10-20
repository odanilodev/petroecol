<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientes extends CI_Controller
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
        // FIM controle sessão

        $this->load->model('Clientes_model');
    }

    public function index($page = 1)
    {
        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        // scripts para clientes
        $scriptsClienteHead = scriptsClienteHead();
        $scriptsClienteFooter = scriptsClienteFooter();

        add_scripts('header', array_merge($scriptsPadraoHead, $scriptsClienteHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsClienteFooter));

        // >>>> PAGINAÇÃO <<<<<
        $limit = 12; // Número de clientes por página
        $this->load->library('pagination');
        $config['base_url'] = base_url('clientes/index');
        $config['total_rows'] = $this->Clientes_model->recebeClientes($limit, $page, true); // true para contar
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
        $this->pagination->initialize($config);
        // >>>> FIM PAGINAÇÃO <<<<<

        $data['clientes'] = $this->Clientes_model->recebeClientes($limit, $page);

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

        $data['cliente'] = $this->Clientes_model->recebeCliente($id);

        // etiquetas
        $this->load->model('EtiquetaCliente_model');
        $data['etiquetas'] = $this->EtiquetaCliente_model-> recebeEtiquetaCliente($id);

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

        $dataHoraAtual = date('Y-m-d H:i:s');

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

    public function deletaCliente()
    {
        $id = $this->input->post('id');

        $this->Clientes_model->deletaCliente($id);

        $this->Clientes_model->deletaEtiquetaCliente($id);
    }
}
