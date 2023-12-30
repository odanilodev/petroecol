<div class="content">
    <div class="row mb-9">

        <div class="col-12">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0"><?= $this->uri->segment(3) ? 'Editar Recipiente' : 'Cadastrar Novo Recipiente'; ?></h4>

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
                                                <input type="hidden" class="input-id" value="<?= $recipiente['id'] ?? ''; ?>">

                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Nome do recipiente</label>
                                                    <input class="form-control input-obrigatorio input-nome" type="text" placeholder="Digite o nome do recipiente" value="<?= $recipiente['nome_recipiente'] ?? ''; ?>">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Volume Suportado</label>
                                                    <input class="form-control input-obrigatorio input-volume" type="number" placeholder="Digite a capacidade" value="<?= $recipiente['volume_suportado'] ?? ''; ?>">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label class="form-label text-900">Unidade de peso</label>
                                                        <select class="form-select input-obrigatorio input-unidade">
                                                            <option value="" selected disabled>Selecione</option>
                                                            <option value="LT" <?= (isset($recipiente['unidade_peso']) && $recipiente['unidade_peso'] == 'LT') ? 'selected' : ''; ?>>LT</option>
                                                            <option value="KG" <?= (isset($recipiente['unidade_peso']) && $recipiente['unidade_peso'] == 'KG') ? 'selected' : ''; ?>>KG</option>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Quantidade em estoque</label>
                                                    <input class="form-control input-obrigatorio input-quantidade" type="number" placeholder="Digite a quantidade" value="<?= $recipiente['quantidade'] ?? ''; ?>">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                                <div class="flex-1 text-end my-4">
                                                    <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraRecipiente()"><?= $this->uri->segment(3) ? 'Editar' : 'Cadastrar'; ?>
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