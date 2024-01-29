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
                    <select class="form-select w-100 select2" id="select-etiqueta" >

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
                        <?php foreach($alertas as $alerta) {?>
                        <option value="<?= $alerta['texto_alerta']?>"><?= $alerta['titulo']?></option>
                        <?php }?>

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
<div class="modal fade modalSelect2" id="modalResiduo" >
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
                    <select class="form-select w-100 select2" id="select-residuo" >

                        <option disabled selected value="">Selecione residuos</option>
                        <?php foreach ($residuos as $v) { ?>
                            <option value="<?= $v['id'] ?>"><?= $v['nome']; ?></option>
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

                <div class="my-2 div-grupo-cliente">
                    <!-- Manipulado ajax -->
                </div>

                <div class="add-grupo-cliente w-100 my-3 mb-4">

                    <input type="hidden" class="id-cliente">

                    <label>Atribuir novos Grupos</label>
                    <select class="form-select w-100 select2" id="select-grupo-cliente" >

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