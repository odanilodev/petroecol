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

    public function index($page = 1)
    {
        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        // scripts para estoque de resíduos
        $scriptsEstoqueResiduosHead = scriptsEstoqueResiduosHead();
        $scriptsEstoqueResiduosFooter = scriptsEstoqueResiduosFooter();

        add_scripts('header', array_merge($scriptsPadraoHead, $scriptsEstoqueResiduosHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsEstoqueResiduosFooter));

        $this->load->helper('cookie');

        if ($this->input->post()) {

            $this->input->set_cookie('filtro_estoque_residuos', json_encode($this->input->post()), 3600);
        }

        if (is_numeric($page)) {
            $cookie_filtro_estoque_residuos = count($this->input->post()) > 0 ? json_encode($this->input->post()) : $this->input->cookie('filtro_estoque_residuos');
        } else {
            $page = 1;
            delete_cookie('filtro_estoque_residuos');
            $cookie_filtro_estoque_residuos = json_encode([]);
        }

        $data['cookie_filtro_estoque_residuos'] = json_decode($cookie_filtro_estoque_residuos, true);


        // >>>> PAGINAÇÃO <<<<<
        $limit = 12; // Número de estoque por página
        $this->load->library('pagination');
        $config['base_url'] = base_url('estoqueResiduos/index/');
        $config['total_rows'] = $this->EstoqueResiduos_model->recebeEstoqueResiduos($cookie_filtro_estoque_residuos, $limit, $page, true); // true para contar
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
        $this->pagination->initialize($config);
        // >>>> FIM PAGINAÇÃO <<<<<

        $data['estoque'] = $this->EstoqueResiduos_model->recebeEstoqueResiduos($cookie_filtro_estoque_residuos, $limit, $page);

        $this->load->model('Residuos_model');
        $data['residuos'] = $this->Residuos_model->recebeTodosResiduos();        

        $entradasResiduos = $this->Residuos_model->recebeMovimentacaoResiduos(1);
        $arrayEntradaResiduoId = [];
        foreach($entradasResiduos as $entradaResiduo) {
            if (isset($arrayEntradaResiduoId[$entradaResiduo['id_residuo']])) {
                $arrayEntradaResiduoId[$entradaResiduo['id_residuo']] += $entradaResiduo['quantidade'];
            } else {
                $arrayEntradaResiduoId[$entradaResiduo['id_residuo']] = $entradaResiduo['quantidade'];
            }
        }
        $data['entradasResiduos'] = $arrayEntradaResiduoId;


        $saidasResiduos = $this->Residuos_model->recebeMovimentacaoResiduos(0);
        $arraySaidaResiduoId = [];
        foreach($saidasResiduos as $saida) {
            if (isset($arraySaidaResiduoId[$saida['id_residuo']])) {
                $arraySaidaResiduoId[$saida['id_residuo']] += $saida['quantidade'];
            } else {
                $arraySaidaResiduoId[$saida['id_residuo']] = $saida['quantidade'];
            }
        }
        $data['saidasResiduos'] = $arraySaidaResiduoId;
        

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
