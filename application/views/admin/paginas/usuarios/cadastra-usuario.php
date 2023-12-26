<div class="content">
  <div class="row mb-9">

    <div class="col-12">
      <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
          <div class="row g-3 justify-content-between align-items-center">
            <div class="col-12 col-md">
              <h4 class="text-900 mb-0"><?= $this->uri->segment(3) ? 'Editar Usuário' : 'Cadastrar Novo Usuário'; ?></h4>
            </div>
          </div>
        </div>
        <div class="card-body p-0">

          <div class="p-4 code-to-copy">
            <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

              <div class="card-body pt-4 pb-0">
                <div class="tab-pane row" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab2" id="bootstrap-wizard-validation-tab2">
                  <form method="post" class="needs-validation" id="cadastra-usuario" novalidate="novalidate" data-wizard-form="1">

                    <input type="hidden" class="input-id" value="<?= isset($usuario['id']) ? $usuario['id'] : "" ?>">
                    <div class="row mb-4">

                      <div class="dz-preview-cover d-flex align-items-center justify-content-center mb-2 mb-md-0 col-md-auto">

                        <div class="hoverbox avatar-4xl">
                          <?php if (isset($usuario['foto_perfil'])) { ?>
                            <a href="#" onclick="deletaFotoPerfil(<?= $usuario['id'] ?>, '<?= urlencode($usuario['foto_perfil'])?>')">

                              <div class="hoverbox-content bg-black rounded-circle d-flex flex-center z-index-1" style="--phoenix-bg-opacity: .56;">
                                <span class="fa-solid fa-trash fs-3 text-100 light"></span>
                              </div>
                            <?php } ?>

                            <div class="icon-box div-preview avatar avatar-4xl">
                              <img class=" image-preview rounded-circle avatar-placeholder" src="<?= isset($usuario['foto_perfil']) ? base_url_upload('usuarios/' . $usuario['foto_perfil']) : base_url('assets/img/icons/sem_foto.jpg') ?>" data-dz-thumbnail="data-dz-thumbnail">
                            </div>
                            </a>
                        </div>
                      </div>

                      <div class="form-group col-md">
                        <div class="image-input">
                          <input type="file" accept="image/*" id="imageInput" name="capa">
                          <?php if ($this->session->userdata('id_empresa') != '1') { ?>
                            <label for="imageInput" class="image-button">
                              <h5 class="mb-2"><span class="fa-solid fa-upload me-2"></span>Carregar foto de perfil</h5>
                            </label>
                          <?php } ?>

                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="mb-2 col-md-4">
                        <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-name">Nome*</label>
                        <input required value="<?= isset($usuario['nome']) ? $usuario['nome'] : "" ?>" class="form-control input-nome" type="text" name="nome" placeholder="Nome do Usuário" id="bootstrap-wizard-validation-wizard-name" />
                        <div class="invalid-feedback">Preencha este campo.</div>
                      </div>

                      <div class="mb-2 col-md-4">
                        <label class="form-label" for="bootstrap-wizard-validation-wizard-phone">Telefone*</label>
                        <input value="<?= isset($usuario['telefone']) ? $usuario['telefone'] : "" ?>" required class="form-control input-telefone mascara-tel" type="text" name="telefone" placeholder="Telefone" id="bootstrap-wizard-validation-wizard-phone" />
                        <div class="invalid-feedback">Preencha este campo.</div>
                      </div>

                      <div class="mb-2 col-md-4">
                        <label class="form-label" for="bootstrap-wizard-validation-wizard-email">Email*</label>
                        <input value="<?= isset($usuario['email']) ? $usuario['email'] : "" ?>" required class="form-control input-email" type="email" name="email" placeholder="Email address" pattern="^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$" id="bootstrap-wizard-validation-wizard-email" />
                        <div class="invalid-feedback">Preencha este campo.</div>
                      </div>

                      <div class="mb-2 col-md-4">
                        <div class="mb-2">
                          <label class="form-label text-900">Setor</label>
                          <select name='setor' class="select-validation select-setor" required>
                            <option selected disabled value=''>Selecione</option>
                            <?php if ($this->session->userdata('id_empresa') == 1) { ?>
                              <option selected value="0">N/A</option>
                            <?php } ?>
                            <?php foreach ($setores as $s) { ?>
                              <option value="<?= $s['id'] ?>" <?= (isset($usuario['id_setor']) && $usuario['id_setor'] == $s['id']) ? 'selected' : ''; ?>><?= $s['nome'] ?></option>
                            <?php } ?>
                          </select>
                          <div class="invalid-feedback">Preencha este campo.</div>
                        </div>
                      </div>

                      <div class="col-md-4 <?= isset($usuario['id']) ? "d-none" : "" ?>">
                        <div class="mb-2 mb-sm-0">
                          <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-password">Senha*</label>
                          <input required class="form-control input-senha" type="password" name="senha" placeholder="Senha" id="bootstrap-wizard-validation-wizard-password" data-wizard-password="true" />
                          <div class="invalid-feedback">Preencha este campo.</div>
                        </div>
                      </div>  
                      <div class="col-md-4 <?= isset($usuario['id']) ? "d-none" : "" ?>">
                        <div class="mb-2">
                          <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-confirm-password">Confirme a Senha*</label>
                          <input required class="form-control input-repete-senha" type="password" name="confirme-senha" placeholder="Confirme a Senha" id="bootstrap-wizard-validation-wizard-confirm-password" data-wizard-confirm-password="true" />
                          <div class="invalid-feedback">As senhas precisam combinar.</div>
                        </div>
                      </div>

                      <div class="mb-2 col-md-4">
                        <div class="mb-2">
                          <label class="form-label text-900">Idioma*</label>
                          <select name='idioma' class="select-validation select-idioma" required>
                            <option selected disabled value=''>Selecione</option>
                              <option value="ptbr" <?= (isset($usuario['idioma']) && $usuario['idioma'] == 'ptbr') ? 'selected' : ''; ?>>Português - BR</option>
                              <option value="en" <?= (isset($usuario['idioma']) && $usuario['idioma'] == 'en') ? 'selected' : ''; ?>>English - EN</option>
                          </select>
                          <div class="invalid-feedback">Preencha este campo.</div>
                        </div>
                      </div>


                      <?php if ($this->session->userdata('id_empresa') == 1) { ?>

                        <div class="col-sm-6 mt-3">
                          <div class="mb-2">
                            <label class="form-label text-900">Empresa</label>
                            <select class="select-empresa select-validation">
                              <option value="" selected disabled>Selecione</option>

                              <?php foreach ($empresas as $v) { ?>
                                <option value="<?= $v['id'] ?>" <?= (isset($usuario['id_empresa'])) && $usuario['id_empresa'] == $v['id'] ? "selected" : "" ?>>
                                  <?= $v['nome']; ?>
                                </option>
                              <?php } ?>

                            </select>
                          </div>
                        </div>

                      <?php } ?>

                    </div>


                    <!-- redefinir senha de usuario quando está editando-->
                    <div class="accordion mt-6 mb-4 <?= !isset($usuario['id']) ? 'd-none' : '' ?>">

                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseOne">Redefinir senha</button>
                        </h2>

                        <div class="accordion-collapse collapse" id="collapseFive" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                          <div class="accordion-body pt-0 row">

                            <div class="col-sm-4">
                              <div class="mb-2 mb-sm-0">
                                <label class="form-label text-900">Senha Antiga</label>
                                <input class="input-senha-antiga inputs-redefine form-control" type="password" name="senha-antiga" placeholder="Senha antiga">
                                <div class="invalid-feedback senha-antiga-invalida">Senha incorreta.</div>
                              </div>
                            </div>

                            <div class="col-sm-4">
                              <div class="mb-2 mb-sm-0">
                                <label class="form-label text-900">Senha*</label>
                                <input class="input-nova-senha inputs-redefine form-control" type="password" name="nova-senha" placeholder="Nova Senha">
                                <div class="invalid-feedback aviso-nova-senha">Insira uma nova senha.</div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="mb-2">
                                <label class="form-label text-900">Confirme a Nova Senha*</label>
                                <input class="input-repete-nova-senha inputs-redefine form-control" type="password" name="confirme-nova-senha" placeholder="Confirme a Nova Senha">
                                <div class="invalid-feedback aviso-senha-diferente">As senhas precisam combinar.</div>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="flex-1 text-end my-5">
                      <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraUsuario()"><?= $this->uri->segment(3) ? 'Editar' : 'Cadastrar'; ?>
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