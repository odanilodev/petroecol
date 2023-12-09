<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Funcionarios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// INICIO controle sessão
        $this->load->library('Controle_sessao');
        $res = $this->controle_sessao->controle();
        if($res == 'erro'){ redirect('login/erro', 'refresh');}
        // FIM controle sessão

		$this->load->model('Funcionarios_model');
		date_default_timezone_set('America/Sao_Paulo');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();
		
		// scripts para Funcionarios
		$scriptsFuncionarioHead = scriptsFuncionarioHead();
		$scriptsFuncionarioFooter = scriptsFuncionarioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead,$scriptsFuncionarioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter,$scriptsFuncionarioFooter));

		$data['funcionarios'] = $this->Funcionarios_model->recebeFuncionarios();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/funcionarios/funcionarios');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function detalhes()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();
		
		// scripts para Funcionarios
		$scriptsFuncionarioHead = scriptsFuncionarioHead();
		$scriptsFuncionarioFooter = scriptsFuncionarioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead,$scriptsFuncionarioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter,$scriptsFuncionarioFooter));

		$id = $this->uri->segment(3);

		$data['funcionario'] = $this->Funcionarios_model->recebeFuncionario($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/funcionarios/ver_funcionario');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();
		
		// scripts para funcionarios
		$scriptsFuncionarioHead = scriptsFuncionarioHead();
		$scriptsFuncionarioFooter = scriptsFuncionarioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsFuncionarioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFuncionarioFooter));

		$this->load->model('Empresas_model');
		$this->load->model('Cargos_model');


		$id = $this->uri->segment(3);

		$data['funcionario'] = $this->Funcionarios_model->recebeFuncionario($id);

		$data['empresas'] = $this->Empresas_model->recebeEmpresas();
		
		$data['cargos'] = $this->Cargos_model->recebeCargos();


		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/funcionarios/cadastra-funcionarios');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraFuncionario()
	{
		
		$this->load->library('upload_imagem');

		$id = $this->input->post('id');

		$nome = $this->input->post('nome');
		$dados['nome'] = mb_convert_case($nome, MB_CASE_TITLE, 'UTF-8');
		$dados['data_cnh'] = $this->input->post('data_cnh');
		$dados['telefone'] = $this->input->post('telefone');
		$dados['cpf'] = $this->input->post('cpf');
		$dados['id_cargo'] = $this->input->post('id_cargo');
		$dados['data_nascimento'] = $this->input->post('data_nascimento');
		$dados['residencia'] = $this->input->post('residencia');
		$dados['salario_base'] = $this->input->post('salario_base');

		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		// Se estiver cadastrando
		if (!$id) {
			$cpfFuncionario = $this->Funcionarios_model->verificaCpfFuncionario($dados['cpf']); // verifica se ja existe o cpf no banco

			if ($cpfFuncionario) {
				$response = array(
					'success' => false,
					'message' => "Já existe um funcionário com este CPF!"
				);

				return $this->output->set_content_type('application/json')->set_output(json_encode($response));
			}

			$dados['foto_cnh'] = $this->upload_imagem->uploadImagem('foto_cnh', './uploads/funcionarios/cnh');
			$dados['foto_perfil'] =  $this->upload_imagem->uploadImagem('foto_perfil', './uploads/funcionarios/perfil');
			$dados['foto_cpf'] =  $this->upload_imagem->uploadImagem('foto_cpf', './uploads/funcionarios/cpf');
			$dados['foto_aso'] =  $this->upload_imagem->uploadImagem('foto_aso', './uploads/funcionarios/aso');
			$dados['foto_epi'] =  $this->upload_imagem->uploadImagem('foto_epi', './uploads/funcionarios/epi');
			$dados['foto_registro'] =  $this->upload_imagem->uploadImagem('foto_registro', './uploads/funcionarios/registro');
			$dados['foto_carteira'] =  $this->upload_imagem->uploadImagem('foto_carteira', './uploads/funcionarios/carteira');
			$dados['foto_vacinacao'] =  $this->upload_imagem->uploadImagem('foto_vacinacao', './uploads/funcionarios/vacinacao');
			$dados['foto_certificados'] =  $this->upload_imagem->uploadImagem('foto_certificados', './uploads/funcionarios/certificados');
			$dados['foto_ordem'] =  $this->upload_imagem->uploadImagem('foto_ordem', './uploads/funcionarios/ordem');
		
		}else {
			// Usando a função auxiliar para fazer o upload das imagens com imagem antiga
			$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);
		
			$dados['foto_cnh'] = $this->upload_imagem->uploadEditarImagem('foto_cnh', './uploads/funcionarios/cnh', $imagemAntiga['foto_cnh']);
			$dados['foto_perfil'] = $this->upload_imagem->uploadEditarImagem('foto_perfil', './uploads/funcionarios/perfil', $imagemAntiga['foto_perfil']);
			$dados['foto_cpf'] =  $this->upload_imagem->uploadEditarImagem('foto_cpf', './uploads/funcionarios/cpf', $imagemAntiga['foto_cpf']);
			$dados['foto_aso'] =  $this->upload_imagem->uploadEditarImagem('foto_aso', './uploads/funcionarios/aso', $imagemAntiga['foto_aso']);
			$dados['foto_epi'] =  $this->upload_imagem->uploadEditarImagem('foto_epi', './uploads/funcionarios/epi', $imagemAntiga['foto_epi']);
			$dados['foto_registro'] =  $this->upload_imagem->uploadEditarImagem('foto_registro', './uploads/funcionarios/registro', $imagemAntiga['foto_registro']);
			$dados['foto_carteira'] =  $this->upload_imagem->uploadEditarImagem('foto_carteira', './uploads/funcionarios/carteira', $imagemAntiga['foto_carteira']);
			$dados['foto_vacinacao'] =  $this->upload_imagem->uploadEditarImagem('foto_vacinacao', './uploads/funcionarios/vacinacao', $imagemAntiga['foto_vacinacao']);
			$dados['foto_certificados'] =  $this->upload_imagem->uploadEditarImagem('foto_certificados', './uploads/funcionarios/certificados', $imagemAntiga['foto_certificados']);
			$dados['foto_ordem'] =  $this->upload_imagem->uploadEditarImagem('foto_ordem', './uploads/funcionarios/ordem', $imagemAntiga['foto_ordem']);
		
		}
	
		$retorno = $id ? $this->Funcionarios_model->editaFuncionario($id, $dados) : $this->Funcionarios_model->insereFuncionario($dados); // se tiver ID edita, se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Funcionario editado com sucesso!' : 'Funcionario cadastrado com sucesso!'
			);	
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o Funcionario!" : "Erro ao cadastrar o Funcionario!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function downloadArquivo($tipo, $id)
	{
		$this->load->helper('download');
		$this->load->model('Funcionarios_model');

		$funcionario = $this->Funcionarios_model->recebeFuncionario($id);

		// Verifica se o tipo de arquivo solicitado existe no registro do funcionário
		$nomeCampo = 'foto_' . $tipo;
		if (!isset($funcionario[$nomeCampo]) || empty($funcionario[$nomeCampo])) {
			// Arquivo não existe no banco, redireciona para a página de detalhes
			redirect('funcionarios/detalhes/' . $id);
		}

		$path = "./uploads/funcionarios/{$tipo}/{$funcionario[$nomeCampo]}";

		// Verifica se o arquivo físico existe
		if (file_exists($path)) {
			$arquivoPath = base_url($path);
			$data = file_get_contents($path);
			force_download($arquivoPath, $data);
		} else {
			// Arquivo físico não existe, redireciona para a página de detalhes
			redirect('funcionarios/detalhes/' . $id);
		}
	}


	public function deletaFuncionario()
	{
		$id = $this->input->post('id');

		$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);

		if ($imagemAntiga['foto_perfil']) {
			$caminho = './uploads/funcionarios/perfil' . $imagemAntiga['foto_perfil'];
			unlink($caminho);
		}

		if ($imagemAntiga['foto_cnh']) {
			$caminho = './uploads/funcionarios/cnh' . $imagemAntiga['foto_cnh'];
			unlink($caminho);
		}

		$this->Funcionarios_model->deletaFuncionario($id);

		redirect('funcionarios');
	}
}