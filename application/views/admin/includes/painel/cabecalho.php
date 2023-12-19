<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="msapplication-TileImage" content="#">
    <meta name="theme-color" content="#ffffff">

    <title>Petroecol</title>

    <!-- Links header -->
    <?php header_scripts(); ?>

    <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>

</head>


<body>

    <input type="hidden" value="<?= base_url(); ?>" class="base-url">

    <input type="hidden" value="<?= $this->session->flashdata('tipo_retorno_funcao'); ?>" class="retorno-funcao" data-texto="<?= $this->session->flashdata('texto_retorno_funcao'); ?>" data-titulo="<?= $this->session->flashdata('titulo_retorno_funcao'); ?>" data-redirect="<?= $this->session->flashdata('redirect_retorno_funcao'); ?>">

    <main class="main" id="top">

        <nav class="navbar navbar-vertical navbar-expand-lg">
            <script>
                var navbarStyle = window.config.config.phoenixNavbarStyle;
                if (navbarStyle && navbarStyle !== 'transparent') {
                    document.querySelector('body').classList.add(`navbar-${navbarStyle}`);
                }
            </script>
            <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                <!-- scrollbar removed-->
                <div class="navbar-vertical-content">
                    <ul class="navbar-nav flex-column" id="navbarVerticalNav">

                        <li class="nav-item">
                            <!-- label-->
                            <!-- <p class="navbar-vertical-label">Documentation</p> -->
                            <hr class="navbar-vertical-line" />
                            <!-- parent pages-->
                            <div class="nav-item-wrapper">
                                <?php

                                foreach ($this->session->userdata('menu') as $v) : // Todos os menus do sistema
                                    if (in_array($v['id'], $this->session->userdata('permissao'))) { // Apenas os menu liberado para o usuário logado
                                        if (!empty($v['icone'])) : // Mostrar quando ter icone

                                            if (!empty($v['link'])) { // categoria normal 
                                ?>
                                                <a class="nav-link label-1" href="<?= base_url($v['link']) ?>" role="button" data-bs-toggle="" aria-expanded="false">
                                                    <div class="d-flex align-items-center">
                                                        <span class="nav-link-icon">
                                                            <span <?= $v['icone'] ?>></span>
                                                        </span>
                                                        <span class="nav-link-text-wrapper">
                                                            <span class="nav-link-text"><?= $v['nome'] ?></span>
                                                        </span>
                                                    </div>
                                                </a>
                                            <?php } else { // categoria PAI - FILHOS 
                                            ?>

                                                <div class="nav-item-wrapper">

                                                    <a class="nav-link dropdown-indicator label-1" href="#nv-faq" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-faq">
                                                        <div class="d-flex align-items-center">
                                                            <div class="dropdown-indicator-icon">
                                                                <span class="fas fa-caret-right"></span>
                                                            </div>
                                                            <span class="nav-link-icon">
                                                                <span <?= $v['icone'] ?>></span>
                                                            </span>
                                                            <span class="nav-link-text"><strong><?= $v['nome'] ?></strong></span>
                                                        </div>
                                                    </a>

                                                    <div class="parent-wrapper label-1">
                                                        <ul class="nav parent collapse" data-bs-parent="#navbarVerticalCollapse" id="nv-faq">

                                                            <?php foreach ($v['sub_menus'] as $sub) { // Sub menu

                                                                if (in_array($sub['id'], $this->session->userdata('permissao'))) { // Sub menus com permissão para o usuário

                                                            ?>

                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="<?= base_url($sub['link']) ?>" data-bs-toggle="" aria-expanded="false">
                                                                            <div class="d-flex align-items-center">
                                                                                <span class="nav-link-text">- <?= $sub['nome'] ?></span>
                                                                            </div>
                                                                        </a>
                                                                    </li>

                                                            <?php }
                                                            } ?>
                                                        </ul>
                                                    </div>

                                    <?php }

                                        endif;
                                    }
                                endforeach; ?>

                                                </div>

                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbar-vertical-footer">
                <button class="btn navbar-vertical-toggle border-0 fw-semi-bold w-100 white-space-nowrap d-flex align-items-center"><span class="uil uil-left-arrow-to-left fs-0"></span><span class="uil uil-arrow-from-right fs-0"></span><span class="navbar-vertical-footer-text ms-2">Esconder Menu</span></button>
            </div>
        </nav>
        <nav class="navbar navbar-top fixed-top navbar-expand" id="navbarDefault">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="navbar-logo">

                    <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
                    <a class="navbar-brand me-1 me-sm-3" href="<?= base_url('dashboard') ?>">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="" style="max-width: 180px;" class="img-fluid logo" />
                                <!-- <p class="logo-text ms-2 d-none d-sm-block">phoenix</p> -->
                            </div>
                        </div>
                    </a>
                </div>
                <ul class="navbar-nav navbar-nav-icons flex-row">

                    <?php require_once('notificacoes.php'); ?>

                    <li class="nav-item">
                        <div class="theme-control-toggle fa-icon-wait px-2">
                            <input class="form-check-input ms-0 theme-control-toggle-input" type="checkbox" data-theme-control="phoenixTheme" value="dark" id="themeControlToggle" />
                            <label class="altera-logo-tema mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Alterar Tema"><span class="icon" data-feather="moon"></span></label>
                            <label class="altera-logo-tema mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Alterar Tema"><span class="icon" data-feather="sun"></span></label>
                        </div>
                    </li>

                    <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-l ">
                                <img class="rounded-circle " src="<?= $this->session->userdata('foto_perfil') != '' ? base_url_upload('usuarios/') . $this->session->userdata('foto_perfil') : base_url('assets/img/icons/sem_foto.jpg') ?>" alt="" />

                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border border-300" aria-labelledby="navbarDropdownUser">
                            <div class="card position-relative border-0">
                                <div class="card-body p-0">
                                    <div class="text-center pt-4 pb-3">
                                        <div class="avatar avatar-xl ">
                                            <img class="rounded-circle " src="<?= $this->session->userdata('foto_perfil') != '' ? base_url_upload('usuarios/') . $this->session->userdata('foto_perfil') : base_url('assets/img/icons/sem_foto.jpg') ?>" alt="" />
                                        </div>
                                        <h6 class="mt-2 text-black"><?= $this->session->userdata('nome_usuario'); ?></h6>
                                    </div>

                                </div>
                                <div class="overflow-auto scrollbar">
                                    <ul class="nav d-flex flex-column mb-2 pb-1">
                                        <?php if ($this->session->userdata("id_setor") != 0) { ?>
                                            <li class="nav-item"><a class="nav-link px-3" href="<?= base_url('usuarios/formulario/' . $this->session->userdata("id_usuario")) ?>"> <span class="me-2 text-900" data-feather="user"></span><span>Perfil</span></a></li>
                                            <li class="nav-item"><a class="nav-link px-3" href="https://api.whatsapp.com/send?l=pt_br&phone=5514997501274"> <span class="me-2 text-900" data-feather="help-circle"></span>Central de Ajuda</a></li>
                                        <?php } ?>
                                        <li class="nav-item"><a class="nav-link px-3" href="<?= base_url('dashboard') ?>"><span class="me-2 text-900" data-feather="pie-chart"></span>Painel Principal</a></li>
                                        <li class="nav-item"><a class="nav-link px-3" href="<?= base_url('usuarios/formulario') ?>"><span class="me-2 text-900" data-feather="user-plus"></span>Criar outra conta</a></li>
                                        <!-- <li class="nav-item"><a class="nav-link px-3" href="#!"> <span class="me-2 text-900" data-feather="settings"></span>Politica de Privacidade</a></li> -->

                                    </ul>
                                </div>
                                <div class="card-footer p-3 border-top">
                                    <div class="px-3"> <a class="btn btn-phoenix-secondary d-flex flex-center w-100" href="<?= base_url('login/sair') ?>"> <span class="me-2" data-feather="log-out"> </span>Sair</a></div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>