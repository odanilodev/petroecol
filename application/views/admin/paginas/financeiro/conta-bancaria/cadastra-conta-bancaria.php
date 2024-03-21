<div class="content">
  <div class="row mb-9">

    <div class="col-12">
      <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
          <div class="row g-3 justify-content-between align-items-center">
            <div class="col-12 col-md">
              <h4 class="text-900 mb-0">
                <?= $this->uri->segment(3) ? 'Editar Conta Bancária' : 'Cadastrar Nova Conta Bancária'; ?></h4>
            </div>
          </div>
        </div>
        <div class="card-body p-0">

          <div class="p-4 code-to-copy">
            <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

              <div class="card-body pt-4 pb-0">
                <div class="tab-pane row" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab2" id="bootstrap-wizard-validation-tab2">
                  <form method="post" class="needs-validation" novalidate="novalidate" data-wizard-form="1">

                    <input type="hidden" class="input-id" value="<?= $contaBancaria['id'] ?? "" ?>">

                    <div class="row">
                      <div class="mb-5 col-md-4">
                        <label class="form-label text-900" for="apelido">Apelido*</label>
                        <input required value="<?= $contaBancaria['apelido'] ?? "" ?>" class="form-control input-obrigatorio input-apelido" type="text" id="apelido" placeholder="Apelido da Conta Bancaria" />
                        <div class="invalid-feedback">Preencha este campo.</div>
                      </div>

                      <div class="col-md-8"></div>

                      <div class="mb-2 col-md-4">
                          <div class="mb-2">
                            <label class="form-label text-900" for="setor-conta-bancaria">Setor da Conta Bancária</label>
                            <select name="setor-conta-bancaria" class="form-select select-setor-empresa select2">
                              <option value="" selected>Selecione o Setor</option>

                              <?php foreach($setores as $v) { ?>
                                <option value="<?= $v['id']?>" <?= (isset($contaBancaria['id_setor_empresa']) && $contaBancaria['id_setor_empresa'] == $v['id']) ? 'selected' : ''; ?>><?= $v['nome'];?></option>
                              <?php }?>

                            </select>
                          </div>
                        </div>

                      <div class="mb-2 col-md-4">
                        <label class="form-label text-900" for="conta">Conta*</label>
                        <input required value="<?= $contaBancaria['conta'] ?? "" ?>" class="form-control input-obrigatorio input-conta mascara-conta-bancaria" type="text" id="conta" placeholder="Digite o nº da conta" />
                        <div class="d-none aviso-obrigatorio">Preencha este campo.</div>
                      </div>

                      <div class="mb-2 col-md-4">
                        <label class="form-label text-900" for="banco">Banco*</label>
                        <input value="<?= $contaBancaria['banco'] ?? "" ?>" class="form-control input-obrigatorio input-banco" type="text" name="banco" placeholder="Digite o nome do Banco" />
                      </div>

                      <div class="mb-2 col-md-4">
                        <label class="form-label text-900" for="agencia">Agência*</label>
                        <input value="<?= $contaBancaria['agencia'] ?? "" ?>" class="form-control input-obrigatorio input-agencia mascara-agencia" type="text" id="agencia" placeholder="Digite o nome da Agência" />
                        <div class="invalid-feedback">Preencha este campo.</div>
                      </div>
                      
                      <?php if (!$this->uri->segment(3)) : ?>
                        <div class="mb-2 col-md-4">
                          <label class="form-label text-900" for="saldo">Saldo Inicial*</label>
                          <input value="<?= $saldoBancario['saldo'] ?? "" ?>" class="form-control mascara-dinheiro input-obrigatorio input-saldo" type="text" id="saldo" placeholder="Digite o saldo inicial" />
                          <div class="invalid-feedback">Preencha este campo.</div>
                        </div>
                      <?php endif; ?>


                      <div class="flex-1 pt-8 text-end my-5">
                        <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraContaBancaria()"><?= $this->uri->segment(3) ? 'Editar Conta Bancaria' : 'Cadastrar Conta Bancaria'; ?>
                          <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span>
                        </button>
                        <div class="spinner-border text-primary load-form d-none" role="status">
                        </div>
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