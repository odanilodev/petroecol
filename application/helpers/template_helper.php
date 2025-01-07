<?php

function add_scripts($pos, $params)
{
    $ci = &get_instance();

    if (!is_array($params)) {
        $params = array($params);
    }

    $ci->config->set_item($pos, $params);

    return;
}

function header_scripts($str = '')
{
    $ci = &get_instance();
    $headers = $ci->config->item('header');

    foreach ($headers as $item) {
        $str .= $item . "\n";
    }

    echo $str;
}


function footer_scripts($str = '')
{
    $ci = &get_instance();
    $footers = $ci->config->item('footer');

    foreach ($footers as $item) {
        $str .= $item . "\n";
    }

    echo $str;
}

function scriptsPadraoHead()
{
    return array(

        '<script src="' . base_url('assets/js/config.js') . '"></script>',
        '<link href="' . base_url('vendors/flatpickr/flatpickr.min.css') . '" rel="stylesheet">',
        '<link href="' . base_url('vendors/dropzone/dropzone.min.css') . '" rel="stylesheet">',
        '<link href="' . base_url('vendors/prism/prism-okaidia.css') . '" rel="stylesheet">',
        '<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">',
        '<link href="' . base_url('vendors/simplebar/simplebar.min.css') . '" rel="stylesheet">',
        '<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">',
        '<link href="' . base_url('assets/css/theme-rtl.min.css') . '" type="text/css" rel="stylesheet" id="style-rtl">',
        '<link href="' . base_url('assets/css/theme.css') . '" type="text/css" rel="stylesheet" id="style-default">',
        '<link href="' . base_url('assets/css/user-rtl.min.css') . '" type="text/css" rel="stylesheet" id="user-style-rtl">',
        '<link href="' . base_url('assets/css/user.min.css') . '" type="text/css" rel="stylesheet" id="user-style-default">',

    );
}

function scriptsPadraoFooter()
{
    return array(

        '<script src="' . base_url('vendors/jquery/jquery.min.js') . '"></script>',
        '<script src="' . base_url('vendors/popper/popper.min.js') . '"></script>',
        '<script src="' . base_url('vendors/bootstrap/bootstrap.min.js') . '"></script>',
        '<script src="' . base_url('vendors/anchorjs/anchor.min.js') . '"></script>',
        '<script src="' . base_url('vendors/is/is.min.js') . '"></script>',
        '<script src="' . base_url('vendors/fontawesome/all.min.js') . '"></script>',
        '<script src="' . base_url('vendors/lodash/lodash.min.js') . '"></script>',
        '<script src="' . base_url('vendors/feather-icons/feather.min.js') . '"></script>',
        '<script src="' . base_url('vendors/dayjs/dayjs.min.js') . '"></script>',
        '<script src="' . base_url('vendors/dropzone/dropzone.min.js') . '"></script>',
        '<script src="' . base_url('vendors/prism/prism.js') . '"></script>',
        '<script src="' . base_url('assets/js/phoenix.js') . '"></script>',
        '<script src="' . base_url('vendors/list.js/list.min.js') . '"></script>',
        '<script src="' . base_url('node_modules/sweetalert2/dist/sweetalert2.all.min.js') . '"></script>',
        '<script src="' . base_url('assets/js/alertas/alertas-retornos.js') . '"></script>',
        '<script src="' . base_url('assets/js/aprovacao-inativos/helper-aprovacao-inativos.js') . '"></script>',
        '<script src="' . base_url('assets/js/documentos-vencendo/helper-documentos-vencendo.js') . '"></script>'
    );
}


// pagina de usuario
function scriptsUsuarioHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />',
        '<link href="' . base_url('assets/css/upload-arquivo.css') . '" type="text/css" rel="stylesheet" id="user-style-default">',
        '<link href="' . base_url('assets/css/usuario/usuarios.css') . '" type="text/css" rel="stylesheet" id="user-style-default">'

    );
}

function scriptsUsuarioFooter()
{
    return array(

        '<script src="' . base_url('assets/js/usuarios/formulario-usuario.js') . '"></script>',
        '<script src="' . base_url('assets/js/upload-imagem.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/validacoes.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>'

    );
}


// pagina de Funcionario
function scriptsFuncionarioHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />',
        '<link href="' . base_url('assets/css/upload-arquivo.css') . '" type="text/css" rel="stylesheet" id="user-style-default">',

    );
}

function scriptsFuncionarioFooter()
{
    return array(

        '<script src="' . base_url('assets/js/funcionarios/formulario-funcionarios.js') . '"></script>',
        '<script src="' . base_url('assets/js/upload-imagem.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>'

    );
}

// scripts de relatorio de coletas
function scriptsRelColetasHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}


function scriptsRelColetasFooter()
{
    return array(

        '<script src="' . base_url('assets/js/relatorios/relcoletas.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>'


    );
}

// scripts de romaneio
function scriptsRomaneioHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}


function scriptsRomaneioFooter()
{
    return array(
        '<script src="' . base_url('assets/js/helpers-js/formatar-moeda-real.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-data.js') . '"></script>',
        '<script src="' . base_url('assets/js/romaneios/romaneio.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('assets/js/financeiro/prestacao-contas/prestacao-contas.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/carregar-select2.js') . '"></script>'

    );
}


// Pagina de clientes
function scriptsClienteHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}

function scriptsClienteFooter()
{
    return array(

        '<script src="' . base_url('assets/js/clientes/formulario-cliente.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('vendors/choices/choices.min.js') . '"></script>',
        '<script src="' . base_url('assets/js/validacoes.js') . '"></script>',
        '<script src="' . base_url('assets/js/etiqueta-cliente/formulario-etiqueta-cliente.js') . '"></script>',
        '<script src="' . base_url('assets/js/recipiente-cliente/formulario-recipiente-cliente.js') . '"></script>',
        '<script src="' . base_url('assets/js/email-cliente/formulario-email-cliente.js') . '"></script>',
        '<script src="' . base_url('assets/js/residuo-cliente/formulario-residuo-cliente.js') . '"></script>',
        '<script src="' . base_url('assets/js/grupo-cliente/formulario-grupo-cliente.js') . '"></script>',
        '<script src="' . base_url('assets/js/setores-empresa-cliente/formulario-setores-empresa-cliente.js') . '"></script>',
        '<script src="' . base_url('assets/js/viacep/viacep-input.js') . '"></script>',
        '<script src="' . base_url('assets/js/validacoes.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-data.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>'

    );
}

// Pagina de clientes sem atividades
function scriptsClientesSemAtividadeHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}

function scriptsClientesSemAtividadeFooter()
{
    return array(

        '<script src="' . base_url('assets/js/clientes/sem-atividade.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('assets/js/validacoes.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-data.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>'

    );
}

// Pagina de etiquetas
function scriptsEtiquetaHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}

function scriptsEtiquetaFooter()
{
    return array(

        '<script src="' . base_url('assets/js/etiquetas/formulario-etiqueta.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>'


    );
}

// Pagina de setores
function scriptsSetorFooter()
{
    return array(

        '<script src="' . base_url('assets/js/setores/formulario-setor.js') . '"></script>'

    );
}
function scriptsCargosFooter()
{
    return array(

        '<script src="' . base_url('assets/js/cargos/formulario-cargos.js') . '"></script>'

    );
}

// Pagina de Frequencia coleta
function scriptsFrequenciaColetaFooter()
{
    return array(

        '<script src="' . base_url('assets/js/frequencia/frequencia-formulario.js') . '"></script>'

    );
}

// Pagina de recipientes
function scriptsRecipienteFooter()
{
    return array(

        '<script src="' . base_url('assets/js/recipientes/formulario-recipiente.js') . '"></script>'

    );
}

// Pagina de residuos
function scriptsResiduoHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}
function scriptsResiduoFooter()
{
    return array(

        '<script src="' . base_url('assets/js/residuos/formulario-residuo.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>'

    );
}


// Pagina forma pagamento
function scriptsFormaPagamentoFooter()
{
    return array(

        '<script src="' . base_url('assets/js/forma-pagamento/formulario-formapagamento.js') . '"></script>'

    );
}

// pagina de agendamento
function scriptsAgendamentoHead()
{
    return array(

        '<link href="' . base_url('vendors/fullcalendar/main.min.css') . '" rel="stylesheet" />',
        '<link href="' . base_url('assets/css/theme.css') . '" rel="stylesheet" />',
        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}

function scriptsAgendamentoFooter()
{
    return array(

        '<script src="' . base_url('vendors/fullcalendar/main.min.js') . '"></script>',
        '<script src="' . base_url('vendors/dayjs/dayjs.min.js') . '"></script>',
        '<script src="' . base_url('vendors/choices/choices.min.js') . '"></script>',
        '<script src="' . base_url('assets/js/agendamentos/agendamento.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-data.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>'

    );
}

// pagina de login
function scriptsLoginFooter()
{
    return array(

        '<script src="' . base_url('assets/js/login/recupera-senha.js') . '"></script>'
    );
}

function scriptsVeiculosFooter()
{
    return array(

        '<script src="' . base_url('assets/js/veiculos/formulario-veiculos.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('vendors/dropzone/dropzone.min.js') . '"></script>'
    );
}

function scriptsVeiculosHead()
{
    return array(

        '<script src="' . base_url('vendors/dropzone/dropzone.min.css') . '"></script>'
    );
}

// Pagina Dicionario
function scriptsDicionarioHead()
{
    return array(

        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}

function scriptsDicionarioFooter()
{
    return array(

        '<script src="' . base_url('assets/js/dicionario/formulario-dicionario.js') . '"></script>',

    );
}

// Pagina Certificado
function scriptsCertificadosFooter()
{
    return array(

        '<script src="' . base_url('assets/js/certificados/formulario-certificados.js') . '"></script>'

    );
}

function scriptsPermissaoFooter()
{
    return array(

        '<script src="' . base_url('assets/js/permissao/componentes.js') . '"></script>',
    );
}

function scriptsAlertasWhatsappHead()
{
    return array(
        '<script src="https://unpkg.com/picmo@5.7.6/dist/umd/index.js"></script>',
        '<script src="https://unpkg.com/@picmo/popup-picker@5.7.6/dist/umd/index.js"></script>'
    );
}


function scriptsAlertasWhatsappFooter()
{
    return array(

        '<script src="' . base_url('assets/js/alertas-whatsapp/formulario-alertas-whatsapp.js') . '"></script>'
    );
}
function scriptsGruposFooter()
{
    return array(

        '<script src="' . base_url('assets/js/grupos/formulario-grupos.js') . '"></script>'
    );
}

// Pagina de setores empresa
function scriptsSetoresEmpresaFooter()
{
    return array(

        '<script src="' . base_url('assets/js/setores-empresa/formulario-setor-empresa.js') . '"></script>'

    );
}

// Pagina de Micro financeiro empresa
function scriptsFinMicroFooter()
{
    return array(

        '<script src="' . base_url('assets/js/financeiro/micro/formulario-micro.js') . '"></script>'
    );
}

function scriptsFinContaBancariaHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}

function scriptsFinContaBancariaFooter()
{
    return array(

        '<script src="' . base_url('assets/js/financeiro/conta-bancaria/formulario-conta-bancaria.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>'
    );
}

// Pagina de fluxo de caixa financeiro
function scriptsFinFluxoHead()
{
    return array(
        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}
function scriptsFinFluxoFooter()
{
    return array(
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/selecionar-todos-elementos.js') . '"></script>',
        '<script src="' . base_url('assets/js/financeiro/fluxo-caixa/fluxo-caixa.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-data.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-moeda-real.js') . '"></script>'


    );
}

function scriptsFinDadosFinanceirosHead()
{
    return array(
        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />',
    );
}

function scriptsFinDadosFinanceirosFooter()
{
    return array(
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/financeiro/dados-financeiros/formulario-dados-financeiros.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('assets/js/viacep/viacep-input.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
    );
}


// Pagina de contas a pagar financeiro
function scriptsFinContasPagarHead()
{
    return array(

        '<link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.0.8/af-2.7.0/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/cr-2.0.3/date-1.5.2/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/rg-1.5.0/rr-1.5.0/sc-2.4.3/sb-1.7.1/sp-2.3.1/sl-2.0.3/sr-1.4.1/datatables.min.css" rel="stylesheet">',
        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}

function scriptsFinContasPagarFooter()
{
    return array(
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-data.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('assets/js/financeiro/contas-pagar/contas-pagar.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/carregar-select2.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/selecionar-todos-elementos.js') . '"></script>'

    );
}

//Pagina tarifas bancarias
function scriptsFinTarifasBancariasHead()
{
    return array(
        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />'
    );
}


function scriptsFinTarifasBancariasFooter()
{
    return array(
        '<script src="' . base_url('/assets/js/financeiro/tarifas-bancarias/formulario-tarifas-bancarias.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>'
    );
}
// Pagina de contas a receber financeiro
function scriptsFinContasReceberHead()
{
    return array(
        '<link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.0.8/af-2.7.0/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/cr-2.0.3/date-1.5.2/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/rg-1.5.0/rr-1.5.0/sc-2.4.3/sb-1.7.1/sp-2.3.1/sl-2.0.3/sr-1.4.1/datatables.min.css" rel="stylesheet">',
        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />',

    );
}

function scriptsFinContasReceberFooter()
{
    return array(

        '<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>',
        '<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>',
        '<script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.0.8/af-2.7.0/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/cr-2.0.3/date-1.5.2/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/rg-1.5.0/rr-1.5.0/sc-2.4.3/sb-1.7.1/sp-2.3.1/sl-2.0.3/sr-1.4.1/datatables.min.js"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-data.js') . '"></script>',
        '<script src="' . base_url('assets/js/financeiro/contas-receber/contas-receber.js') . '"></script>'

    );
}

// Pagina de macro

function scriptsFinMacroFooter()
{
    return array(
        '<script src="' . base_url('assets/js/financeiro/macro/formulario-macro.js') . '"></script>'
    );
}

// Pagina de contas recorrentes
function scriptsFinContasRecorrentesHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />',

    );
}

function scriptsFinContasRecorrentesFooter()
{
    return array(
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-data.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('assets/js/financeiro/contas-recorrentes/contas-recorrentes.js') . '"></script>'

    );
}

// Pagina de DRE
function scriptsFinDreFooter()
{
    return array(
        '<script src="' . base_url('assets/js/helpers-js/formatar-moeda-real.js') . '"></script>',
        '<script src="' . base_url('assets/js/financeiro/dre/dre.js') . '"></script>'
    );
}

// Pagina de Prestação de contas
function scriptsFinPrestacaoContasHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />',

    );
}

function scriptsFinPrestacaoContasFooter()
{
    return array(
        '<script src="' . base_url('assets/js/helpers-js/formatar-moeda-real.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-data.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('assets/js/financeiro/prestacao-contas/prestacao-contas.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/carregar-select2.js') . '"></script>'

    );
}
function scriptsFinTiposCustosFooter()
{
    return array(

        '<script src="' . base_url('assets/js/financeiro/tipos-custos/formulario-tipos-custos.js') . '"></script>'

    );
}
// Pagina de Documentos Empresa

function scriptsDocumentoEmpresaFooter()
{
    return array(

        '<script src="' . base_url('assets/js/documento-empresa/formulario-documento-empresa.js') . '"></script>'

    );
}
function scriptsTipoOrigemCadastroFooter()
{
    return array(

        '<script src="' . base_url('assets/js/tipo-origem-cadastro/formulario-tipo-origem-cadastro.js') . '"></script>'

    );
}


// Pagina de trajeto
function scriptsTrajetoHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}

function scriptsTrajetoFooter()
{
    return array(

        '<script src="' . base_url('assets/js/trajetos/trajetos.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>'


    );
}

// Pagina de aferição
function scriptsAfericaoHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}

function scriptsAfericaoFooter()
{
    return array(
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('assets/js/afericao/afericao.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-moeda-real.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-data.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/carregar-select2.js') . '"></script>',
        '<script src="' . base_url('assets/js/residuos/estoque.js') . '"></script>',
        '<script src="' . base_url('assets/js/financeiro/prestacao-contas/prestacao-contas.js') . '"></script>'


    );
}

// Pagina de conversao de unidade de medida
function scriptsConversaoUnidadeMedidaHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}

function scriptsConversaoUnidadeMedidaFooter()
{
    return array(
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-moeda-real.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-data.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/carregar-select2.js') . '"></script>',
        '<script src="' . base_url('assets/js/conversao-unidades-medidas/conversao-medidas.js') . '"></script>'
    );
}


// Pagina de estoque de residuos
function scriptsEstoqueResiduosHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}
function scriptsEstoqueResiduosFooter()
{
    return array(
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('assets/js/helpers-js/carregar-select2.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-moeda-real.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('assets/js/residuos/estoque.js') . '"></script>',
        '<script src="' . base_url('assets/js/vendas/vendas-residuos.js') . '"></script>',

    );
}


// Pagina de vendas
function scriptsVendasHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}
function scriptsVendasFooter()
{
    return array(
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('assets/js/helpers-js/carregar-select2.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-moeda-real.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('assets/js/vendas/vendas-residuos.js') . '"></script>',

    );
}


// Pagina de aferição de terceiros
function scriptsAfericaoTerceirosHead()
{
    return array(

        '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />',
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />'

    );
}

function scriptsAfericaoTerceirosFooter()
{
    return array(
        '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
        '<script src="' . base_url('assets/js/helpers-js/carregar-select2.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-moeda-real.js') . '"></script>',
        '<script src="' . base_url('assets/js/helpers-js/formatar-data.js') . '"></script>',
        '<script src="' . base_url('assets/js/afericao/terceiros.js') . '"></script>'
    );
}