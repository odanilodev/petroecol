<div class="content">
  <div class="row mb-9">

    <div class="col-12">
      <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
          <div class="row g-3 justify-content-between align-items-center">
            <div class="col-12 col-md">
              <h4 class="text-900 mb-0"><?= $this->uri->segment(3) ? 'Editar Tarifa Bancária' : 'Cadastrar Nova Tarifa Bancária'; ?></h4>

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
                        <input type="hidden" class="input-id" value="<?= $tarifa['id'] ?? ''; ?>">

                        <div class="col-md-4 mb-3">
                          <label class="form-label" for="nome-tarifa">Nome da Tarifa*</label>
                          <input class="form-control input-nome-tarifa input-obrigatorio" id="nome-tarifa" type="text" placeholder="Nome da Tarifa Bancária" value="<?= $tarifa['nome_tarifa'] ?? ''; ?>">
                          <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                          <label class="form-label" for="status-tarifa">Ativa / Inativa</label>
                          <input class="input-status-tarifa mt-2" type="checkbox" id="status-tarifa" <?= isset($tarifa['status']) && $tarifa['status'] != 0 ? 'checked' : '' ?>>
                        </div>

                        <div class="col-md-8"></div>

                        <div class="col-md-4 mb-3">
                          <label class="form-label text-900" for="conta-bancaria">Conta Bancária*</label>
                          <select name="conta-bancaria" class="form-select select-conta-bancaria select2 input-obrigatorio">
                            <option value="" selected>Selecione a Conta Bancária</option>
                            <?php foreach ($contasBancarias as $v) { ?>
                              <option value="<?= $v['id'] ?>" <?= (isset($tarifa['id_conta_bancaria']) && $tarifa['id_conta_bancaria'] == $v['id']) ? 'selected' : ''; ?>><?= $v['conta']; ?></option>
                            <?php } ?>
                          </select>
                          <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                        </div>

                        <div class="col-md-4 mb-3">
                          <label class="form-label text-900" for="forma-transacao">Forma da Transação*</label>
                          <select name="forma-transacao" class="form-select select-forma-transacao select2 input-obrigatorio">
                            <option value="" selected disabled>Selecione a Forma da Transação</option>
                            <?php foreach ($formasTransacao as $v) { ?>
                              <option value="<?= $v['id'] ?>" <?= (isset($tarifa['id_forma_transacao']) && $tarifa['id_forma_transacao'] == $v['id']) ? 'selected' : ''; ?>><?= $v['nome']; ?></option>
                            <?php } ?>
                          </select>
                          <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                        </div>

                        <div class="col-md-4 mb-3">
                          <label class="form-label text-900" for="tipo-tarifa">Tipo de Tarifa*</label>
                          <select id="tipo-tarifa" class="form-select select-tipo-tarifa select2 input-obrigatorio">
                            <option value="" selected disabled >Selecione o Tipo de Tarifa</option>
                            <option value="1" <?= isset($tarifa['tipo_tarifa']) && $tarifa['tipo_tarifa'] == 1 ? 'selected' : ''; ?>>Porcentagem(%)</option>
                            <option value="2" <?= isset($tarifa['tipo_tarifa']) && $tarifa['tipo_tarifa'] == 2 ? 'selected' : '';  ?>>Valor(R$)</option>
                          </select>
                          <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                        </div>

                        <div class="col-md-4 mb-3">
                          <label class="form-label text-900" for="valor-minimo-tarifa">Valor Mínimo para Tarifa*</label>
                          <input value="<?= $tarifa['valor_minimo_tarifa'] ?? "" ?>" class="form-control mascara-dinheiro input-valor-minimo-tarifa input-obrigatorio" type="text" id="valor-minimo-tarifa" placeholder="Digite o valor minimo para tarifa" />
                          <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                        </div>

                        <div class="col-md-4 mb-3">
                          <label class="form-label text-900" for="valor-tarifa">Valor Tarifa*</label>
                          <input value="<?= $tarifa['valor_tarifa'] ?? "" ?>" class="form-control mascara-dinheiro input-valor-tarifa input-obrigatorio" type="text" id="valor-tarifa" placeholder="Digite o valor da tarifa" />
                          <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                        </div>


                        <div class="flex-1 text-end my-5">
                          <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraTarifaBancaria()"><?= $this->uri->segment(3) ? 'Editar ' : 'Cadastrar'; ?>
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