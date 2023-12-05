<!-- Modal de etiquetas para clientes -->
<div class="modal fade" id="modalEtiqueta" tabindex="-1" aria-hidden="true">
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
                    <select class="form-select w-100" id="select-etiqueta" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}' multiple>

                        <option value="">Selecione etiquetas</option>
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

<!-- Modal de residuos para clientes -->
<div class="modal fade" id="modalResiduo" tabindex="-1" aria-hidden="true">
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

                    <label>Atribuir novos resíduos</label>
                    <select class="form-select w-100" id="select-residuo" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}'>

                        <option disabled selected value="">Selecione residuos</option>
                        <?php foreach ($residuos as $v) { ?>
                            <option value="<?= $v['id'] ?>"><?= strtoupper($v['nome']); ?></option>
                        <?php } ?>

                    </select>

                </div>
            </div>

            <div class="modal-footer">

                <div class="spinner-border text-primary load-form d-none" role="status"></div>

                <button class="btn btn-success btn-salva-residuo btn-form" type="button" onclick="cadastraResiduoCliente()">Salvar</button>
                <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

            </div>
        </div>
    </div>
</div>


<!-- Modal de recipientes para clientes -->
<div class="modal fade" id="modalRecipiente">
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
                    <select class="form-select w-100 mb-3" id="select-recipiente" >

                        <option selected disabled value="">Selecione recipientes</option>
                        <?php foreach ($recipientes as $v) { ?>
                            <option value="<?= $v['id'] ?>"><?= strtoupper($v['nome_recipiente']); ?></option>
                        <?php } ?>

                    </select>

                    <input type="number" class="w-100 form-control mt-4" id="quantidade-recipiente" placeholder="quantidade">

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