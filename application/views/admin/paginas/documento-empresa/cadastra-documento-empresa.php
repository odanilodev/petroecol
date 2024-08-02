<div class="content">
  <div class="row mb-9">
    <div class="col-12">
      <div class="card shadow-none border border-300 my-4">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
          <h4 class="text-900 mb-0"><?= $this->uri->segment(3) ? 'Editar Documento' : 'Cadastrar Novo Documento'; ?></h4>
        </div>

        <div class="card-body p-0">
          <div class="p-4">
            <div class="card theme-wizard mb-5">
              <div class="card-body pt-4 pb-0">
                <div class="row align-items-end">
                  <input type="hidden" class="input-id" value="<?= $documento['id'] ?? ''; ?>">

                  <div class="col-md-4 mb-3">
                    <label class="text-body-highlight fw-bold mb-2">Nome Documento</label>
                    <input name="nome" class="form-control input-nome-documento input-obrigatorio" type="text" placeholder="Nome do Documento" value="<?= $documento['nome'] ?? ''; ?>">
                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <label class="text-body-highlight fw-bold mb-2">Data Vencimento</label>
                    <input name="vencimento" autocomplete="off" class="form-control datetimepicker cursor-pointer input-data-vencimento input-obrigatorio mascara-data" required name="data_vencimento" type="text" placeholder="dd/mm/aaaa" data-options='{"disableMobile":true, "allowInput":true, "dateFormat":"d/m/Y"}' value="<?= isset($documento['validade']) ? date('d/m/Y', strtotime($documento['validade'])) : '' ?>">
                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                  </div>


                  <div class="form-group col-md-4 mb-3">
                    <label class="text-body-highlight fw-bold mb-2"><?= $this->uri->segment(3) ? 'Alterar Documento - ' . $documento['documento'] : 'Upload Documento' ?></label>
                    <div class="image-input">
                      <input id="documentoEmpresa" name="documento" accept="image/*" class="form-control input-documento <?= !$this->uri->segment(3) ? 'input-obrigatorio' : '' ?>" type="file">
                      <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col text-end my-5">
                    <button onclick="cadastraNovoDocumento()" class="btn btn-phoenix-primary px-6 px-sm-6 btn-envia"><?= $this->uri->segment(3) ? 'Editar ' : 'Cadastrar'; ?>
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