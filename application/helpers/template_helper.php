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
        '<link rel="preconnect" href="https://fonts.googleapis.com">',
        '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">',
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
        '<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>',
        '<script src="' . base_url('vendors/list.js/list.min.js') . '"></script>',
        '<script src="' . base_url('vendors/feather-icons/feather.min.js') . '"></script>',
        '<script src="' . base_url('vendors/dayjs/dayjs.min.js') . '"></script>',
        '<script src="' . base_url('vendors/dropzone/dropzone.min.js') . '"></script>',
        '<script src="' . base_url('vendors/prism/prism.js') . '"></script>',
        '<script src="' . base_url('assets/js/phoenix.js') . '"></script>',
        '<script src="' . base_url('node_modules/sweetalert2/dist/sweetalert2.all.min.js') . '"></script>',
        '<script src="' . base_url('assets/js/alertas/alertas-retornos.js') . '"></script>',
        '<script type="module" src="' . base_url('assets/js/flatpickr.js') . '"></script>'
    );
}


// pagina de usuario
function scriptsUsuarioHead()
{
    return array(

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
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>'

    );
}


// pagina de motorista
function scriptsMotoristaHead()
{
    return array(

        '<link href="' . base_url('assets/css/upload-arquivo.css') . '" type="text/css" rel="stylesheet" id="user-style-default">',

    );
}

function scriptsMotoristaFooter()
{
    return array(

        '<script src="' . base_url('assets/js/motoristas/formulario-motoristas.js') . '"></script>',
        '<script src="' . base_url('assets/js/upload-imagem.js') . '"></script>',
        '<script src="' . base_url('node_modules/jquery-mask-plugin/src/jquery.mask.js') . '"></script>',
        '<script src="' . base_url('assets/js/mascaras/mascaras-input.js') . '"></script>'

    );
}

// Pagina de clientes
function scriptsClienteHead()
{
    return array(
        '<link href="' . base_url('vendors/choices/choices.min.css') . '" rel="stylesheet" />'
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
        '<script src="' . base_url('assets/js/residuo-cliente/formulario-residuo-cliente.js') . '"></script>'

    );
}

// Pagina de etiquetas
function scriptsEtiquetaFooter()
{
    return array(

        '<script src="' . base_url('assets/js/etiquetas/formulario-etiqueta.js') . '"></script>'

    );
}

// Pagina de setores
function scriptsSetorFooter()
{
    return array(

        '<script src="' . base_url('assets/js/setores/formulario-setor.js') . '"></script>'

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
function scriptsResiduoFooter()
{
    return array(

        '<script src="' . base_url('assets/js/residuos/formulario-residuo.js') . '"></script>'

    );
}

// pagina de agendamento
function scriptsAgendamentoHead()
{
    return array(

        '<link href="' . base_url('vendors/fullcalendar/main.min.css') . '" rel="stylesheet" />',
        '<link href="' . base_url('assets/css/theme.css') . '" rel="stylesheet" />',
        '<link href="' . base_url('vendors/choices/choices.min.css') . '" rel="stylesheet" />'
        
    );
}

function scriptsAgendamentoFooter()
{
    return array(

        '<script src="' . base_url('vendors/fullcalendar/main.min.js') . '"></script>',
        '<script src="' . base_url('vendors/dayjs/dayjs.min.js') . '"></script>',
        '<script src="' . base_url('vendors/choices/choices.min.js') . '"></script>',
        '<script src="' . base_url('assets/js/calendar.js') . '"></script>',
        '<script src="' . base_url('assets/js/agendamentos/formulario-agendamento.js') . '"></script>'
    );
}

// pagina de login
function scriptsLoginFooter()
{
    return array(

        '<script src="' . base_url('assets/js/login/recupera-senha.js') . '"></script>'
    );
}
