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
                  <form method="post" class="needs-validation" id="cadastra-usuario" novalidate="novalidate" data-wizard-form="1">

                    <div class="row mb-4">

                      <div class="dz-preview-cover d-flex align-items-center justify-content-center mb-2 mb-md-0 col-md-auto">
                        <div class="icon-box div-preview avatar avatar-4xl">
                          <img class=" image-preview rounded-circle avatar-placeholder" src="<?= base_url('assets/img/team/avatar.webp') ?>" data-dz-thumbnail="data-dz-thumbnail">
                        </div>
                      </div>

                      <div class="form-group col-md">
                        <div class="image-input">
                          <input type="file" accept="image/*" id="imageInput" name="capa">
                          <label for="imageInput" class="image-button">
                            <h5 class="mb-2"><span class="fa-solid fa-upload me-2"></span>Carregar foto de perfil</h5>
                          </label>

                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="mb-2 col-md-6">
                        <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-name">Nome*</label>
                        <input required class="form-control input-nome" type="text" name="nome" placeholder="Nome do Usuário" id="bootstrap-wizard-validation-wizard-name" />
                        <div class="invalid-feedback">Preencha este campo.</div>
                      </div>

                      <div class="mb-2 col-md-6">
                        <label class="form-label" for="bootstrap-wizard-validation-wizard-phone">Telefone*</label>
                        <input required class="form-control input-telefone" type="text" name="telefone" placeholder="Telefone" id="bootstrap-wizard-validation-wizard-phone" />
                        <div class="invalid-feedback">Preencha este campo.</div>
                      </div>

                      <div class="mb-2">
                        <label class="form-label" for="bootstrap-wizard-validation-wizard-email">Email*</label>
                        <input required class="form-control input-email" type="email" name="email" placeholder="Email address" pattern="^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$" id="bootstrap-wizard-validation-wizard-email" />
                        <div class="invalid-feedback">Preencha este campo.</div>
                      </div>

                      <div class="col-sm-6">
                        <div class="mb-2 mb-sm-0">
                          <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-password">Senha*</label>
                          <input required class="form-control input-senha" type="password" name="senha" placeholder="Senha" id="bootstrap-wizard-validation-wizard-password" data-wizard-password="true" />
                          <div class="invalid-feedback">Preencha este campo.</div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="mb-2">
                          <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-confirm-password">Confirme a Senha*</label>
                          <input required class="form-control input-repete-senha" type="password" name="confirme-senha" placeholder="Confirme a Senha" id="bootstrap-wizard-validation-wizard-confirm-password" data-wizard-confirm-password="true" />
                          <div class="invalid-feedback">As senhas precisam combinar.</div>
                        </div>
                      </div>

                    </div>


                    <div class="flex-1 text-end my-5">
                      <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraUsuario()">Cadastrar
                        <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span>
                      </button>
                      <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    </div>


                  </form>
                </div>


              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>