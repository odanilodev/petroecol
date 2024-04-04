<!-- Modal de etiquetas para clientes -->
<div class="modal fade modalSelect2" id="modalEtiqueta">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Etiquetas</h5>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <div class="modal-body">

                <div class="my-2 div-etiquetas">
                    <!-- Manipulado ajax -->
                </div>

                <div class="add-etiqueta w-100 my-3 mb-4">

                    <input type="hidden" class="id-cliente">

                    <label>Atribuir novas etiquetas</label>
                    <select class="form-select w-100 select2" id="select-etiqueta">

                        <option selected disabled value="">Selecione etiquetas</option>
                        <?php foreach ($etiquetas as $e) { ?>
                            <option value="<?= $e['id'] ?>"><?= $e['nome']; ?></option>
                        <?php } ?>

                    </select>

                </div>
            </div>

            <div class="modal-footer">

                <div class="spinner-border text-primary load-form d-none" role="status"></div>

                <button class="btn btn-success btn-salva-etiqueta btn-form" type="button" onclick="cadastraEtiquetaCliente()">Salvar</button>
                <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal de alertas para clientes -->
<div class="modal fade" id="modalAlertas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alertas</h5>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <div class="modal-body">

                <div class="add-residuo w-100 my-3 mb-4">

                    <input type="hidden" class="id-cliente">

                    <select class="form-select w-100" id="select-alertas">

                        <option disabled selected value="">Selecione</option>
                        <?php foreach ($alertas as $alerta) { ?>
                            <option value="<?= $alerta['texto_alerta'] ?>"><?= $alerta['titulo'] ?></option>
                        <?php } ?>

                    </select>

                </div>
            </div>

            <div class="modal-footer">

                <div class="spinner-border text-primary load-form d-none" role="status"></div>

                <button class="btn btn-success btn-form" type="button" onclick="enviarAlertaCliente()">Enviar</button>
                <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal de residuos para clientes -->
<div class="modal fade modalSelect2" id="modalResiduo">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Residuos</h5>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <div class="modal-body">

                <div class="my-2 div-residuos">
                    <!-- Manipulado ajax -->
                </div>

                <div class="add-residuo w-100 my-3 mb-4">

                    <input type="hidden" class="id-cliente">

                    <label>Atribuir novos resíduos *</label>
                    <select class="form-select w-100 select2" id="select-residuo">

                        <option disabled selected value="">Selecione residuos</option>
                        <?php foreach ($residuos as $v) { ?>
                            <option value="<?= $v['id'] ?>"><?= $v['nome']; ?></option>
                        <?php } ?>

                    </select>

                </div>

                <div class="add-residuo w-100 my-3 mb-4">

                    <label>Forma de pagamento</label>
                    <select class="form-select w-100 select2" id="forma-pagamento-residuo">

                        <option disabled selected value="">Selecione a forma de pagamento</option>
                        <?php foreach ($formasPagamento as $formaPagamento) { ?>
                            <option value="<?= $formaPagamento['id'] ?>" data-id-tipo-pagamento="<?= $formaPagamento['id_tipo_pagamento'] ?>"><?= $formaPagamento['forma_pagamento']; ?></option>
                        <?php } ?>

                    </select>

                </div>

                <div class="add-residuo w-100 my-3 mb-4">

                    <label>Valor</label>
                    <?= botao_info(chave('clientes-menu-residuos-valor')) ?>
                    <input type="text" class="w-100 form-control" placeholder="Valor" id="valor-pagamento-residuo">

                </div>
            </div>

            <div class="modal-footer">

                <div class="spinner-border text-primary load-form d-none" role="status"></div>
                <input type="hidden" class="input-editar-residuo">
                <button class="btn btn-success btn-salva-residuo btn-form" type="button" onclick="cadastraResiduoCliente()">Salvar</button>
                <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

            </div>
        </div>
    </div>
</div>


<!-- Modal de recipientes para clientes -->
<div class="modal fade " id="modalRecipiente">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recipientes</h5>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <div class="modal-body">

                <div class="my-2 div-recipientes">
                    <!-- Manipulado ajax -->
                </div>

                <div class="add-recipiente w-100 my-3 mb-4">

                    <input type="hidden" class="id-cliente">

                    <label>Atribuir novos recipientes</label>
                    <select class="form-select w-100 mb-3 select2" id="select-recipiente">

                        <option selected disabled value="">Selecione recipientes</option>
                        <?php foreach ($recipientes as $v) { ?>
                            <option value="<?= $v['id'] ?>"><?= $v['nome_recipiente']; ?></option>
                        <?php } ?>

                    </select>

                    <input type="number" class="w-100 form-control mt-4" id="quantidade-recipiente" placeholder="Quantidade">

                </div>
            </div>

            <div class="modal-footer">

                <div class="spinner-border text-primary load-form d-none" role="status"></div>

                <button class="btn btn-success btn-salva-recipiente btn-form" type="button" onclick="cadastraRecipienteCliente()">Salvar</button>
                <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal de grupos para clientes -->
<div class="modal fade modalSelect2" id="modalGrupoCliente">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Grupos</h5>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <div class="modal-body">

                <div class="my-2 div-grupos">
                    <!-- Manipulado ajax -->
                </div>

                <div class="add-grupo-cliente w-100 my-3 mb-4">

                    <input type="hidden" class="id-cliente">

                    <label>Atribuir novos Grupos</label>
                    <select class="form-select w-100 select2" id="select-grupo-cliente">

                        <option selected disabled value="">Selecione os Grupos</option>
                        <?php foreach ($grupos as $v) { ?>
                            <option value="<?= $v['id'] ?>"><?= $v['nome']; ?></option>
                        <?php } ?>

                    </select>

                </div>
            </div>

            <div class="modal-footer">

                <div class="spinner-border text-primary load-form d-none" role="status"></div>

                <button class="btn btn-success btn-salva-grupo-cliente btn-form" type="button" onclick="cadastraGrupoCliente()">Salvar</button>
                <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal de setores de empresa para clientes -->
<div class="modal fade modalSelect2" id="modalSetoresEmpresaCliente">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setores da Empresa <span class="editando-txt"></span></h5>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <div class="modal-body">

                <div class="my-2 div-setor-empresa">
                    <!-- Manipulado ajax -->
                </div>

                <div class="add-setor-empresa w-100 my-3 mb-4">
                    <input type="hidden" class="id-cliente">

                    <label>Atribuir novos setores</label>
                    <select class="form-select w-100 select2 select-nome-setor-empresa input-obrigatorio">

                        <option selected disabled value="">Selecione setores</option>
                        <?php foreach ($setoresEmpresa as $s) { ?>
                            <option value="<?= $s['id'] ?>"><?= $s['nome']; ?></option>
                        <?php } ?>

                    </select>
                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                </div>

                <div class="w-100 my-3 mb-4">
                    <input type="hidden" class="id-cliente">
                    <input type="hidden" class="input-editar-setor-empresa">

                    <label>Atribuir frequência de coleta</label>
                    <select class="form-select w-100 select2 select-frequencia-coleta-setor input-obrigatorio">

                        <option selected disabled value="">Selecione a frequência de coleta</option>
                        <?php foreach ($frequenciaColeta as $f) { ?>
                            <option value="<?= $f['id'] ?>"><?= $f['frequencia']; ?></option>
                        <?php } ?>

                    </select>
                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                </div>
                <div class="w-100 mb-2 col-md-12 fixo-coleta <?= ($cliente['dia_coleta_fixo'] ?? false) || ($cliente['frequencia'] ?? '') === 'Fixo' ? 'd-block' : 'd-none' ?>  ">
                    <div class="mb-2">
                        <label class="">Dia da Semana *</label>
                        <select name="dia_coleta_fixo" class="form-select campo-empresa select-dia-fixo select2">
                            <option value="" selected disabled>Selecione</option>
                            <option value="Domingo" <?= (isset($cliente['dia_coleta_fixo']) && $cliente['dia_coleta_fixo'] == 'Domingo') ? 'selected' : ''; ?>>Domingo</option>
                            <option value="Segunda" <?= (isset($cliente['dia_coleta_fixo']) && $cliente['dia_coleta_fixo'] == 'Segunda') ? 'selected' : ''; ?>>Segunda</option>
                            <option value="Terça" <?= (isset($cliente['dia_coleta_fixo']) && $cliente['dia_coleta_fixo'] == 'Terça') ? 'selected' : ''; ?>>Terça</option>
                            <option value="Quarta" <?= (isset($cliente['dia_coleta_fixo']) && $cliente['dia_coleta_fixo'] == 'Quarta') ? 'selected' : ''; ?>>Quarta</option>
                            <option value="Quinta" <?= (isset($cliente['dia_coleta_fixo']) && $cliente['dia_coleta_fixo'] == 'Quinta') ? 'selected' : ''; ?>>Quinta</option>
                            <option value="Sexta" <?= (isset($cliente['dia_coleta_fixo']) && $cliente['dia_coleta_fixo'] == 'Sexta') ? 'selected' : ''; ?>>Sexta</option>
                            <option value="Sabado" <?= (isset($cliente['dia_coleta_fixo']) && $cliente['dia_coleta_fixo'] == 'Sabado') ? 'selected' : ''; ?>>Sábado</option>

                        </select>
                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                    </div>
                </div>

                <div class="w-100 mb-3 col-md-12">
                    <div class="mb-2">
                        <label>Transação</label>
                        <select name="transacao-coleta" class="input-obrigatorio form-select select-transacao-coleta-setor">
                            <option value="" selected disabled>Selecione</option>
                            <option value="0">Pago pra coletar</option>
                            <option value="1">Recebe pra coletar</option>
                        </select>
                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                    </div>
                </div>

                <div class="mb-3 col-md-12">
                    <label>Dia de pagamento</label>
                    <input class="form-control dia-pagamento" type="number" name="dia-pagamento" value="<?= $setoresEmpresaCliente['dia_pagamento'] ?? ''; ?>" placeholder="Dia de pagamento" />
                </div>

                <div class="mb-3 col-md-12">
                    <label>Forma de pagamento</label>
                    <select required name="id-forma-pagamento" class="form-select forma-pagamento-setor select2 input-obrigatorio">
                        <option value="" selected disabled>Selecione</option>

                        <?php foreach ($formasPagamento as $v) { ?>
                            <option value="<?= $v['id'] ?>" <?= (isset($formasPagamento['id']) && $formasPagamento['id'] == $v['id']) ? 'selected' : ''; ?>><?= $v['forma_pagamento']; ?></option>
                        <?php } ?>

                    </select>
                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                </div>

                <div class="col-md-12 mb-3">
                    <label>Observação para a Forma de Pagamento</label>
                    <textarea name="observacao-pagamento" class="form-control observacao-pagamento-setor" rows="1"><?= $setoresEmpresaCliente['observacao_pagamento'] ?? ''; ?></textarea>
                </div>

            </div>

            <div class="modal-footer">

                <div class="spinner-border text-primary load-form d-none" role="status"></div>

                <button class="btn btn-success btn-salva-setor-etiqueta btn-form" type="button" onclick="cadastraSetorEmpresaCliente()">Salvar</button>
                <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

            </div>
        </div>
    </div>
</div>