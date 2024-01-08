<div class="content">
  <div class="row mb-9">

    <div class="col-12">
      <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
          <div class="row g-3 justify-content-between align-items-center">
            <div class="col-12 col-md">
              <h4 class="text-900 mb-0"><?= $this->uri->segment(3) ? 'Editar Modelo Certificado' : 'Cadastrar Modelo Certificado'; ?></h4>

            </div>
          </div>
        </div>

        <div class="card-body p-0">

          <div class="accordion" id="accordionExample">

            <div class="accordion-item" style="border: none !important;">

              <div class="accordion-collapse collapse show" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body pt-0">
                  <div class="p-4 code-to-copy">
                    <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

                      <div class="card-body pt-4 pb-0 row">
                        <input type="hidden" class="input-id" value="<?= $certificado['id'] ?? ''; ?>">

                        <div class="col-md-6 mb-3">
                          <label class="form-label"><?= chave('modelo') ?></label>
                          <input class="form-control input-modelo input-obrigatorio" type="text" placeholder="Nome do Modelo" value="<?= $certificado['modelo'] ?? ''; ?>">
                          <div class="aviso-obrigatorio d-none">Preencha este campo</div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <label class="form-label"><?= chave('titulo') ?></label>
                          <input class="form-control input-titulo input-obrigatorio" type="text" placeholder="Titulo do Certificado" value="<?= $certificado['titulo'] ?? ''; ?>">
                          <div class="aviso-obrigatorio d-none">Preencha este campo</div>
                        </div>

                        <div class="col-md-4 mb-3">
                          <label class="form-label"><?= chave('descricao') ?></label>
                          <input class="form-control input-descricao" type="text" placeholder="Descrição do Certificado" value="<?= $certificado['descricao'] ?? ''; ?>">

                        </div>

                        <div class="col-md-4 mb-3">
                          <label class="form-label"><?= chave('declaracao') ?></label>
                          <input class="form-control input-declaracao" type="text" placeholder="Declaração do Certificado" value="<?= $certificado['declaracao'] ?? ''; ?>">

                        </div>

                        <div class="col-md-4 mb-3">
                        <label class="form-label">Orientação do certificado</label>

                          <select class="select-validation select-orientacao" required>
                            <option selected disabled value=''>Selecione</option>

                            <option value="horizontal" <?= (isset($certificado['orientacao']) && $certificado['orientacao'] == 'horizontal') ? 'selected' : ''; ?>>Horizontal</option>
                            <option value="vertical" <?= (isset($certificado['orientacao']) && $certificado['orientacao'] == 'vertical') ? 'selected' : ''; ?>>Vertical</option>

                          </select>
                        </div>

                        <div class="col-md-3 mb-3">
                          <label class="form-label" title="Mínimo 200px x 100px em formato JPG"><?= chave('logo') ?> <small>(200px X 100px JPG)</small> </label>
                          <input class="form-control input-logo <?= !$this->uri->segment(3) ? "input-obrigatorio" : "" ?>" type="file" value="<?= $certificado['logo'] ?? ''; ?>">

                        </div>

                        <div class="col-md-3 mb-3">
                          <label class="form-label" title="Mínimo 200px x 100px em formato JPG"><?= chave('carimbo') ?> <small>(200px X 100px JPG)</small></label>
                          <input class="form-control input-carimbo" type="file" value="<?= $certificado['carimbo'] ?? ''; ?>">

                        </div>

                        <div class="col-md-3 mb-3">
                          <label class="form-label" title="Mínimo 200px x 100px em formato JPG"><?= chave('assinatura') ?> <small>(200px X 100px JPG)</small></label>
                          <input class="form-control input-assinatura" type="file" value="<?= $certificado['assinatura'] ?? ''; ?>">

                        </div>

                        <div class="col-md-3 mb-3">
                          <label class="form-label" title="Mínimo 200px x 100px em formato JPG"><?= chave('marcadagua') ?> <small>(200px X 100px JPG)</small></label>
                          <input class="form-control input-marca-agua" type="file" value="<?= $certificado['marca_agua'] ?? ''; ?>">

                        </div>

                        <div class="flex-1 text-end my-5">
                          <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraCertificado()"><?= $this->uri->segment(3) ? 'Editar' : 'Cadastrar'; ?>
                            <span class="fas fa-chevron-right" data-fa-transform="shrink-3"> </span>
                          </button>
                          <div class="spinner-border text-primary load-form d-none" role="status"></div>
                        </div>

                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>


        </div>
      </div>
    </div>

  </div>