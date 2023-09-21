<div class="content">

  <div class="row mb-9">
    <div class="col-12 col-xxl-12">
      <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">

        <div class="card-header p-4 border-bottom border-300 bg-soft">
          <div class="row g-3 justify-content-between align-items-center">
            <div class="col-12 col-md">
              <h4 class="text-900 mb-0" data-anchor="data-anchor" id="with-validation">Cadastro de Cliente<a class="anchorjs-link " aria-label="Anchor" style="padding-left: 0.375em;"></a></h4>
            </div>
          </div>
        </div>
        <div class="card-body p-0">

          <div class="p-4 code-to-copy" id="with-validation-code">
            <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
              <div class="card-header bg-100 pt-3 pb-2 border-bottom-0">
                <ul class="nav justify-content-between nav-wizard">

                  <li class="nav-item">
                    <a class="nav-link active fw-semi-bold btn-etapas" href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1">
                      <div class="text-center d-inline-block">
                        <span class="nav-item-circle-parent">
                          <span class="nav-item-circle">
                            <span class="fas fa-building"></span>
                          </span>
                        </span>
                        <span class="d-none d-md-block mt-1 fs--1">Empresa</span>
                      </div>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link fw-semi-bold btn-etapas" href="#bootstrap-wizard-tab2" data-bs-toggle="tab" data-wizard-step="2">
                      <div class="text-center d-inline-block">
                        <span class="nav-item-circle-parent">
                          <span class="nav-item-circle">
                            <span class="fas fa-map-marker-alt"></span>
                          </span>
                        </span>
                        <span class="d-none d-md-block mt-1 fs--1">Endereço</span>
                      </div>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link fw-semi-bold btn-responsavel btn-etapas" href="#bootstrap-wizard-tab3" data-bs-toggle="tab" data-wizard-step="3">
                      <div class="text-center d-inline-block">
                        <span class="nav-item-circle-parent">
                          <span class="nav-item-circle">
                            <span class="fas fa-user-alt"></span>
                          </span>
                        </span>
                        <span class="d-none d-md-block mt-1 fs--1">Responsável</span>
                      </div>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link fw-semi-bold btn-etapas" href="#bootstrap-wizard-tab4" data-bs-toggle="tab" data-wizard-step="4" onclick="verificaCampos()">
                      <div class="text-center d-inline-block">
                        <span class="nav-item-circle-parent">
                          <span class="nav-item-circle">
                            <span class="fas fa-check"></span>
                          </span>
                        </span>
                        <span class="d-none d-md-block mt-1 fs--1">Finalizar</span>
                      </div>
                    </a>
                  </li>

                </ul>
              </div>

              <div class="card-body pt-4 pb-0">
                <div class="tab-content">
                  <div class="tab-pane active" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1">

                    <input type="hidden" value="<?= isset($cliente['id']) ? $cliente['id'] : "" ?>" class="input-id">
                    
                    <form id="form-empresa" class="needs-validation" novalidate="novalidate" data-wizard-form="1">

                      <div class="row">

                        <div class="mb-2 mt-2 col-md-6">
                          <label class="form-label text-900">Nome da empresa *</label>
                          <input required class="form-control" type="text" name="nome" value="<?= isset($cliente['nome']) ? $cliente['nome'] : ""; ?>" placeholder="Insira o nome da empresa"/>
                          <div class="invalid-feedback">Preencha este campo</div>

                        </div>

                        <div class="mb-2 mt-2 col-md-4">
                          <label class="form-label">Telefone *</label>
                          <input required class="form-control" type="text" name="telefone" value="<?= isset($cliente['telefone']) ? $cliente['telefone'] : ""; ?>" placeholder="Telefone com DDD" />
                          <div class="invalid-feedback">Preencha este campo</div>

                        </div>

                        <div class="mb-2 mt-2 col-md-2">
                          <label class="form-label text-900">Código</label>
                          <input class="form-control" type="text" name="codigo" value="<?= isset($cliente['codigo']) ? $cliente['codigo'] : ""; ?>" placeholder="Código da empresa" />
                        </div>

                        <div class="mb-2 mt-5 col-md-3">
                          <label class="form-label">CNPJ</label>
                          <input class="form-control" type="text" name="cnpj" value="<?= isset($cliente['cnpj']) ? $cliente['cnpj'] : ""; ?>" placeholder="CNPJ da empresa" />
                        </div>

                        <div class="mb-2 mt-5 col-md-3">
                          <label class="form-label">Razão social *</label>
                          <input required class="form-control" type="text" name="razao_social" value="<?= isset($cliente['razao_social']) ? $cliente['razao_social'] : ""; ?>" placeholder="Razão Social" />
                          <div class="invalid-feedback">Preencha este campo</div>
                        </div>

                        <div class="mb-2 mt-5 col-md-3">
                          <label class="form-label">Tipo de empresa</label>
                          <input class="form-control" type="text" name="tipo_negocio" value="<?= isset($cliente['tipo_negocio']) ? $cliente['tipo_negocio'] : ""; ?>" placeholder="Tipo de empresa" />
                        </div>

                        <div class="mb-2 mt-5 col-md-3">
                          <label class="form-label">Grupo de negócio</label>
                          <input class="form-control" type="text" name="grupo_negocio" value="<?= isset($cliente['grupo_negocio']) ? $cliente['grupo_negocio'] : ""; ?>" placeholder="Grupo de negócio" />
                        </div>

                      </div>

                    </form>
                  </div>

                  <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2">
                    <form id="form-endereco" class="needs-validation" novalidate="novalidate" data-wizard-form="2">

                      <div class="row">

                        <div class="mb-2 mt-2 col-md-4">
                          <label class="form-label">CEP</label>
                          <input class="form-control campo input-cep" type="text" name="cep" value="<?= isset($cliente['cep']) ? $cliente['cep'] : ""; ?>" placeholder="Insira o CEP">
                        </div>

                        <div class="mb-2 mt-2 col-md-6">
                          <label class="form-label">Rua *</label>
                          <input id="rua" required class="form-control campo" type="text" name="rua" value="<?= isset($cliente['rua']) ? $cliente['rua'] : ""; ?>" placeholder="Nome da rua">
                          <div class="invalid-feedback">Preencha este campo</div>
                        </div>

                        <div class="mb-2 mt-2 col-md-2">
                          <label class="form-label">N° *</label>
                          <input required class="form-control campo" type="text" name="numero" value="<?= isset($cliente['numero']) ? $cliente['numero'] : ""; ?>" placeholder="Número">
                          <div class="invalid-feedback">Preencha este campo</div>
                        </div>

                        <div class="mb-2 col-md-4 mt-5">
                          <label class="form-label">Bairro *</label>
                          <input id="bairro" required class="form-control campo" type="text" name="bairro" value="<?= isset($cliente['bairro']) ? $cliente['bairro'] : ""; ?>" placeholder="Bairro">
                          <div class="invalid-feedback">Preencha este campo</div>
                        </div>

                        <div class="mb-2 col-md-3 mt-5">
                          <label class="form-label">Cidade *</label>
                          <input id="cidade" required class="form-control campo" type="text" name="cidade" value="<?= isset($cliente['cidade']) ? $cliente['cidade'] : ""; ?>" placeholder="Número">
                          <div class="invalid-feedback">Preencha este campo</div>
                        </div>

                        <div class="mb-2 col-md-2 mt-5">
                          <label class="form-label">Estado *</label>
                          <input id="estado" required class="form-control campo" type="text" name="estado" value="<?= isset($cliente['estado']) ? $cliente['estado'] : ""; ?>" placeholder="Número">
                          <div class="invalid-feedback">Preencha este campo</div>
                        </div>

                        <div class="mb-2 col-md-3 mt-5">
                          <label class="form-label">País</label>
                          <input class="form-control campo" type="text" name="pais" value="<?= isset($cliente['pais']) ? $cliente['pais'] : ""; ?>" placeholder="País">
                        </div>

                        <div class="mb-2 col-md-12 mt-5">
                          <label class="form-label">Complemento</label>
                          <textarea class="form-control campo" rows="4" name="complemento" value="<?= isset($cliente['complemento']) ? $cliente['complemento'] : ""; ?>">
                            <?= isset($cliente['complemento']) ? $cliente['complemento'] : ""; ?>
                          </textarea>
                        </div>

                      </div>
                    </form>
                  </div>

                  <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3">
                    <form class="mb-2 needs-validation" id="form-responsavel" novalidate="novalidate" data-wizard-form="3">

                      <div class="row gx-3 gy-2">

                        <div class="col-md-4">
                          <label class="form-label" for="bootstrap-wizard-card-name">Nome</label>
                          <input class="form-control" placeholder="Nome do responsável" name="nome_responsavel" value="<?= isset($cliente['nome_responsavel']) ? $cliente['nome_responsavel'] : ""; ?>" type="text"/>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="bootstrap-wizard-card-name">Telefone do Responsável</label>
                          <input class="form-control" placeholder="Telefone do responsável" name="telefone_responsavel" value="<?= isset($cliente['telefone_responsavel']) ? $cliente['telefone_responsavel'] : ""; ?>" type="text"/>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="bootstrap-wizard-card-name">Função do Responsável</label>
                          <input class="form-control" placeholder="Função do responsável" name="funcao_responsavel" value="<?= isset($cliente['funcao_responsavel']) ? $cliente['funcao_responsavel'] : ""; ?>" type="text"/>
                        </div>

                      </div>
                    </form>
                  </div>

                  <div class="tab-pane d-none" role="tabpanel" aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4">
                    <div class="row flex-center pb-8 pt-4 gx-3 gy-4">
                      <div data-bds-toggle="tab" data-wizard-step="1">
                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <div class="card-footer border-top-0" data-wizard-footer="data-wizard-footer">
                <div class="d-flex pager wizard list-inline mb-0">
                  <button class="d-none btn btn-link ps-0 bnt-voltar" type="button" data-wizard-prev-btn="data-wizard-prev-btn"><span class="fas fa-chevron-left me-1" data-fa-transform="shrink-3"></span>Voltar</button>
                  <div class="flex-1 text-end">
                    <button class="btn btn-primary px-6 px-sm-6 btn-proximo" type="submit" data-wizard-next-btn="data-wizard-next-btn">
                      Próximo <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span>
                    </button>
                  </div>
                </div>

                <div class="spinner-border text-primary load-form d-none" role="status"></div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>