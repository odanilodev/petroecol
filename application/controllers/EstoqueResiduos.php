<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EstoqueResiduos extends CI_Controller
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

        $this->load->model('EstoqueResiduos_model');
        $this->load->model('ConversaoUnidadeMedida_model');

    }

    public function index()
    {
        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        // scripts para estoque de resíduos
        $scriptsEstoqueResiduosHead = scriptsEstoqueResiduosHead();
        $scriptsEstoqueResiduosFooter = scriptsEstoqueResiduosFooter();

        add_scripts('header', array_merge($scriptsPadraoHead, $scriptsEstoqueResiduosHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsEstoqueResiduosFooter));

        $this->load->model('Residuos_model');
        $data['residuos'] = $this->Residuos_model->recebeTodosResiduos();

        $quantidadeResiduoEntrada = [];
        foreach ($data['residuos'] as $residuo) {

            $dadosResiduos = $this->EstoqueResiduos_model->recebeEstoqueResiduo($residuo['id']);

            if (isset($dadosResiduos['QUANTIDADE'])) {
                
                // faz a conversão de acordo com o escolhido
                if ($this->input->post('converter_unidade_medida') && $dadosResiduos['id_unidade_medida'] != $this->input->post('converter_unidade_medida')) {

                    $this->load->helper('converter_unidade_medida_residuo');
    
                    $dadosConversaoResiduo = $this->ConversaoUnidadeMedida_model->recebeConversaoMedidaPorResiduo($residuo['id'], $this->input->post('converter_unidade_medida'));
    
                    $quantidadeResiduo = isset($dadosConversaoResiduo) ? calcularUnidadeMedidaResiduo($dadosConversaoResiduo['valor'], $dadosConversaoResiduo['tipo_operacao'], $dadosResiduos['QUANTIDADE']) : $dadosResiduos['QUANTIDADE']; // quantidade convertida
                }
                
                $quantidadeResiduoEntrada[] = [
                    'quantidade' => $quantidadeResiduo ?? $dadosResiduos['QUANTIDADE'],
                    'residuo'    => $residuo['nome'],
                    'idResiduo'  => $residuo['id'],
                    'unidade_medida' => $dadosConversaoResiduo['UNIDADE_MEDIDA'] ?? $residuo['unidade_medida']
                ];
            }
        }        

        $data['converter_unidade_medida'] = $this->input->post('converter_unidade_medida');
        
        $data['estoqueResiduos'] = $quantidadeResiduoEntrada;

        $this->load->model('UnidadesMedidas_model');
        $data['unidades_medidas'] = $this->UnidadesMedidas_model->recebeUnidadesMedidas();

        $this->load->model('Clientes_model');
        $data['clientes_finais'] = $this->Clientes_model->recebeClientesFinais();

        $this->load->model('FinMacro_model');
		$data['macros'] = $this->FinMacro_model->recebeMacros();

		$this->load->model('FinFormaTransacao_model');
		$data['formasTransacoes'] = $this->FinFormaTransacao_model->recebeFormasTransacao();

		$this->load->model('FinContaBancaria_model');
		$data['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();

		$this->load->model('SetoresEmpresa_model');
		$data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/residuos/estoque-residuos');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function detalhes()
    {
        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        // scripts para estoque de resíduos
        $scriptsEstoqueResiduosHead = scriptsEstoqueResiduosHead();
        $scriptsEstoqueResiduosFooter = scriptsEstoqueResiduosFooter();

        add_scripts('header', array_merge($scriptsPadraoHead, $scriptsEstoqueResiduosHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsEstoqueResiduosFooter));

        $idResiduo = $this->uri->segment(3);

        $data['estoqueResiduo'] = $this->EstoqueResiduos_model->recebeMovimentacaoEstoqueResiduo($idResiduo);

        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/residuos/detalhes-estoque-residuos');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function insereEstoqueResiduos()
    {
        $this->load->model('Residuos_model');

        $dados['id_residuo'] = $this->input->post('residuo');
        $dados['id_unidade_medida'] = $this->Residuos_model->recebeResiduo($dados['id_residuo'])['id_unidade_medida'];
        $dados['quantidade'] = $this->input->post('quantidade');
        $dados['tipo_movimentacao'] = $this->input->post('tipoLancamento');
        $dados['id_setor_empresa'] = $this->input->post('setorEmpresa');
        $dados['id_empresa'] = $this->session->userdata('id_empresa');
        $dados['origem_movimentacao'] = 'Lançamento manual no estoque';

        $totalAtualResiduo = $this->EstoqueResiduos_model->recebeTotalAtualEstoqueResiduo($dados['id_residuo']);

        if ($dados['tipo_movimentacao']) { // soma no total
            $dados['total_estoque_residuo'] = ($totalAtualResiduo['total_estoque_residuo'] ?? 0) + $dados['quantidade'];
        } else { // subtrai no total

            if (!isset($totalAtualResiduo) || $totalAtualResiduo['total_estoque_residuo'] < $dados['quantidade']) {
                $response = array(
                    'success' => false,
                    'type' => 'error',
                    'title' => 'Algo deu errado!',
                    'message' => 'Não há essa quantidade de resíduo no estoque!'
                );
                return $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }

            $dados['total_estoque_residuo'] = $totalAtualResiduo['total_estoque_residuo'] - $dados['quantidade'];
        }

        $retorno = $this->EstoqueResiduos_model->insereEstoqueResiduos($dados);

        if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
                'type' => 'success',
                'title' => 'Sucesso!',
				'message' => 'Lançamento concluído com sucesso!'
			);

		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
                'type' => 'error',
                'title' => 'Algo deu errado!',
				'message' => 'Algo deu errado ao concluir o lançamento. Tente novamente!'
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
        
    }
}
