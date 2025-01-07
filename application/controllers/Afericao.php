<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Afericao extends CI_Controller
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

		$this->load->model('Afericao_model');
		$this->load->model('Coletas_model');

		$this->load->library('residuoChaveId');
	}

	public function index($page = 1)
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para afericao
		$scriptsAfericaoFooter = scriptsAfericaoFooter();
		$scriptsAfericaoHead = scriptsAfericaoHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsAfericaoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsAfericaoFooter));

		$this->load->helper('cookie');

		if ($this->input->post()) {
			$this->input->set_cookie('filtro_afericao', json_encode($this->input->post()), 3600);
		}

		if (is_numeric($page)) {
			$cookie_filtro_afericao = count($this->input->post()) > 0 ? json_encode($this->input->post()) : $this->input->cookie('filtro_afericao');
		} else {
			$page = 1;
			delete_cookie('filtro_afericao');
			$cookie_filtro_afericao = json_encode([]);
		}

		$data['cookie_filtro_afericao'] = json_decode($cookie_filtro_afericao, true);

		// >>>> PAGINAÇÃO <<<<<
		$limit = 12; // Número de afericao por página
		$this->load->library('pagination');
		$config['base_url'] = base_url('afericao/index');
		$config['total_rows'] = $this->Afericao_model->recebeAfericoes($cookie_filtro_afericao, $limit, $page, true); // true para contar
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
		$this->pagination->initialize($config);
		// >>>> FIM PAGINAÇÃO <<<<<

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

		$this->load->model('Trajetos_model');
		$data['trajetos'] = $this->Trajetos_model->recebeTodosTrajetos();
		$data['afericoes'] = $this->Afericao_model->recebeAfericoes($cookie_filtro_afericao, $limit, $page);

		$data['residuosArray'] = $this->residuochaveid->residuoArrayNomes();


		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/afericao/afericao');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function aferirResiduos()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para afericao
		$scriptsAfericaoFooter = scriptsAfericaoFooter();
		$scriptsAfericaoHead = scriptsAfericaoHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsAfericaoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsAfericaoFooter));

		$codigoRomaneio = $this->uri->segment(3);

		$data['residuosArray'] = $this->residuochaveid->residuoArrayNomes();

		$data['coletas'] = $this->Coletas_model->recebeColetaRomaneio($codigoRomaneio);

		$this->load->model('UnidadesMedidas_model');

		$data['unidadesMedidas'] = $this->UnidadesMedidas_model->recebeUnidadesMedidas();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/afericao/aferir-residuos');
		$this->load->view('admin/includes/painel/rodape');
	}


	public function salvarAfericao()
	{
		$dadosResiduosAferidos = $this->input->post('dadosResiduos');

		$this->load->model('Coletas_model');
		$this->load->model('EstoqueResiduos_model');
		$this->load->model('Residuos_model');

		$sucesso = 0; // conta quantos registros foram inseridos com sucesso
		foreach ($dadosResiduosAferidos as $dadosResiduosAferido) {

			$dados['id_residuo'] = $dadosResiduosAferido['idResiduo'];
			$dados['id_unidade_medida'] = $dadosResiduosAferido['medida'];
			$dados['quantidade_coletada'] = $dadosResiduosAferido['qtdColetada'];
			$dados['id_setor_empresa'] = $dadosResiduosAferido['setorEmpresa'];
			$dados['aferido'] = $dadosResiduosAferido['aferido'];
			$dados['id_trajeto'] = $dadosResiduosAferido['idTrajeto'];
			$dados['cod_romaneio'] = $this->input->post('codRomaneio');
			$dados['id_empresa'] = $this->session->userdata('id_empresa');

			$retorno = $this->Afericao_model->insereAfericao($dados);

			if ($retorno) {

				$dadosResiduosEstoque['id_residuo'] = $dadosResiduosAferido['idResiduo'];
				$dadosResiduosEstoque['quantidade'] = $dadosResiduosAferido['aferido'];
				$dadosResiduosEstoque['id_unidade_medida'] = $dadosResiduosAferido['medida'];
				$dadosResiduosEstoque['id_setor_empresa'] = $dadosResiduosAferido['setorEmpresa'];
				$dadosResiduosEstoque['tipo_movimentacao'] = 1; // entrada
				$dadosResiduosEstoque['id_empresa'] = $this->session->userdata('id_empresa');

				$unidadeMedidaPadraoResiduo = $this->Residuos_model->recebeResiduo($dadosResiduosEstoque['id_residuo'])['id_unidade_medida'];

				// faz a conversão de quantidade caso o a unidade de medida seja diferente da padrão do resíduo
				if ($unidadeMedidaPadraoResiduo != $dadosResiduosEstoque['id_unidade_medida']) {

					$this->load->model('ConversaoUnidadeMedida_model');
					$this->load->helper('converter_unidade_medida_residuo');

					$dadosConversaoResiduo = $this->ConversaoUnidadeMedida_model->recebeConversaoPorResiduo($dadosResiduosEstoque['id_residuo'], $dadosResiduosEstoque['id_unidade_medida']);

					if ($dadosConversaoResiduo) {

						$dadosResiduosEstoque['quantidade'] = calcularUnidadeMedidaResiduo($dadosConversaoResiduo['valor'], $dadosConversaoResiduo['tipo_operacao'], $dadosResiduosAferido['aferido']); // quantidade convertida
						$dadosResiduosEstoque['quantidade'] = number_format($dadosResiduosEstoque['quantidade'], 3, '.', '');
					}
				}

				// soma o total do residuo de acordo com o ultimo total gravado
				$quantidadeTotalResiduo = $this->EstoqueResiduos_model->recebeTotalAtualEstoqueResiduo($dadosResiduosEstoque['id_residuo']);
				$dadosResiduosEstoque['total_estoque_residuo'] = $quantidadeTotalResiduo['total_estoque_residuo'] ?? 0 + $dadosResiduosEstoque['quantidade'];
				$dadosResiduosEstoque['total_estoque_residuo'] = number_format($dadosResiduosEstoque['total_estoque_residuo'], 3, '.', '');
				$dadosResiduosEstoque['origem_movimentacao'] = 'Lançamento aferição';


				$this->EstoqueResiduos_model->insereEstoqueResiduos($dadosResiduosEstoque);

				$sucesso++;

				// altera o status para aferido
				$dadosColeta['aferido'] = 1;
				$this->Coletas_model->editaColetaAfericao($dados['cod_romaneio'], $dadosColeta);
			}
		}

		if ($sucesso > 0) {
			$response = array(
				'success' => true,
				'title' => 'Sucesso!',
				'type' => 'success',
				'message' => "Resíduos aferidos com sucesso."
			);
		} else {
			$response = array(
				'success' => false,
				'title' => 'Algo deu errado!',
				'type' => 'error',
				'message' => "Erro ao aferir os resíduos!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function salvarTrajetoAfericao()
	{
		$this->load->model('Romaneios_model');
		$this->load->model('Coletas_model');

		$idTrajeto = $this->input->post('idTrajeto');
		$codRomaneio = $this->input->post('codRomaneio');

		if ($codRomaneio) {

			$dados['id_trajeto'] = $idTrajeto;

			$this->Romaneios_model->editaRomaneioCodigo($codRomaneio, $dados);
			$retorno = $this->Coletas_model->editaColetaAfericao($codRomaneio, $dados);
		} else {

			$dadosAfericao['id_trajeto'] = $idTrajeto;
		}


		if ($retorno) {

			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Trajeto modificado com sucesso!",
				'type' => "success"
			);
		} else {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possível modificar o Trajeto!",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function residuosAferidos()
	{

		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para afericao
		$scriptsAfericaoFooter = scriptsAfericaoFooter();
		$scriptsAfericaoHead = scriptsAfericaoHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsAfericaoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsAfericaoFooter));

		$data['residuosArray'] = $this->residuochaveid->residuoArrayNomes();


		$data['residuosAferidos'] = $this->Afericao_model->recebeResiduosAferidos();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/afericao/residuos-aferidos');
		$this->load->view('admin/includes/painel/rodape');
	}
}
