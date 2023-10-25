<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Motoristas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// INICIO controle sessão
        $this->load->library('Controle_sessao');
        $res = $this->controle_sessao->controle();
        if($res == 'erro'){ redirect('login/erro', 'refresh');}
        // FIM controle sessão

		$this->load->model('Motoristas_model');
		date_default_timezone_set('America/Sao_Paulo');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();
		
		// scripts para motoristas
		$scriptsMotoristaHead = scriptsMotoristaHead();
		$scriptsMotoristaFooter = scriptsMotoristaFooter();

		add_scripts('header', array_merge($scriptsPadraoHead,$scriptsMotoristaHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter,$scriptsMotoristaFooter));

		$data['motoristas'] = $this->Motoristas_model->recebeMotoristas();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/motoristas/motoristas');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();
		
		// scripts para motoristas
		$scriptsMotoristaHead = scriptsMotoristaHead();
		$scriptsMotoristaFooter = scriptsMotoristaFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsMotoristaHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsMotoristaFooter));

		$this->load->model('Empresas_model');

		$id = $this->uri->segment(3);

		$data['motorista'] = $this->Motoristas_model->recebeMotorista($id);

		$data['empresas'] = $this->Empresas_model->recebeEmpresas();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/motoristas/cadastra-motoristas');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraMotorista()
	{
		$id = $this->input->post('id');

		$dados['nome'] = $this->input->post('nome');
		$dados['data_cnh'] = $this->input->post('data_cnh');
		$dados['telefone'] = $this->input->post('telefone');
		$dados['cpf'] = $this->input->post('cpf');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		// Verifica se veio imagem
		if (!empty($_FILES['foto_cnh']['name'])) {
			$config['upload_path']   = './uploads/motoristas/cnh';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			$imagemAntiga = $this->Motoristas_model->recebeMotorista($id);
			
			// Deleta a foto de perfil antiga do servidor
			if ($id && $imagemAntiga['foto_cnh']) {
				$caminho = './uploads/motoristas/cnh/' . $imagemAntiga['foto_cnh'];
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
			$config['upload_path']   = './uploads/motoristas/perfil';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			$imagemAntiga = $this->Motoristas_model->recebeMotorista($id);
			
			// Deleta a foto de perfil antiga do servidor
			if ($id && $imagemAntiga['foto_perfil']) {
				$caminho = './uploads/motoristas/perfil/' . $imagemAntiga['foto_perfil'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('foto_perfil')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_perfil'] = $dados_imagem['file_name'];
			}
		}

		$retorno = $id ? $this->Motoristas_model->editaMotorista($id, $dados) : $this->Motoristas_model->insereMotorista($dados); // se tiver ID edita, se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Motorista editado com sucesso!' : 'Motorista cadastrado com sucesso!'
			);	
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o Motorista!" : "Erro ao cadastrar o Motorista!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function downloadCnh($id)
    {
        $this->load->helper('download'); 

        $this->load->model('Motoristas_model');

        $motorista = $this->Motoristas_model->recebeMotorista($id);

		$path =  './uploads/motoristas/cnh/'.$motorista['foto_cnh'] ;

		$arquivoPath = base_url($path);

		$data = file_get_contents($path); 
		
		force_download($arquivoPath, $data);

		redirect('motoristas');
		
    }


	public function deletaMotorista()
	{
		$id = $this->input->post('id');

		$imagemAntiga = $this->Motoristas_model->recebeMotorista($id);

		if ($imagemAntiga['foto_perfil']) {
			$caminho = './uploads/motoristas/perfil' . $imagemAntiga['foto_perfil'];
			unlink($caminho);
		}

		if ($imagemAntiga['foto_cnh']) {
			$caminho = './uploads/motoristas/cnh' . $imagemAntiga['foto_cnh'];
			unlink($caminho);
		}

		$this->Motoristas_model->deletaMotorista($id);

		redirect('motoristas');
	}
}
