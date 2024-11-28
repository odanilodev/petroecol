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
        
        $quantidadeResiduoEntrada[] = 0;
        $quantidadeResiduoSaida[] = 0;
        foreach($data['residuos'] as $residuo) {

            $quantidadeResiduoEntrada[$residuo['id']] = $this->EstoqueResiduos_model->recebeEstoqueResiduo($residuo['id'], 1); // 1 é entrada
            $quantidadeResiduoSaida[$residuo['id']] = $this->EstoqueResiduos_model->recebeEstoqueResiduo($residuo['id'], 0); // 0 é saída
        } 
        
        $data['estoque'] = $quantidadeResiduoEntrada;
        $data['quantidadeSaidaResiduo'] = $quantidadeResiduoSaida;
    
        $this->load->model('UnidadesMedidas_model');
        $data['unidades_medidas'] = $this->UnidadesMedidas_model->recebeUnidadesMedidas();

        $this->load->model('Clientes_model');
        $data['clientes_finais'] = $this->Clientes_model->recebeClientesFinais();
        
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
}
