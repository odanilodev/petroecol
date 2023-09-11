<div class="content">
  <div class="row mb-9">

    <div class="col-12">
      <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
          <div class="row g-3 justify-content-between align-items-center">
            <div class="col-12 col-md">
              <h4 class="text-900 mb-0">Cadastro de Usuário</h4>
            </div>
          </div>
        </div>
        <div class="card-body p-0">

          <div class="p-4 code-to-copy">
            <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

              <div class="card-body pt-4 pb-0">
                <div class="tab-pane row" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab2" id="bootstrap-wizard-validation-tab2">
                  <form method="post" action="<?= base_url('usuarios/cadastrausuario') ?>">

                    <div class="row g-4 mb-4" data-dropzone="data-dropzone" data-options='{"maxFiles":1,"data":[{"name":"avatar.webp","size":"54kb","url":"<?= base_url('assets/img/team') ?>"}]}'>

                      <div class="fallback">
                        <input type="file" name="file" />
                      </div>

                      <div class="col-md-auto">
                        <div class="dz-preview dz-preview-single">
                          <div class="dz-preview-cover d-flex align-items-center justify-content-center mb-2 mb-md-0">
                            <div class="avatar avatar-4xl">
                              <img class="rounded-circle avatar-placeholder" src="<?= base_url('assets/img/team/avatar.webp') ?>" data-dz-thumbnail="data-dz-thumbnail" />
                            </div>
                            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md">
                        <div class="dz-message dropzone-area px-2 py-3" data-dz-message="data-dz-message">
                          <div class="text-center text-1100">
                            <h5 class="mb-2"><span class="fa-solid fa-upload me-2"></span>Carregar foto de perfil</h5>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="mb-2 col-md-6">
                        <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-name">Nome*</label>
                        <input required class="form-control" type="text" name="nome" placeholder="Nome do Usuário" id="bootstrap-wizard-validation-wizard-name" />
                        <div class="invalid-feedback">Preencha este campo.</div>
                      </div>

                      <div class="mb-2 col-md-6">
                        <label class="form-label" for="bootstrap-wizard-validation-wizard-phone">Telefone</label>
                        <input required class="form-control" type="text" name="telefone" placeholder="Telefone" id="bootstrap-wizard-validation-wizard-phone" />
                        <div class="invalid-feedback">Preencha este campo.</div>
                      </div>

                      <div class="mb-2">
                        <label class="form-label" for="bootstrap-wizard-validation-wizard-email">Email*</label>
                        <input required class="form-control" type="email" name="email" placeholder="Email address" pattern="^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$" id="bootstrap-wizard-validation-wizard-email" />
                        <div class="invalid-feedback">Preencha este campo.</div>
                      </div>

                      <div class="col-sm-6">
                        <div class="mb-2 mb-sm-0">
                          <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-password">Senha*</label>
                          <input required class="form-control" type="password" name="senha" placeholder="Senha" id="bootstrap-wizard-validation-wizard-password" data-wizard-password="true" />
                          <div class="invalid-feedback">Preencha este campo.</div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="mb-2">
                          <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-confirm-password">Confirme a Senha*</label>
                          <input required class="form-control" type="password" name="confirme-senha" placeholder="Confirme a Senha" id="bootstrap-wizard-validation-wizard-confirm-password" data-wizard-confirm-password="true" />
                          <div class="invalid-feedback">As senhas precisam combinar.</div>
                        </div>
                      </div>

                    </div>


                    <div class="flex-1 text-end my-5">
                      <button class="btn btn-primary px-6 px-sm-6" type="submit">Cadastrar
                        <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span>
                      </button>
                    </div>

                  </form>
                </div>


              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
        <div class="modal-content position-relative">
          <div class="modal-header border-100 p-3">
            <div class="h4 text-800 mb-0">Access Denied!</div>
            <button class="btn btn-link text-danger position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"><span class="fas fa-times"></span></button>
          </div>
          <div class="modal-body px-4 py-6">
            <div class="d-flex align-items-center"><img class="me-4" src="<?= base_url('') ?>assets/img/icons/stop.png" alt="" />
              <div class="flex-1">
                <p class="mb-0 fw-semi-bold text-700">You do not have the link to access. Please start <br />over to get access for the next session.<br />Thank You!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
    <div class="toast align-items-center text-white bg-dark border-0 light" id="icon-copied-toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body p-3"></div>
        <button class="btn-close btn-close-white me-2 m-auto" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>