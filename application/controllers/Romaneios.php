<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Romaneios extends CI_Controller
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

		$this->load->model('Etiquetas_model');
		$this->load->model('EtiquetaCliente_model');
		$this->load->model('Clientes_model');
		$this->load->model('Romaneios_model');
		$this->load->library('gerarRomaneio');
		$this->load->model('Funcionarios_model');
		date_default_timezone_set('America/Sao_Paulo');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts romaneio
		$scriptsRomaneioHead = scriptsRomaneioHead();
		$scriptsRomaneioFooter = scriptsRomaneioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsRomaneioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsRomaneioFooter));

		$data['ultimosRomaneios'] = $this->Romaneios_model->recebeUltimosRomaneios();

		$data['responsaveis'] = $this->Funcionarios_model->recebeResponsavelAgendamento();


		$this->load->model('FinTiposCustos_model');
		$data['tiposCustos'] = $this->FinTiposCustos_model->recebeTiposCustos();

		$this->load->model('FinMacro_model');
		$data['macros'] = $this->FinMacro_model->recebeMacros();

		$this->load->model('FinFormaTransacao_model');
		$this->load->model('FinContaBancaria_model');

		$data['formasTransacao'] = $this->FinFormaTransacao_model->recebeFormasTransacao();
		$data['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();

		$this->load->model('FinDadosFinanceiros_model');
		$data['dadosFinanceiro'] = $this->FinDadosFinanceiros_model->recebeDadosFinanceiros();

		$this->load->model('FinGrupos_model');
		$data['grupos'] = $this->FinGrupos_model->recebeGrupos();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/romaneio/romaneios');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function recebeRomaneioPorData()
	{
		$dataRomaneio = $this->input->post('dataRomaneio');
		$romaneios = $this->Romaneios_model->recebeRomaneioPorData($dataRomaneio);

		$response = array(
			'romaneios' => $romaneios,
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function detalhes()
	{

		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts romaneio
		$scriptsRomaneioHead = scriptsRomaneioHead();
		$scriptsRomaneioFooter = scriptsRomaneioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsRomaneioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsRomaneioFooter));

		$this->load->library('formasPagamentoChaveId');
		$this->load->library('residuoChaveId');

		$codRomaneio = $this->uri->segment(3);

		$this->load->model('Coletas_model');

		// todos residuos cadastrado na empresa
		$data['residuos'] = $this->residuochaveid->residuoArrayChaveId();

		// todas formas de pagamento cadastrado na empresa
		$data['formasPagamento'] = $this->formaspagamentochaveid->formaPagamentoArrayChaveId();
		$data['formasTransacao'] = $this->formaspagamentochaveid->formaTransacaoArrayChaveId();

		$data['romaneio'] = $this->Coletas_model->recebeColetaRomaneio($codRomaneio);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/romaneio/detalhes-romaneio');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function gerarRomaneio()
	{
		$codigo = time();

		// dados para gravar no banco
		$dados['id_responsavel'] = $this->input->post('responsavel');
		$dados['id_veiculo'] = $this->input->post('veiculo');
		$dados['data_romaneio'] = $this->input->post('data_coleta');
		$dados['clientes'] = json_encode($this->input->post('clientes')); // Recebe um array e depois passa os dados por JSON
		$dados['id_setor_empresa'] = $this->input->post('setorEmpresa');
		$dados['codigo'] = $codigo;
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$insereRomaneio = $this->Romaneios_model->insereRomaneio($dados); // grava no banco romaneio que foi gerado

		if ($insereRomaneio) {
			$response = array(
				'success' => true,
				'message' => 'Romaneio gerado com sucesso.'
			);
		} else {
			$response = array(
				'success' => false,
				'message' => 'Falha ao cadastrar romaneio, tente novamente!'
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function gerarRomaneioAtrasados()
	{
		// Carrega os modelos necessários para manipulação de dados
		$this->load->model('SetoresEmpresaCliente_model');
		$this->load->model('Agendamentos_model');

		// Inicia uma transação
		$this->db->trans_begin();

		// Inicializa o array $dados com os dados recebidos via POST
		$dados['id_responsavel'] = $this->input->post('responsavel');
		$dados['id_veiculo'] = $this->input->post('veiculo');
		$data_romaneio = DateTime::createFromFormat('d/m/Y', $this->input->post('dataColeta'))->format('Y-m-d');
		$dados['data_romaneio'] = $data_romaneio;
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		// Obtém a data atual
		$data_atual = date('Y-m-d');

		// Verifica se a data do romaneio é anterior à data atual
		if ($data_romaneio < $data_atual) {
			$response = [
				'success' => false,
				'title' => "Data inválida!",
				'message' => "A nova data do romaneio não pode ser anterior à data atual!",
				'type' => "error",
				'redirect' => false
			];
			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		// Obtém a lista de clientes do formulário
		$clientes = $this->input->post('clientes');

		// Inicializa o array $clientes_por_setor para agrupar clientes por setor
		$clientes_por_setor = [];

		// Verifica se $clientes não é um array (pode ser um único cliente)
		if (!is_array($clientes)) {
			$clientes = [$clientes]; // Converte para array se não for
		}

		// Itera sobre os clientes e agrupa por setor
		foreach ($clientes as $cliente) {
			// Explode os dados do cliente
			$arrayClientes = explode('|', $cliente);

			// Verifica se já existe um array para o setor; se não, cria um novo
			if (isset($clientes_por_setor[$arrayClientes[1]])) {
				$clientes_por_setor[$arrayClientes[1]][] = $arrayClientes[0];
			} else {
				$clientes_por_setor[$arrayClientes[1]] = [$arrayClientes[0]];
			}
		}

		// Prepara os dados para inserção no banco para cada setor
		foreach ($clientes_por_setor as $id_setor => $ids_clientes) {
			// Gera um código aleatório para o romaneio e garante unicidade
			do {
				$codigo = mt_rand(1000000000, 9999999999);
			} while ($this->Romaneios_model->recebeRomaneioCod($codigo));

			$dados['codigo'] = $codigo;
			$dados['clientes'] = json_encode($ids_clientes); // Converte IDs de clientes para JSON
			$dados['id_setor_empresa'] = $id_setor;

			// Insere os dados do romaneio utilizando o modelo Romaneios_model
			$retorno = $this->Romaneios_model->insereRomaneio($dados);

			// Se a inserção falhar, encerra a transação e retorna falso
			if (!$retorno) {
				$this->db->trans_rollback();
				$response = [
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Não foi possível gerar o(s) romaneio(s)!",
					'type' => "error",
					'redirect' => false
				];
				return $this->output->set_content_type('application/json')->set_output(json_encode($response));
			}
		}

		// Se tudo estiver correto, confirma a transação
		$this->db->trans_commit();

		// Prepara a resposta JSON com base no sucesso da operação de inserção
		$response = [
			'success' => true,
			'title' => "Sucesso!",
			'message' => "Romaneio(s) gerado(s) com sucesso!",
			'type' => "success",
			'redirect' => true
		];

		// Retorna a resposta como JSON
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function gerarRomaneioPdf()
	{
		$codigo = $this->uri->segment(3);
		$this->gerarromaneio->gerarPdf($codigo);
	}

	public function formulario()
	{
		$this->load->model('Veiculos_model');
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts romaneio
		$scriptsRomaneioHead = scriptsRomaneioHead();
		$scriptsRomaneioFooter = scriptsRomaneioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsRomaneioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsRomaneioFooter));

		$data['cidades'] = $this->Clientes_model->recebeCidadesCliente();
		$data['etiquetas'] = $this->Etiquetas_model->recebeEtiquetas();
		$data['clientes'] = $this->Clientes_model->recebeClientesEtiquetas();
		$data['responsaveis'] = $this->Funcionarios_model->recebeResponsavelAgendamento();
		$data['veiculos'] = $this->Veiculos_model->recebeVeiculos();

		$this->load->model('SetoresEmpresaCliente_model');
		$data['setores'] = $this->SetoresEmpresaCliente_model->recebeSetoresEmpresaClientes();

		$this->load->model('FinFormaTransacao_model');
		$this->load->model('FinContaBancaria_model');
		$this->load->model('FinContasPagar_model');

		$this->load->model('FinMacro_model');
		$data['macros'] = $this->FinMacro_model->recebeMacros();

		$data['formasTransacao'] = $this->FinFormaTransacao_model->recebeFormasTransacao();
		$data['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/romaneio/cadastra-romaneio');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function filtrarClientesRomaneio()
	{
		$filtrar_data = $this->input->post('filtrar_data');
		$dados['cidades'] = $this->input->post('cidades');
		$dados['ids_etiquetas'] = $this->input->post('ids_etiquetas');
		$dados['data_coleta'] = null;
		$setorEmpresa = $this->input->post('setorEmpresa');

		if ($filtrar_data != '') {
			$dados['data_coleta'] = $this->input->post('data_coleta');
		}

		$res = $this->Romaneios_model->filtrarClientesRomaneio($dados, $setorEmpresa);

		$response = array(
			'retorno' => $res,
			'registros' => count($res)
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function recebeClientesRomaneios()
	{
		$codRomaneio = $this->input->post('codRomaneio');
		$idSetorEmpresa = $this->input->post('idSetorEmpresa');

		$this->load->model('Agendamentos_model');

		$romaneio = $this->Romaneios_model->recebeRomaneioCod($codRomaneio);

		$id_cliente_prioridade = $this->Agendamentos_model->recebeAgendamentoPrioridade($romaneio['data_romaneio']);

		$idsClientes = json_decode($romaneio['clientes'], true);

		$clientesRomaneio = $this->Clientes_model->recebeClientesIds($idsClientes, $idSetorEmpresa);

		// residuos
		$this->load->model('Residuos_model');
		$residuos = $this->Residuos_model->recebeResiduoSetor($idSetorEmpresa);

		$this->load->model('FinFormaTransacao_model');
		$formasTransacao = $this->FinFormaTransacao_model->recebeFormasTransacao();

		$response = array(
			'retorno' => $clientesRomaneio,
			'residuos' => $residuos,
			'pagamentos' => $formasTransacao,
			'id_cliente_prioridade' => $id_cliente_prioridade,
			'registros' => count($clientesRomaneio),
			'responsavel' => $romaneio['RESPONSAVEL']
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function recebeTodosResiduos()
	{
		// residuos
		$this->load->model('Residuos_model');

		$residuos = $this->Residuos_model->recebeTodosResiduos();

		$response = array(
			'residuos' => $residuos
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function recebeCidadeClientesSetor()
	{
		$idSetor = $this->input->post('id_setor');

		$this->load->model('SetoresEmpresaCliente_model');
		$cidades = $this->SetoresEmpresaCliente_model->recebeCidadesClientesSetoresEmpresa($idSetor);

		$response = array(
			'cidades' => $cidades
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function editarRomaneio()
	{
		$codigoRomaneio = $this->input->post('codigo');

		$romaneio = $this->Romaneios_model->recebeRomaneioCod($codigoRomaneio);

		$response = array(
			'romaneio' => $romaneio
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletaRomaneio()
	{
		$id = $this->input->post('id');

		$retorno = $this->Romaneios_model->deletaRomaneio($id);

		if ($retorno) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Romaneio deletado com sucesso!",
				'type' => "success",
				'redirect' => true
			);
		} else {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possivel deletar o romaneio!",
				'type' => "error",
				'redirect' => false

			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletaClienteRomaneio()
	{
		$codRomaneio = $this->input->post('romaneio');
		$id_cliente = $this->input->post('cliente');

		$romaneio = $this->Romaneios_model->recebeIdsClientesRomaneios($codRomaneio);


		$arrayIdsClientes = json_decode($romaneio['clientes']);

		if (count($arrayIdsClientes) == 1) {

			$this->Romaneios_model->deletaRomaneio($romaneio['id']);

			$response = array(
				'title' => "Sucesso!",
				'message' => 'Romaneio deletado com sucesso!',
				'type' => "success",
				'redirect' => true

			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}


		$index = array_search($id_cliente,  $arrayIdsClientes);

		if ($index !== false) {
			array_splice($arrayIdsClientes, $index, 1);
		}

		$data['clientes'] = json_encode($arrayIdsClientes);

		$this->Romaneios_model->editaRomaneioCodigo($codRomaneio, $data);


		$response = array(
			'romaneio' => $romaneio,
			'redirect' => false

		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function editaMotoristaRomaneio()
	{
		$codRomaneio = $this->input->post('codRomaneio');
		$data['id_responsavel'] = $this->input->post('idMotorista');

		$retorno = $this->Romaneios_model->editaRomaneioCodigo($codRomaneio, $data);

		if ($retorno) {

			$response = array(
				'title' => 'Sucesso!',
				'message' => 'Romaneio editado com sucesso!',
				'type' => 'success'

			);
		} else {

			$response = array(
				'title' => 'Algo deu errado!',
				'message' => 'Falha ao editar o romaneio!',
				'type' => 'error'

			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function adicionaNovoClienteRomaneio()
	{
		$codRomaneio = $this->input->post('romaneio');
		$id_cliente = $this->input->post('cliente');

		$romaneio = $this->Romaneios_model->recebeIdsClientesRomaneios($codRomaneio);

		$arrayIdsClientes = json_decode($romaneio['clientes']);

		$index = array_search($id_cliente,  $arrayIdsClientes);

		// verifica se o id está no array
		if ($index !== false) {

			$response = array(
				'redirect' => false,
				'success' => false
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		} else {

			array_push($arrayIdsClientes, $id_cliente);

			$data['clientes'] = json_encode($arrayIdsClientes);

			$this->Romaneios_model->editaRomaneioCodigo($codRomaneio, $data);


			$response = array(
				'romaneio' => $romaneio,
				'redirect' => false,
				'success' => true
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
}
