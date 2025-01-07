<div class="content">
    <div class="row mb-9">

        <div class="col-12">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0"><?= $this->uri->segment(3) ? 'Editar Conversão' : 'Cadastrar Nova Conversão'; ?></h4>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="pt-0">
                        <div class="p-4 code-to-copy">
                            <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

                                <div class="card-body pt-4 pb-0 row">
                                    <input type="hidden" class="input-id" value="<?= $conversaoUnidadeMedida['id'] ?? ''; ?>">

                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label class="form-label text-900">Resíduo</label>
                                            <select class="form-select select-residuo input-obrigatorio select2">
                                                <option value="" selected disabled>Selecione</option>
                                                <?php foreach ($residuos as $residuo) { ?>
                                                    <option <?= isset($conversaoUnidadeMedida['id_residuo']) && $conversaoUnidadeMedida['id_residuo'] == $residuo['id'] ? "selected" : "" ?> value="<?= $residuo['id'] ?>"><?= $residuo['nome'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label class="form-label text-900">Medida Inicial</label>
                                            <select class="form-select select-medida-inicial input-obrigatorio select2">
                                                <option value="" selected disabled>Selecione</option>

                                                <?php foreach ($unidadesMedidas as $unidadeMedida) { ?>

                                                    <option <?= isset($conversaoUnidadeMedida['id_medida_origem']) && $conversaoUnidadeMedida['id_medida_origem'] == $unidadeMedida['id'] ? "selected" : "" ?> value="<?= $unidadeMedida['id'] ?>"><?= $unidadeMedida['nome'] ?></option>
                                                <?php } ?>


                                            </select>
                                            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Valor</label>
                                        <input class="form-control input-valor input-obrigatorio" type="text" placeholder="Valor para operação" value="<?= isset($conversaoUnidadeMedida['valor']) ? $conversaoUnidadeMedida['valor'] : ""?>">
                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label class="form-label text-900">Operador</label>
                                            <select class="form-select select-operador input-obrigatorio">
                                                <option value="" selected disabled>Selecione</option>
                                                <option <?= isset($conversaoUnidadeMedida['tipo_operacao']) && $conversaoUnidadeMedida['tipo_operacao'] == '*' ? 'selected' : ""?> value="*">x</option>
                                                <option <?= isset($conversaoUnidadeMedida['tipo_operacao']) && $conversaoUnidadeMedida['tipo_operacao'] == '/' ? 'selected' : ""?> value="/">÷</option>
                                                <option <?= isset($conversaoUnidadeMedida['tipo_operacao']) && $conversaoUnidadeMedida['tipo_operacao'] == '-' ? 'selected' : ""?> value="-">-</option>
                                                <option <?= isset($conversaoUnidadeMedida['tipo_operacao']) && $conversaoUnidadeMedida['tipo_operacao'] == '+' ? 'selected' : ""?> value="+">+</option>
                                            </select>
                                            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label class="form-label text-900">Medida Final</label>
                                            <select class="form-select select-medida-final input-obrigatorio select2">
                                                <option value="" selected disabled>Selecione</option>

                                                <?php foreach ($unidadesMedidas as $unidadeMedida) { ?>
                                                    <option <?= isset($conversaoUnidadeMedida['id_medida_destino']) && $conversaoUnidadeMedida['id_medida_destino'] == $unidadeMedida['id'] ? "selected" : "" ?> value="<?= $unidadeMedida['id'] ?>"><?= $unidadeMedida['nome'] ?></option>
                                                <?php } ?>

                                            </select>
                                            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                        </div>
                                    </div>

                                    <div class="flex-1 text-end my-4">
                                        <button class="btn btn-primary px-6 px-sm-6 btn-form" onclick="cadastraConversao()">
                                            <?= $this->uri->segment(3) ? 'Editar' : 'Cadastrar'; ?>
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