<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- ===============================================-->
  <!--    Document Title-->
  <!-- ===============================================-->
  <title>Petroecol</title>


  <!-- ===============================================-->
  <!--    Favicons-->
  <!-- ===============================================-->
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/img/favicons/apple-touch-icon.png') ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/img/favicons/favicon-32x32.png') ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/img/favicons/favicon-16x16.png') ?>">
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/favicons/favicon.ico') ?>">
  <link rel="manifest" href="<?= base_url('assets/img/favicons/manifest.json') ?>">
  <meta name="msapplication-TileImage" content="<?= base_url('assets/img/favicons/mstile-150x150.png') ?>">
  <meta name="theme-color" content="#ffffff">
  <script src="<?= base_url('vendors/imagesloaded/imagesloaded.pkgd.min.js') ?>"></script>
  <script src="<?= base_url('vendors/simplebar/simplebar.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/config.js') ?>"></script>


  <!-- ===============================================-->
  <!--    Stylesheets-->
  <!-- ===============================================-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
  <link href="<?= base_url('vendors/simplebar/simplebar.min.css') ?>" rel="stylesheet">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <link href="<?= base_url('assets/css/theme-rtl.min.css') ?>" type="text/css" rel="stylesheet" id="style-rtl">
  <link href="<?= base_url('assets/css/theme.min.css') ?>" type="text/css" rel="stylesheet" id="style-default">
  <link href="<?= base_url('assets/css/user-rtl.min.css') ?>" type="text/css" rel="stylesheet" id="user-style-rtl">
  <link href="<?= base_url('assets/css/user.min.css') ?>" type="text/css" rel="stylesheet" id="user-style-default">
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


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


  <style>
    .btn-login {
      background: #013738;
      color: #fff;
    }

    .btn-login:hover {
      background: #006b6d;
      color: #fff;
    }

    .icon-senha {
      position: absolute;
      right: 15px;
      top: 12px;
      cursor: pointer;
    }
  </style>
</head>


<body>

  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main" id="top">
    <div class="container-fluid bg-300 dark__bg-1200">
      <div class="bg-holder bg-auth-card-overlay" style="background-image:url(<?= base_url('assets/img/bg/37.png') ?>);">
      </div>
      <!--/.bg-holder-->

      <div class="row flex-center position-relative min-vh-100 g-0 py-5">
        <div class="col-11 col-sm-10 col-xl-8">
          <div class="card border border-200 auth-card">
            <div class="card-body pe-md-0">
              <div class="row align-items-center gx-0 gy-7">
                <div class="col-auto bg-100 dark__bg-1100 rounded-3 position-relative overflow-hidden auth-title-box">
                  <div class="bg-holder" style="background-image:url(<?= base_url('assets/img/bg/38.png') ?>);">
                  </div>
                  <!--/.bg-holder-->

                  <div class="position-relative z-index--1 mb-6 d-none d-md-block text-center mt-md-15"><img class="auth-title-box-img d-dark-none" src="<?= base_url() ?>assets/img/spot-illustrations/auth.png" alt="" /><img class="auth-title-box-img d-light-none" src="<?= base_url() ?>assets/img/spot-illustrations/auth-dark.png" alt="" /></div>
                </div>
                <div class="col mx-auto">
                  <div class="auth-form-box">

                    <div class="text-center mb-7"><a class="d-flex flex-center text-decoration-none mb-4" href="<?= base_url('login') ?>">
                        <div class="d-flex align-items-center fw-bolder fs-5 d-inline-block">
                          <img src="<?= base_url('assets/img/icons/logo.png') ?>" alt="phoenix" width="200" class="logo-img" />
                        </div>
                      </a>
                    </div>

                    <div class="position-relative">
                      <hr class="bg-200 mt-5 mb-4" />
                      <div class="divider-content-center bg-white">Acesse com seu login</div>

                      <?php
                        if ($this->session->flashdata('mensagem')) {
                            
                          echo '<div class="p-1 text-center text-light alert alert-' . $this->session->flashdata('tipo_alerta') . '">' . $this->session->flashdata('mensagem') . '</div>';
                        }
                      ?>
                    </div>

                    <form action="<?= base_url('login/recebeLogin') ?>" method="post">

                      <input type="hidden" name="link" value="<?=base_url(uri_string())?>">

                      <div class="mb-3 text-start">
                        <label class="form-label" for="email">Email</label>
                        <div class="form-icon-container">
                          <input name="email" class="form-control form-icon-input" id="email" type="email" placeholder="Digite seu email" />
                          <span class="fas fa-user text-900 fs--1 form-icon"></span>
                        </div>
                      </div>

                      <div class="mb-3 text-start">

                        <label class="form-label" for="password">Senha</label>
                        <div class="form-icon-container">

                          <span class="fas fa-key text-900 fs--1 form-icon"></span>

                          <input name="senha" class="form-control form-icon-input" id="password" type="password" placeholder="Digite sua senha" required />

                          <span onclick="mostrarSenha()" class="far fa-eye-slash text-700 fs--1 form-icodn mostrar-senha icon-senha" title="Mostar Senha"></span>

                          <span onclick="ocultarSenha()" class="far fa-eye text-700 fs--1 form-icodn ocultar-senha icon-senha" title="Ocultar Senha" style="display: none;"></span>

                        </div>

                      </div>

                      <div class="row flex-between-center mb-7">

                        <div class="col-auto">
                          <a class="fs--1 fw-semi-bold" href="<?= base_url('login/esqueceusenha') ?>" style="color: #013738;">Esqueceu a Senha?</a>
                        </div>
                      </div>

                      <input type="submit" class="btn w-100 mb-3 btn-login" value="Acessar">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="support-chat-container">
      <div class="container-fluid support-chat">
        <div class="card bg-white">
          <div class="card-header d-flex flex-between-center px-4 py-3 border-bottom">
            <h5 class="mb-0 d-flex align-items-center gap-2">Demo widget<span class="fa-solid fa-circle text-success fs--3"></span></h5>
            <div class="btn-reveal-trigger">
              <button class="btn btn-link p-0 dropdown-toggle dropdown-caret-none transition-none d-flex" type="button" id="support-chat-dropdown" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h text-900"></span></button>
              <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="support-chat-dropdown"><a class="dropdown-item" href="#!">Request a callback</a><a class="dropdown-item" href="#!">Search in chat</a><a class="dropdown-item" href="#!">Show history</a><a class="dropdown-item" href="#!">Report to Admin</a><a class="dropdown-item btn-support-chat" href="#!">Close Support</a></div>
            </div>
          </div>
          <div class="card-body chat p-0">
            <div class="d-flex flex-column-reverse scrollbar h-100 p-3">
              <div class="text-end mt-6"><a class="mb-2 d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3" href="#!">
                  <p class="mb-0 fw-semi-bold fs--1">I need help with something</p><span class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
                </a><a class="mb-2 d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3" href="#!">
                  <p class="mb-0 fw-semi-bold fs--1">I can’t reorder a product I previously ordered</p><span class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
                </a><a class="mb-2 d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3" href="#!">
                  <p class="mb-0 fw-semi-bold fs--1">How do I place an order?</p><span class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
                </a><a class="false d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3" href="#!">
                  <p class="mb-0 fw-semi-bold fs--1">My payment method not working</p><span class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
                </a>
              </div>
              <div class="text-center mt-auto">
                <div class="avatar avatar-3xl status-online"><img class="rounded-circle border border-3 border-white" src="<?= base_url() ?>assets/img/team/30.webp" alt="" /></div>
                <h5 class="mt-2 mb-3">Eric</h5>
                <p class="text-center text-black mb-0">Ask us anything – we’ll get back to you here or by email within 24 hours.</p>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex align-items-center gap-2 border-top ps-3 pe-4 py-3">
            <div class="d-flex align-items-center flex-1 gap-3 border rounded-pill px-4">
              <input class="form-control outline-none border-0 flex-1 fs--1 px-0" type="text" placeholder="Write message" />
              <label class="btn btn-link d-flex p-0 text-500 fs--1 border-0" for="supportChatPhotos"><span class="fa-solid fa-image"></span></label>
              <input class="d-none" type="file" accept="image/*" id="supportChatPhotos" />
              <label class="btn btn-link d-flex p-0 text-500 fs--1 border-0" for="supportChatAttachment"> <span class="fa-solid fa-paperclip"></span></label>
              <input class="d-none" type="file" id="supportChatAttachment" />
            </div>
            <button class="btn p-0 border-0 send-btn"><span class="fa-solid fa-paper-plane fs--1"></span></button>
          </div>
        </div>
      </div>

    </div>
  </main>
  <!-- ===============================================-->
  <!--    End of Main Content-->
  <!-- ===============================================-->


  <!-- ===============================================-->
  <!--    JavaScripts-->
  <!-- ===============================================-->
  <script src="<?= base_url('vendors/popper/popper.min.js') ?>"></script>
  <script src="<?= base_url('vendors/bootstrap/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('vendors/anchorjs/anchor.min.js') ?>"></script>
  <script src="<?= base_url('vendors/is/is.min.js') ?>"></script>
  <script src="<?= base_url('vendors/fontawesome/all.min.js') ?>"></script>
  <script src="<?= base_url('vendors/lodash/lodash.min.js') ?>"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
  <script src="<?= base_url('vendors/list.js/list.min.js') ?>"></script>
  <script src="<?= base_url('vendors/feather-icons/feather.min.js') ?>"></script>
  <script src="<?= base_url('vendors/dayjs/dayjs.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/phoenix.js') ?>"></script>
  <script src="<?= base_url('vendors/jquery/jquery.min.js') ?>"></script>

  <script>
    const mostrarSenha = (e) => {
      $('.mostrar-senha').css('display', 'none');
      $('.ocultar-senha').css('display', 'block');
      $('#password').attr('type', 'text');
    }

    const ocultarSenha = () => {
      $('.ocultar-senha').css('display', 'none');
      $('.mostrar-senha').css('display', 'block');
      $('#password').attr('type', 'password');
    }
  </script>

  <script>
    	
    setTimeout(function() { 
        
        $(".alert").hide("slow", function(){});
      
    }, 3500);
  </script>
</body>

</html>