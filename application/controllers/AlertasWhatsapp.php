<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class AlertasWhatsapp extends CI_Controller
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
			$this->load->model('AlertasWhatsapp_model');
		}

		public function index()
		{
			// scripts padrão
			$scriptsPadraoHead = scriptsPadraoHead();
			$scriptsPadraoFooter = scriptsPadraoFooter();

			// scripts para Alertas
			$scriptsAlertasWhatsappFooter = scriptsAlertasWhatsappFooter();

			add_scripts('header', array_merge($scriptsPadraoHead));
			add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsAlertasWhatsappFooter));

			$data['alertas'] = $this->AlertasWhatsapp_model->recebeAlertasWhatsapp();

			$this->load->view('admin/includes/painel/cabecalho', $data);
			$this->load->view('admin/paginas/alertas-whatsapp/alertas-whatsapp');
			$this->load->view('admin/includes/painel/rodape');
		}

		public function formulario()
		{
			// scripts padrão
			$scriptsPadraoHead = scriptsPadraoHead();
			$scriptsPadraoFooter = scriptsPadraoFooter();

			// scripts para Alertas
			$scriptsAlertasWhatsappFooter = scriptsAlertasWhatsappFooter();
			$scriptsAlertasWhatsappHead = scriptsAlertasWhatsappHead();

			add_scripts('header', array_merge($scriptsPadraoHead, $scriptsAlertasWhatsappHead));
			add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsAlertasWhatsappFooter));

			$id = $this->uri->segment(3);

			$data['alerta'] = $this->AlertasWhatsapp_model->recebeAlertaWhatsapp($id);

			$this->load->view('admin/includes/painel/cabecalho', $data);
			$this->load->view('admin/paginas/alertas-whatsapp/cadastra-alertas-whatsapp');
			$this->load->view('admin/includes/painel/rodape');
		}

		public function cadastraAlertaWhatsapp()
		{
			$id = $this->input->post('id');

			$dados['titulo'] = trim(mb_convert_case($this->input->post('titulo'), MB_CASE_TITLE, 'UTF-8'));
			$dados['texto_alerta'] = $this->input->post('textoAlerta');
			$dados['id_empresa'] = $this->session->userdata('id_empresa');
			$dados['status'] = $this->input->post('statusAlerta');

			$alerta = $this->AlertasWhatsapp_model->recebeAlertaWhatsappTitulo($dados['titulo']); // verifica se já existe o alerta

			// Verifica se o alerta já existe e se não é o alerta que está sendo editada
			if ($alerta && $alerta['id'] != $id) {

				$response = array(
					'success' => false,
					'message' => "Este alerta já existe! Tente cadastrar um diferente."
				);

				return $this->output->set_content_type('application/json')->set_output(json_encode($response));
			}

			$retorno = $id ? $this->AlertasWhatsapp_model->editaAlertaWhatsapp($id, $dados) : $this->AlertasWhatsapp_model->insereAlertaWhatsapp($dados); // se tiver ID edita se não INSERE

			if ($retorno) { // inseriu ou editou

				$response = array(
					'success' => true,
					'message' => $id ? 'Alerta editado com sucesso!' : 'Alerta cadastrado com sucesso!'
				);
			} else { // erro ao inserir ou editar

				$response = array(
					'success' => false,
					'message' => $id ? "Erro ao editar o Alerta!" : "Erro ao cadastrar o Alerta!"
				);
			}

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}


		public function deletaAlertaWhatsapp()
		{
			$this->load->model('AlertasWhatsapp_model');

			$id = $this->input->post('id');

			$retorno = $this->AlertasWhatsapp_model->deletaAlertaWhatsapp($id);
	
			if ($retorno) {

				$response = array(
					'success' => true,
					'title' => "Sucesso!",
					'message' => "Alerta deletado com sucesso!",
					'type' => "success"
				);

			} else {
						
				$response = array(
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Não foi possivel deletar o alerta!",
					'type' => "error"
				);
			}
		
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));

	}
}