<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EtiquetaCliente extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// INICIO controle sessão
        $this->load->library('Controle_sessao');
        $res = $this->controle_sessao->controle();
        if($res == 'erro'){ redirect('login/erro', 'refresh');}
        // FIM controle sessão

		$this->load->model('EtiquetaCliente_model');
	}

	public function index()
	{
		$scriptsHead = scriptsUsuarioHead();
		add_scripts('header', $scriptsHead);

		$scriptsFooter = scriptsUsuarioFooter();
		add_scripts('footer', $scriptsFooter);

		$data['etiquetasClientes'] = $this->EtiquetaCliente_model->recebeEtiquetasClientes();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/etiquetas_clientes/etiquetas-clientes');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		$scriptsHead = scriptsUsuarioHead();
		add_scripts('header', $scriptsHead);

		$scriptsFooter = scriptsUsuarioFooter();
		add_scripts('footer', $scriptsFooter);

		$this->load->model('EtiquetaCliente_model');

		$id = $this->uri->segment(3);

		$data['etiquetaCliente'] = $this->EtiquetaCliente_model->recebeEtiquetaCliente($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/etiquetas_clientes/cadastra-etiqueta-cliente');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraEtiquetaCliente()
	{
		$id = $this->input->post('id');

		$dados['id_cliente'] = $this->input->post('id_cliente');
		$dados['id_etiqueta'] = $this->input->post('id_etiqueta');

		$retorno = $id ? $this->EtiquetaCliente_model->editaEtiquetaCliente($id, $dados) : $this->EtiquetaCliente_model->insereEtiquetaCliente($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Vinculo de etiqueta editado com sucesso!' : 'Vinculo de etiqueta cadastrado com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar vinculo de etiqueta!" : "Erro ao cadastrar vinculo de etiqueta!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaEtiquetaCliente()
	{
		$id = $this->input->post('id');

		$this->EtiquetaCliente_model->deletaEtiquetaCliente($id);

		redirect('etiquetas-clientes');
	}
}
