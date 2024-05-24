<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets\img\favicons\icone4.png') ?>">
    <meta name="msapplication-TileImage" content="#">
    <meta name="theme-color" content="#ffffff">

    <title><?= $this->session->userdata('nome_empresa') ?? 'Login'; ?></title>

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


<body id="body">

    <!-- Preloader -->
    <div id="preloader" class="dot-spinner">
        <div class="dot-spinner__dot"></div>
        <div class="dot-spinner__dot"></div>
        <div class="dot-spinner__dot"></div>
        <div class="dot-spinner__dot"></div>
    </div>


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

                                                    <a class="nav-link dropdown-indicator label-" href="#ref-<?= $v['id'] ?>" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-faq">
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
                                                        <ul class="nav parent collapse" data-bs-parent="#navbarVerticalCollapse" id="ref-<?= $v['id'] ?>">

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
                    <a class="navbar-brand me-1 me-sm-3" href="<?= base_url('admin') ?>">
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

                        <div class="theme-control-toggle fa-icon-wait px-2">
                            <input class="form-check-input ms-0 theme-control-toggle-input" type="checkbox" id="alteraFontes" value="<?= isset($_COOKIE['fonte']) ? $_COOKIE['fonte'] : ""?>"/>

                            <label data-fonte="lowercase" class="altera-texto-tema altera-texto-lower mb-0 theme-control-toggle-label theme-control-toggle-dark" data-bs-toggle="tooltip" data-bs-placement="left" title="Alterar Fontes" for="alteraFontes">

                                <span class="icon icone-minusculo">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-alphabet" viewBox="0 0 16 16">
                                        <path d="M2.204 11.078c.767 0 1.201-.356 1.406-.737h.059V11h1.216V7.519c0-1.314-.947-1.783-2.11-1.783C1.355 5.736.75 6.42.69 7.27h1.216c.064-.323.313-.552.84-.552s.864.249.864.771v.464H2.346C1.145 7.953.5 8.568.5 9.496c0 .977.693 1.582 1.704 1.582m.42-.947c-.44 0-.845-.235-.845-.718 0-.395.269-.684.84-.684h.991v.538c0 .503-.444.864-.986.864m5.593.937c1.216 0 1.948-.869 1.948-2.31v-.702c0-1.44-.727-2.305-1.929-2.305-.742 0-1.328.347-1.499.889h-.063V3.983h-1.29V11h1.27v-.791h.064c.21.532.776.86 1.499.86Zm-.43-1.025c-.66 0-1.113-.518-1.113-1.28V8.12c0-.825.42-1.343 1.098-1.343.684 0 1.075.518 1.075 1.416v.45c0 .888-.386 1.401-1.06 1.401Zm2.834-1.328c0 1.47.87 2.378 2.305 2.378 1.416 0 2.139-.777 2.158-1.763h-1.186c-.06.425-.313.732-.933.732-.66 0-1.05-.512-1.05-1.352v-.625c0-.81.371-1.328 1.045-1.328.635 0 .879.425.918.776h1.187c-.02-.986-.787-1.806-2.14-1.806-1.41 0-2.304.918-2.304 2.338z" />
                                    </svg>
                                </span>

                                <span class="icon icone-maiusculo d-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                        <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                    </svg>
                                </span>

                            </label>

                            <label data-fonte="uppercase" class="altera-texto-tema mb-0 theme-control-toggle-label theme-control-toggle-light" for="alteraFontes" data-bs-toggle="tooltip" data-bs-placement="left" title="Alterar Fontes">
                                <span class="icon icone-minusculo">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-alphabet" viewBox="0 0 16 16">
                                        <path d="M2.204 11.078c.767 0 1.201-.356 1.406-.737h.059V11h1.216V7.519c0-1.314-.947-1.783-2.11-1.783C1.355 5.736.75 6.42.69 7.27h1.216c.064-.323.313-.552.84-.552s.864.249.864.771v.464H2.346C1.145 7.953.5 8.568.5 9.496c0 .977.693 1.582 1.704 1.582m.42-.947c-.44 0-.845-.235-.845-.718 0-.395.269-.684.84-.684h.991v.538c0 .503-.444.864-.986.864m5.593.937c1.216 0 1.948-.869 1.948-2.31v-.702c0-1.44-.727-2.305-1.929-2.305-.742 0-1.328.347-1.499.889h-.063V3.983h-1.29V11h1.27v-.791h.064c.21.532.776.86 1.499.86Zm-.43-1.025c-.66 0-1.113-.518-1.113-1.28V8.12c0-.825.42-1.343 1.098-1.343.684 0 1.075.518 1.075 1.416v.45c0 .888-.386 1.401-1.06 1.401Zm2.834-1.328c0 1.47.87 2.378 2.305 2.378 1.416 0 2.139-.777 2.158-1.763h-1.186c-.06.425-.313.732-.933.732-.66 0-1.05-.512-1.05-1.352v-.625c0-.81.371-1.328 1.045-1.328.635 0 .879.425.918.776h1.187c-.02-.986-.787-1.806-2.14-1.806-1.41 0-2.304.918-2.304 2.338z" />
                                    </svg>
                                </span>

                                <span class="icon icone-maiusculo d-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                        <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                    </svg>
                                </span>
                            </label>

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
                                        <h6 class="mt-2 text-black"><?= $this->session->userdata('nome_usuario'); ?>
                                        </h6>
                                    </div>

                                </div>
                                <div class="overflow-auto scrollbar">
                                    <ul class="nav d-flex flex-column mb-2 pb-1">
                                        <?php if ($this->session->userdata("id_setor") != 0) { ?>
                                            <li class="nav-item"><a class="nav-link px-3" href="<?= base_url('usuarios/formulario/' . $this->session->userdata("id_usuario")) ?>">
                                                    <span class="me-2 text-900" data-feather="user"></span><span>Perfil</span></a></li>
                                            <li class="nav-item"><a class="nav-link px-3" href="https://api.whatsapp.com/send?l=pt_br&phone=5514997501274"> <span class="me-2 text-900" data-feather="help-circle"></span>Central de
                                                    Ajuda</a></li>
                                        <?php } ?>
                                        <li class="nav-item"><a class="nav-link px-3" href="<?= base_url('dashboard') ?>"><span class="me-2 text-900" data-feather="pie-chart"></span>Painel Principal</a></li>
                                        <li class="nav-item"><a class="nav-link px-3" href="<?= base_url('usuarios/formulario') ?>"><span class="me-2 text-900" data-feather="user-plus"></span>Criar outra
                                                conta</a></li>
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