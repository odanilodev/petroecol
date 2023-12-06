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
		}


		// Verifica se veio imagem
		if (!empty($_FILES['foto_cnh']['name'])) {
			$config['upload_path']   = './uploads/funcionarios/cnh';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);
			
			// Deleta a foto de perfil antiga do servidor
			if ($id && $imagemAntiga['foto_cnh']) {
				$caminho = './uploads/funcionarios/cnh/' . $imagemAntiga['foto_cnh'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('foto_cnh')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_cnh'] = $dados_imagem['file_name'];
			}

			// Limpa a configuração para a próxima instância
		}


		// Verifica se veio imagem
		if (!empty($_FILES['foto_perfil']['name'])) {
			$config['upload_path']   = './uploads/funcionarios/perfil';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);
			
			if ($id && $imagemAntiga['foto_perfil']) {
				$caminho = './uploads/funcionarios/perfil/' . $imagemAntiga['foto_perfil'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('foto_perfil')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_perfil'] = $dados_imagem['file_name'];
			}
		}

		
		// Verifica se veio imagem
		if (!empty($_FILES['foto_cpf']['name'])) {
			$config['upload_path']   = './uploads/funcionarios/cpf';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);
			
			if ($id && $imagemAntiga['foto_cpf']) {
				$caminho = './uploads/funcionarios/cpf/' . $imagemAntiga['foto_cpf'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('foto_cpf')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_cpf'] = $dados_imagem['file_name'];
			}
		}

		// Verifica se veio imagem
		if (!empty($_FILES['foto_aso']['name'])) {
			$config['upload_path']   = './uploads/funcionarios/aso';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);
			
			if ($id && $imagemAntiga['foto_aso']) {
				$caminho = './uploads/funcionarios/aso/' . $imagemAntiga['foto_Aso'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('foto_aso')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_aso'] = $dados_imagem['file_name'];
			}
		}

		// Verifica se veio imagem
		if (!empty($_FILES['foto_epi']['name'])) {
			$config['upload_path']   = './uploads/funcionarios/epi';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);
			
			if ($id && $imagemAntiga['foto_epi']) {
				$caminho = './uploads/funcionarios/epi/' . $imagemAntiga['foto_epi'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('foto_epi')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_epi'] = $dados_imagem['file_name'];
			}
		}

		// Verifica se veio imagem
		if (!empty($_FILES['foto_registro']['name'])) {
			$config['upload_path']   = './uploads/funcionarios/registro';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);
			
			if ($id && $imagemAntiga['foto_registro']) {
				$caminho = './uploads/funcionarios/registro/' . $imagemAntiga['foto_registro'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('foto_registro')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_registro'] = $dados_imagem['file_name'];
			}
		}

		// Verifica se veio imagem
		if (!empty($_FILES['foto_carteira']['name'])) {
			$config['upload_path']   = './uploads/funcionarios/carteira';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);
			
			if ($id && $imagemAntiga['foto_carteira']) {
				$caminho = './uploads/funcionarios/carteira/' . $imagemAntiga['fotoCarteira'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('foto_carteira')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_carteira'] = $dados_imagem['file_name'];
			}
		}

		// Verifica se veio imagem
		if (!empty($_FILES['foto_vacinacao']['name'])) {
			$config['upload_path']   = './uploads/funcionarios/vacinacao';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);
			
			if ($id && $imagemAntiga['foto_vacinacao']) {
				$caminho = './uploads/funcionarios/vacinacao/' . $imagemAntiga['foto_vacinacao'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('foto_vacinacao')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_vacinacao'] = $dados_imagem['file_name'];
			}
		}

		// Verifica se veio imagem
		if (!empty($_FILES['foto_certificados']['name'])) {
			$config['upload_path']   = './uploads/funcionarios/certificados';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);
			
			if ($id && $imagemAntiga['foto_certificados']) {
				$caminho = './uploads/funcionarios/certificados/' . $imagemAntiga['foto_certificados'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('foto_certificados')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_certificados'] = $dados_imagem['file_name'];
			}
		}

		// Verifica se veio imagem
		if (!empty($_FILES['foto_ordem']['name'])) {
			$config['upload_path']   = './uploads/funcionarios/ordem';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);
			
			if ($id && $imagemAntiga['foto_ordem']) {
				$caminho = './uploads/funcionarios/ordem/' . $imagemAntiga['foto_ordem'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('foto_ordem')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_ordem'] = $dados_imagem['file_name'];
			}
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

	public function downloadCnh($id)
    {
        $this->load->helper('download'); 

        $this->load->model('Funcionarios_model');

        $funcionario = $this->Funcionarios_model->recebeFuncionario($id);

		$path =  './uploads/funcionarios/cnh/'.$funcionario['foto_cnh'] ;

		$arquivoPath = base_url($path);

		$data = file_get_contents($path); 
		
		force_download($arquivoPath, $data);

		redirect('funcionarios');
		
    }

	public function downloadAso($id)
    {
        $this->load->helper('download'); 

        $this->load->model('Funcionarios_model');

        $funcionario = $this->Funcionarios_model->recebeFuncionario($id);

		$path =  './uploads/funcionarios/aso/'.$funcionario['foto_aso'] ;

		$arquivoPath = base_url($path);

		$data = file_get_contents($path); 
		
		force_download($arquivoPath, $data);

		redirect('funcionarios');
		
    }

	public function downloadEpi($id)
    {
        $this->load->helper('download'); 

        $this->load->model('Funcionarios_model');

        $funcionario = $this->Funcionarios_model->recebeFuncionario($id);

		$path =  './uploads/funcionarios/epi/'.$funcionario['foto_epi'] ;

		$arquivoPath = base_url($path);

		$data = file_get_contents($path); 
		
		force_download($arquivoPath, $data);

		redirect('funcionarios');
		
    }

	public function downloadRegistro($id)
    {
        $this->load->helper('download'); 

        $this->load->model('Funcionarios_model');

        $funcionario = $this->Funcionarios_model->recebeFuncionario($id);

		$path =  './uploads/funcionarios/registro/'.$funcionario['foto_registro'] ;

		$arquivoPath = base_url($path);

		$data = file_get_contents($path); 
		
		force_download($arquivoPath, $data);

		redirect('funcionarios');
		
    }

	public function downloadCarteiraTrabalho($id)
    {
        $this->load->helper('download'); 

        $this->load->model('Funcionarios_model');

        $funcionario = $this->Funcionarios_model->recebeFuncionario($id);

		$path =  './uploads/funcionarios/carteira/'.$funcionario['foto_carteira'] ;

		$arquivoPath = base_url($path);

		$data = file_get_contents($path); 
		
		force_download($arquivoPath, $data);

		redirect('funcionarios');
		
    }

	public function downloadCarteiraVacinacao($id)
    {
        $this->load->helper('download'); 

        $this->load->model('Funcionarios_model');

        $funcionario = $this->Funcionarios_model->recebeFuncionario($id);

		$path =  './uploads/funcionarios/vacinacao/'.$funcionario['foto_vacinacao'] ;

		$arquivoPath = base_url($path);

		$data = file_get_contents($path); 
		
		force_download($arquivoPath, $data);

		redirect('funcionarios');
		
    }

	public function downloadCertificado($id)
    {
        $this->load->helper('download'); 

        $this->load->model('Funcionarios_model');

        $funcionario = $this->Funcionarios_model->recebeFuncionario($id);

		$path =  './uploads/funcionarios/certificado/'.$funcionario['foto_certificado'] ;

		$arquivoPath = base_url($path);

		$data = file_get_contents($path); 
		
		force_download($arquivoPath, $data);

		redirect('funcionarios');
		
    }

	public function downloadOrdem($id)
    {
        $this->load->helper('download'); 

        $this->load->model('Funcionarios_model');

        $funcionario = $this->Funcionarios_model->recebeFuncionario($id);

		$path =  './uploads/funcionarios/ordem/'.$funcionario['foto_ordem'] ;

		$arquivoPath = base_url($path);

		$data = file_get_contents($path); 
		
		force_download($arquivoPath, $data);

		redirect('funcionarios');
		
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