<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
  <div class="container-fluid bg-300 dark__bg-1200">
    <div class="bg-holder bg-auth-card-overlay" style="background-image:url(<?= base_url('assets/img/bg/37.png'); ?>);">
    </div>
    <!--/.bg-holder-->

    <input type="hidden" value="<?= base_url(); ?>" class="base-url">

    <div class="row flex-center position-relative min-vh-100 g-0 py-5">
      <div class="col-11 col-sm-10 col-xl-8">
        <div class="card border border-200 auth-card">
          <div class="card-body pe-md-0">
            <div class="row align-items-center gx-0 gy-7">
              <div class="col-auto bg-100 dark__bg-1100 rounded-3 position-relative overflow-hidden auth-title-box">
                <div class="bg-holder" style="background-image:url(<?= base_url('assets/img/bg/38.png'); ?>);"></div>
                <!--/.bg-holder-->

                <div class="position-relative z-index--1 mb-6 d-none d-md-block text-center mt-md-5">
                  <img class="auth-title-box-img d-dark-none" src="<?= base_url('assets/img/spot-illustrations/logo-sys.png') ?>" alt="" />
                  <img class="auth-title-box-img d-light-none" src="<?= base_url('assets/img/spot-illustrations/logo-sys.png') ?>" alt="" />
                </div>

              </div>

              <div class="col mx-auto div-email">
                <div class="auth-form-box">
                  <div class="text-center">
                    <a class="d-flex flex-center text-decoration-none mb-4" href="#">
                      <div class="d-flex align-items-center fw-bolder fs-5 d-inline-block">
                        <img class="logo" src="" width="200" />
                      </div>
                    </a>
                    <h4 class="text-1000">Esqueceu sua senha?</h4>
                    <p class="text-700 mb-5">Digite seu email abaixo <br class="d-md-none" />para <br class="d-none d-xxl-block" />recuperar sua senha.</p>
                    <div class="d-flex align-items-center mb-5">

                      <input required name="email" class="form-control flex-1 input-email" id="email" type="email" placeholder="Email" />

                      <button type="submit" class="btn btn-success btn-padrao ms-2 btn-envia" onclick="verificaEmail()">Enviar<span class="fas fa-chevron-right ms-2"></span></button>
                      
                      <div class="p-3"><div class="spinner-border text-primary load-form d-none" role="status"></div></div>

                    </div>
                    
                    <a class="fs--1 fw-bold text-dark" href="<?= base_url('login')?>">Lembrei a senha!</a>
                  </div>
                </div>
              </div>

              <!-- Codigo de verificação -->
              <div class="col mx-auto d-none div-codigo">
                <div class="auth-form-box">
                  <div class="text-center"><a class="d-flex flex-center text-decoration-none mb-4" href="#">
                      <div class="d-flex align-items-center fw-bolder fs-5 d-inline-block"><img class="logo" src="" width="200">
                      </div>
                    </a>
                    <h4 class="text-1000">Insira o código de verificação</h4>
                    <p class="text-700 mb-0 mb-5">Um código de verificação de 6 dígitos foi enviado para seu email</p>
                    <div class="verification-form" data-2fa-varification="data-2FA-varification">
                      <div class="d-flex align-items-center gap-2 mb-3">
                        <input class="form-control px-2 text-center codigo-input" type="number" autofocus>
                        <input class="form-control px-2 text-center codigo-input" type="number" disabled="disabled">
                        <input class="form-control px-2 text-center codigo-input" type="number" disabled="disabled"><span>-</span>
                        <input class="form-control px-2 text-center codigo-input" type="number" disabled="disabled">
                        <input class="form-control px-2 text-center codigo-input" type="number" disabled="disabled">
                        <input class="form-control px-2 text-center codigo-input" type="number" disabled="disabled">
                      </div>
                      <button onclick="verificaCodigo()" class="btn btn-success w-100 mb-5 btn-padrao btn-envia">Verificar</button>

                      <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Final código de Verificação -->

              <!-- Nova Senha -->

              <div class="col mx-auto d-none div-nova-senha">
                <div class="auth-form-box">
                  <div class="text-center mb-7"><a class="d-flex flex-center text-decoration-none mb-4" href="#">
                      <div class="d-flex align-items-center fw-bolder fs-5 d-inline-block"><img class="logo" alt="phoenix" width="200">
                      </div>
                    </a>
                    <h4 class="text-1000">Redefinir nova senha</h4>
                    <p class="text-700">Digite sua nova senha</p>
                  </div>
                  <div class="mt-5">
                    <input class="form-control mb-2 nova-senha" id="password" type="password" placeholder="Nova Senha">
                    <input class="form-control mb-4 repete-senha" id="confirmPassword" type="password" placeholder="Confirme a nova senha">
                    <button class="btn btn-success btn-padrao w-100 btn-redefine-senha" onclick="redefineSenha()">Redefinir senha</button>
                    <div class="p-3 text-center"><div class="spinner-border text-primary load-form d-none" role="status"></div></div>

                  </div>
                </div>
              </div>
              <!-- Final Nova Senha -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>