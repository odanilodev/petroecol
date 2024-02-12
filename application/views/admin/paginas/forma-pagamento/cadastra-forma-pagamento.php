<div class="content">
    <div class="row mb-9">

        <div class="col-12">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0"><?=$this->uri->segment(3) ? 'Editar Forma de Pagamento' : 'Cadastrar Nova Forma de Pagamento';?></h4>

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
                                                <input type="hidden" class="input-id" value="<?= $forma_pagamento['id'] ?? ''; ?>">

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Nome</label>
                                                    <input class="form-control input-formapagamento input-obrigatorio" type="text" placeholder="Nome da Forma de Pagamento" value="<?= $forma_pagamento['forma_pagamento'] ?? ''; ?>">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>
                                                
                                                <div class="mb-3 col-md-6">
                                                    <div class="mb-2">
                                                        <label class="form-label text-900">Tipo de pagamento</label>

                                                        <select required class="form-select campo-empresa select2 input-tipopagamento">
                                                            <option value="" selected disabled>Selecione o tipo</option>

                                                            <?php foreach ($tipo_pagamento as $v) { ?>
                                                                <option value="<?= $v['id'] ?>" <?= (isset($forma_pagamento['id_tipo_pagamento']) && $forma_pagamento['id_tipo_pagamento'] == $v['id']) ? 'selected' : ''; ?>><?= $v['nome']; ?></option>
                                                            <?php } ?>

                                                        </select>
                                                        <div class="invalid-feedback">Preencha este campo</div>
                                                    </div>
                                                </div>

                                                <div class="flex-1 text-end my-5">
                                                    <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraFormaPagamento()"><?=$this->uri->segment(3) ? 'Editar' : 'Cadastrar';?>
                                                        <span class="fas fa-chevron-right" data-fa-transform="shrink-3" > </span>
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