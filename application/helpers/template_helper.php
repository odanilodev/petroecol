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


function scriptsGeralHead()
{
    return array(
        '<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">',
        '<link href="' . base_url() . 'vendors/simplebar/simplebar.min.css" rel="stylesheet">',
        '<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">',
        '<link href="' . base_url() . 'assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl">',
        '<link href="' . base_url() . 'assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">',
        '<link href="' . base_url() . 'assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">',
        '<link href="' . base_url() . 'assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">',
        '<link href="' . base_url() . 'assets/img/favicons/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180>"',
        '<link href="' . base_url() . 'assets/img/favicons/favicon-32x32.png" rel="icon" type="image/png" sizes="32x32">',
        '<link href="' . base_url() . 'assets/img/favicons/favicon-16x16.png" rel="icon" type="image/png" sizes="16x16">',
        '<link href="' . base_url() . 'assets/img/favicons/favicon.ico" rel="shortcut icon" type="image/x-icon">',
        '<link href="' . base_url() . 'assets/img/favicons/manifest.json" rel="manifest">',
        '<script src="' . base_url() . 'vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>',
        '<script src="' . base_url() . 'vendors/simplebar/simplebar.min.js"></script>',
        '<script src="' . base_url() . 'assets/js/config.js"></script>',
        '<link href="' . base_url() . 'vendors/leaflet/leaflet.css" rel="stylesheet">',
        '<link href="' . base_url() . 'vendors/leaflet.markercluster/MarkerCluster.css" rel="stylesheet">',
        '<link href="' . base_url() . 'vendors/leaflet.markercluster/MarkerCluster.Default.css" rel="stylesheet">'

    );
}

function scriptsGeralFooter()
{
    return array(
        '<script src="' . base_url() . 'vendors/popper/popper.min.js"></script>',
        '<script src="' . base_url() . 'vendors/bootstrap/bootstrap.min.js"></script>',
        '<script src="' . base_url() . 'vendors/anchorjs/anchor.min.js"></script>',
        '<script src="' . base_url() . 'vendors/is/is.min.js"></script>',
        '<script src="' . base_url() . 'vendors/fontawesome/all.min.js"></script>',
        '<script src="' . base_url() . 'vendors/lodash/lodash.min.js"></script>',
        '<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>',
        '<script src="' . base_url() . 'vendors/list.js/list.min.js"></script>',
        '<script src="' . base_url() . 'vendors/feather-icons/feather.min.js"></script>',
        '<script src="' . base_url() . 'vendors/dayjs/dayjs.min.js"></script>',
        '<script src="' . base_url() . 'assets/js/phoenix.js"></script>',
        '<script src="' . base_url() . 'vendors/echarts/echarts.min.js"></script>',
        '<script src="' . base_url() . 'vendors/leaflet/leaflet.js"></script>',
        '<script src="' . base_url() . 'vendors/leaflet.markercluster/leaflet.markercluster.js"></script>',
        '<script src="' . base_url() . 'vendors/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js"></script>',
        '<script src="' . base_url() . 'assets/js/ecommerce-dashboard.js"></script>'
    );
}

function scriptsLoginHead()
{
    return array(
        '<script src="' . base_url('assets/js/config.js') . '"></script>',
        '<link rel="preconnect" href="https://fonts.googleapis.com">',
        '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">',
        '<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">',
        '<link href="' . base_url('vendors/simplebar/simplebar.min.css') . '" rel="stylesheet">',
        '<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">',
        '<link href="' . base_url('assets/css/theme-rtl.min.css') . '" type="text/css" rel="stylesheet" id="style-rtl">',
        '<link href="' . base_url('assets/css/theme.min.css') . '" type="text/css" rel="stylesheet" id="style-default">',
        '<link href="' . base_url('assets/css/user-rtl.min.css') . '" type="text/css" rel="stylesheet" id="user-style-rtl">',
        '<link href="' . base_url('assets/css/user.min.css') . '" type="text/css" rel="stylesheet" id="user-style-default">',
        '<script src="' . base_url('node_modules/sweetalert2/dist/sweetalert2.all.min.js') . '"></script>'
    );
}

function scriptsLoginFooter()
{
    return array(

        '<script src="' . base_url('vendors/jquery/jquery.min.js') . '"></script>',
        '<script src="' . base_url('vendors/bootstrap/bootstrap.min.js') . '"></script>',
        '<script src="' . base_url('vendors/anchorjs/anchor.min.js') . '"></script>',
        '<script src="' . base_url('vendors/is/is.min.js') . '"></script>',
        '<script src="' . base_url('vendors/fontawesome/all.min.js') . '"></script>',
        '<script src="' . base_url('vendors/lodash/lodash.min.js') . '"></script>',
        '<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>',
        '<script src="' . base_url('vendors/list.js/list.min.js') . '"></script>',
        '<script src="' . base_url('vendors/feather-icons/feather.min.js') . '"></script>',
        '<script src="' . base_url('vendors/dayjs/dayjs.min.js') . '"></script>',
        '<script src="' . base_url('assets/js/phoenix.js') . '"></script>',
        '<script src="' . base_url('assets/js/login/recupera-senha.js') . '"></script>'
    );
}

function scriptsUsuarioHead()
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
        '<link href="' . base_url('assets/css/theme.min.css') . '" type="text/css" rel="stylesheet" id="style-default">',
        '<link href="' . base_url('assets/css/user-rtl.min.css') . '" type="text/css" rel="stylesheet" id="user-style-rtl">',
        '<link href="' . base_url('assets/css/user.min.css') . '" type="text/css" rel="stylesheet" id="user-style-default">',
        '<link href="' . base_url('assets/css/upload-arquivo.css') . '" type="text/css" rel="stylesheet" id="user-style-default">'

    );
}

function scriptsUsuarioFooter()
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
        '<script src="' . base_url('assets/js/usuarios/formulario-usuario.js') . '"></script>',
        '<script src="' . base_url('node_modules/sweetalert2/dist/sweetalert2.all.min.js') . '"></script>',
        '<script src="' . base_url('assets/js/upload-imagem.js') . '"></script>'

    );
}