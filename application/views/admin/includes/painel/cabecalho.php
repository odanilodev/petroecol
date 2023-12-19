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
                <div class="search-box navbar-top-search-box d-none" data-list='{"valueNames":["title"]}' style="width:25rem;">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                        <input class="form-control search-input fuzzy-search rounded-pill form-control-sm" type="search" placeholder="Search..." aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>

                    </form>
                    <div class="btn-close position-absolute end-0 top-50 translate-middle cursor-pointer shadow-none" data-bs-dismiss="search">
                        <button class="btn btn-link btn-close-falcon p-0" aria-label="Close"></button>
                    </div>
                    <div class="dropdown-menu border border-300 font-base start-0 py-0 overflow-hidden w-100">
                        <div class="scrollbar-overlay" style="max-height: 30rem;">
                            <div class="list pb-3">
                                <h6 class="dropdown-header text-1000 fs--2 py-2">24 <span class="text-500">results</span></h6>
                                <hr class="text-200 my-0" />
                                <h6 class="dropdown-header text-1000 fs--1 border-bottom border-200 py-2 lh-sm">Recently Searched </h6>
                                <div class="py-2"><a class="dropdown-item" href="apps/e-commerce/landing/product-details.html">
                                        <div class="d-flex align-items-center">

                                            <div class="fw-normal text-1000 title"><span class="fa-solid fa-clock-rotate-left" data-fa-transform="shrink-2"></span> Store Macbook</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="apps/e-commerce/landing/product-details.html">
                                        <div class="d-flex align-items-center">

                                            <div class="fw-normal text-1000 title"> <span class="fa-solid fa-clock-rotate-left" data-fa-transform="shrink-2"></span> MacBook Air - 13″</div>
                                        </div>
                                    </a>

                                </div>
                                <hr class="text-200 my-0" />
                                <h6 class="dropdown-header text-1000 fs--1 border-bottom border-200 py-2 lh-sm">Products</h6>
                                <div class="py-2"><a class="dropdown-item py-2 d-flex align-items-center" href="apps/e-commerce/landing/product-details.html">
                                        <div class="file-thumbnail me-2"><img class="h-100 w-100 fit-cover rounded-3" src="#" alt="" /></div>
                                        <div class="flex-1">
                                            <h6 class="mb-0 text-1000 title">MacBook Air - 13″</h6>
                                            <p class="fs--2 mb-0 d-flex text-700"><span class="fw-medium text-600">8GB Memory - 1.6GHz - 128GB Storage</span></p>
                                        </div>
                                    </a>
                                    <a class="dropdown-item py-2 d-flex align-items-center" href="apps/e-commerce/landing/product-details.html">
                                        <div class="file-thumbnail me-2"><img class="img-fluid" src="#" alt="" /></div>
                                        <div class="flex-1">
                                            <h6 class="mb-0 text-1000 title">MacBook Pro - 13″</h6>
                                            <p class="fs--2 mb-0 d-flex text-700"><span class="fw-medium text-600 ms-2">30 Sep at 12:30 PM</span></p>
                                        </div>
                                    </a>

                                </div>
                                <hr class="text-200 my-0" />
                                <h6 class="dropdown-header text-1000 fs--1 border-bottom border-200 py-2 lh-sm">Quick Links</h6>
                                <div class="py-2"><a class="dropdown-item" href="apps/e-commerce/landing/product-details.html">
                                        <div class="d-flex align-items-center">

                                            <div class="fw-normal text-1000 title"><span class="fa-solid fa-link text-900" data-fa-transform="shrink-2"></span> Support MacBook House</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="apps/e-commerce/landing/product-details.html">
                                        <div class="d-flex align-items-center">

                                            <div class="fw-normal text-1000 title"> <span class="fa-solid fa-link text-900" data-fa-transform="shrink-2"></span> Store MacBook″</div>
                                        </div>
                                    </a>

                                </div>
                                <hr class="text-200 my-0" />
                                <h6 class="dropdown-header text-1000 fs--1 border-bottom border-200 py-2 lh-sm">Files</h6>
                                <div class="py-2"><a class="dropdown-item" href="apps/e-commerce/landing/product-details.html">
                                        <div class="d-flex align-items-center">

                                            <div class="fw-normal text-1000 title"><span class="fa-solid fa-file-zipper text-900" data-fa-transform="shrink-2"></span> Library MacBook folder.rar</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="apps/e-commerce/landing/product-details.html">
                                        <div class="d-flex align-items-center">

                                            <div class="fw-normal text-1000 title"> <span class="fa-solid fa-file-lines text-900" data-fa-transform="shrink-2"></span> Feature MacBook extensions.txt</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="apps/e-commerce/landing/product-details.html">
                                        <div class="d-flex align-items-center">

                                            <div class="fw-normal text-1000 title"> <span class="fa-solid fa-image text-900" data-fa-transform="shrink-2"></span> MacBook Pro_13.jpg</div>
                                        </div>
                                    </a>

                                </div>
                                <hr class="text-200 my-0" />
                                <h6 class="dropdown-header text-1000 fs--1 border-bottom border-200 py-2 lh-sm">Members</h6>
                                <div class="py-2"><a class="dropdown-item py-2 d-flex align-items-center" href="pages/members.html">
                                        <div class="avatar avatar-l status-online  me-2 text-900">
                                            <img class="rounded-circle " src="#" alt="" />

                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-0 text-1000 title">Carry Anna</h6>
                                            <p class="fs--2 mb-0 d-flex text-700">anna@technext.it</p>
                                        </div>
                                    </a>
                                    <a class="dropdown-item py-2 d-flex align-items-center" href="pages/members.html">
                                        <div class="avatar avatar-l  me-2 text-900">
                                            <img class="rounded-circle " src="#" alt="" />

                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-0 text-1000 title">John Smith</h6>
                                            <p class="fs--2 mb-0 d-flex text-700">smith@technext.it</p>
                                        </div>
                                    </a>

                                </div>
                                <hr class="text-200 my-0" />
                                <h6 class="dropdown-header text-1000 fs--1 border-bottom border-200 py-2 lh-sm">Related Searches</h6>
                                <div class="py-2"><a class="dropdown-item" href="apps/e-commerce/landing/product-details.html">
                                        <div class="d-flex align-items-center">

                                            <div class="fw-normal text-1000 title"><span class="fa-brands fa-firefox-browser text-900" data-fa-transform="shrink-2"></span> Search in the Web MacBook</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="apps/e-commerce/landing/product-details.html">
                                        <div class="d-flex align-items-center">

                                            <div class="fw-normal text-1000 title"> <span class="fa-brands fa-chrome text-900" data-fa-transform="shrink-2"></span> Store MacBook″</div>
                                        </div>
                                    </a>

                                </div>
                            </div>
                            <div class="text-center">
                                <p class="fallback fw-bold fs-1 d-none">No Result Found.</p>
                            </div>
                        </div>
                    </div>
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

                    <li class="nav-item dropdown d-none">
                        <a class="nav-link" id="navbarDropdownNindeDots" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" data-bs-auto-close="outside" aria-expanded="false">
                            <svg width="16" height="16" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                                <circle cx="2" cy="8" r="2" fill="currentColor"></circle>
                                <circle cx="2" cy="14" r="2" fill="currentColor"></circle>
                                <circle cx="8" cy="8" r="2" fill="currentColor"></circle>
                                <circle cx="8" cy="14" r="2" fill="currentColor"></circle>
                                <circle cx="14" cy="8" r="2" fill="currentColor"></circle>
                                <circle cx="14" cy="14" r="2" fill="currentColor"></circle>
                                <circle cx="8" cy="2" r="2" fill="currentColor"></circle>
                                <circle cx="14" cy="2" r="2" fill="currentColor"></circle>
                            </svg></a>

                        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-nide-dots shadow border border-300" aria-labelledby="navbarDropdownNindeDots">
                            <div class="card bg-white position-relative border-0">
                                <div class="card-body pt-3 px-3 pb-0 overflow-auto scrollbar" style="height: 20rem;">
                                    <div class="row text-center align-items-center gx-0 gy-0">
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Behance</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Cloud</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Slack</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Gitlab</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="<?= base_url('') ?>assets/img/nav-icons/bitbucket.webp" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">BitBucket</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Drive</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Trello</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="20" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Figma</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Twitter</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Pinterest</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Linkedin</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Maps</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Photos</p>
                                            </a></div>
                                        <div class="col-4"><a class="d-block hover-bg-200 p-2 rounded-3 text-center text-decoration-none mb-3" href="#!"><img src="#" alt="" width="30" />
                                                <p class="mb-0 text-black text-truncate fs--2 mt-1 pt-1">Spotify</p>
                                            </a></div>
                                    </div>
                                </div>
                            </div>
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