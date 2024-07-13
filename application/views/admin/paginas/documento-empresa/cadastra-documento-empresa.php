<div class="content">
  <div class="row mb-9">

    <div class="col-12">
      <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
          <div class="row g-3 justify-content-between align-items-center">
            <div class="col-12 col-md">
              <h4 class="text-900 mb-0"><?= $this->uri->segment(3) ? 'Editar Documento' : 'Cadastrar Novo Documento'; ?></h4>

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
                      <div class="card-body pt-4 pb-0">
                        <form id="form-documentos" class="" method="post" action="<?= base_url('documentoEmpresa/cadastraDocumentoEmpresa') ?>">

                          <div class="row align-items-end campos-documento campos-formulario">
                            <input type="hidden" class="input-id" value="<?= $documento['id'] ?? ''; ?>">

                            <div class="col-md-4 mb-3 duplica-documento">
                              <label class="text-body-highlight fw-bold mb-2">Nome Documento</label>
                              <input name="nome[]" class="form-control input-nome-documento input-obrigatorio" type="text" placeholder="Nome do Documento" value="<?= $documento['nome'] ?? ''; ?>">
                              <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                            </div>

                            <div class="col-md-4 mb-3 duplica-documento">
                              <label class="text-body-highlight fw-bold mb-2">Data Vencimento</label>
                              <input name="vencimento[]" autocomplete="off" class="form-control datetimepicker cursor-pointer input-data-vencimento input-obrigatorio mascara-data" required name="data_vencimento" type="text" placeholder="dd/mm/aaaa" data-options='{"disableMobile":true, "allowInput":true, "dateFormat":"d/m/Y"}' />
                              <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                            </div>

                            <!-- <div class="col-md-3 mb-3 duplica-documento">
                              <label class="text-body-highlight fw-bold mb-2">Upload Documento</label>
                              <input name="documento[]" accept="image/*" class="form-control input-documento input-obrigatorio" type="file">
                              <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                            </div> -->

                            <div class="col-md-1 mb-3 text-center">
                              <button type="button" style="height: 2.8em;" class="btn btn-sm btn-phoenix-success btn-adicionar-campo btn-large" onclick="novoDocumento()">
                                <span class="fas fa-plus"></span>
                              </button>
                            </div>

                          </div>
                          <div class="campos-duplicados row campos-formulario">
                            <!-- tratamento js -->
                          </div>

                          <div class="row">
                            <div class="col text-end my-5">
                              <button type="submit" class="btn btn-phoenix-primary px-6 px-sm-6 btn-envia"><?= $this->uri->segment(3) ? 'Editar ' : 'Cadastrar'; ?>
                                <span class="fas fa-chevron-right" data-fa-transform="shrink-3"> </span>
                              </button>
                              <div class="spinner-border text-primary load-form d-none" role="status"></div>
                            </div>
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




      </div>
    </div>
  </div>

</div>