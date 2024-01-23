<div class="content">

    <div class="row mb-9">

        <div class="col-12">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0">Novo Romaneio</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">

                    <div class="p-4 code-to-copy">
                        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

                            <div class="card-body pt-4 pb-0">
                                <div class="tab-pane row" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab2" id="bootstrap-wizard-validation-tab2">
                                    <form method="post" class="needs-validation" novalidate="novalidate" data-wizard-form="1">

                                        <div class="row">

                                            <div class="mb-2 col-md-4">
                                                <label>Etiquetas</label>
                                                <select id="select-etiquetas" class="form-seledct input-filtro-romaneio w-100 mb-3" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}' multiple>

                                                    <?php foreach ($etiquetas as $v) { ?>
                                                        <option value="<?= $v['id'] ?>"><?= $v['nome'] ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label>Cidades</label>
                                                <select id="select-cidades" class="form-seledct input-filtro-romaneio w-100 mb-3" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}' multiple>

                                                    <?php foreach ($cidades as $v) { ?>
                                                        <option value="<?= $v['cidade'] ?>"><?= $v['cidade'] ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-2">
                                                <label>Data Agendamento</label>

                                                <input class="form-control datetimepicker input-coleta" required name="data_coleta" type="text" placeholder="Data Agendamento" data-options='{"disableMobile":true,"allowInput":true}' style="cursor: pointer;" />
                                                <span><input id="filtrar-data" type="checkbox"/><small> Filtrar por data</small></span>
                                            </div>

                                            <div class="flex-1 text-end my-5">
                                                <button class="btn px-3 btn-phoenix-secondary btn-envia-romaneio" onclick="filtrarClientesRomaneio()" type="button">
                                                    Buscar Clientes <span class="fa-solid fa-filter text-primary" data-fa-transform="down-3"></span>
                                                </button>
                                                <div class="spinner-border text-primary load-form d-none load-form-romaneio" role="status"></div>
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


    <!-- Modal Romaneio-->
    <div class="modal fade" id="modalRomaneio" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gerar um Romaneio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive scrollbar ms-n1 ps-1">
                        <table class="table table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="align-middle" scope="col">Cliente</th>
                                    <th class="sort pe-3">Etiqueta/Cidade</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="list clientes-modal-romaneio" id="members-table-body">
                                <!-- Manipulado JS -->
                            </tbody>

                        </table>
                        <i class="fas fa-plus-square mt-2 add-cliente " style="cursor: pointer;"></i>

                    </div>

                    <div class="div-select-modal d-none">
                        <label>Atribuir novo cliente ao romaneio</label>
                        <select class="form-select w-100 mb-3" id="select-cliente-modal" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}'>

                            <option selected value="">Selecione o cliente</option>

                            <?php foreach ($clientes as $v) { ?>
                                <option value="<?= $v['ID_CLIENTE'] ?>|<?= $v['cidade'] ?>|<?= empty($v['ETIQUETA']) ? 'Sem etiqueta' : $v['ETIQUETA'] ?>"><?= $v['nome'] ?></option>
                            <?php } ?>

                        </select>
                    </div>

                </div>
                <div class="modal-footer">

                    <select class="form-select w-40 input-obrigatorio" id="select-responsavel">
                        <option selected disabled>Selecione o responsável</option>
                        <?php
                            foreach ($responsaveis as $v) { ?>
                            <option value="<?= $v['IDFUNCIONARIO']?>"> <?= $v['nome'] ?> | <?= $v['CARGO']?></option>
                        <?php }  ?>
                    </select>
                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                    <select class="form-select w-40 input-obrigatorio" id="select-veiculo">
                        <option selected disabled>Selecione o veículo</option>
                        <?php
                            foreach ($veiculos as $veiculo) { ?>
                            <option value="<?= $veiculo['id']?>"> <?= $veiculo['modelo'] ?> | <?= strtoupper($veiculo['placa'])?></option>
                        <?php }  ?>
                    </select>
                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                    
                    <div class="spinner-border text-primary load-form d-none load-form-modal-romaneio" role="status"></div>
                    <button type="button" class="btn btn-primary btn-salva-romaneio" onclick="gerarRomaneio()">Gerar Romaneio</button>
                </div>
            </div>
        </div>
    </div>