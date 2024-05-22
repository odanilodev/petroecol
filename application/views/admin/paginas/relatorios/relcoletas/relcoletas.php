<div class="content">
    <h2>Relatório de Coletas</h2>
    <div class="card-body p-0">

        <div class="p-4 code-to-copy">
            <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

                <div class="card-body pt-4 pb-0">
                    <div class="tab-pane row" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab2" id="bootstrap-wizard-validation-tab2">
                        <form method="post" class="needs-validation" novalidate="novalidate" data-wizard-form="1">

                            <div class="row">

                                <div class="mb-2 col-md-4">
                                    <label>Setores</label>
                                    <select id="select-setor" class="form-select w-100 mb-3 select2">

                                        <option value="" selected disabled>Selecione um setor</option>
                                        <option value="todos">Todos</option>

                                        <?php foreach ($setores as $setor) { ?>
                                            <option value="<?= $setor['id_setor_empresa'] ?>"><?= $setor['nome'] ?></option>
                                        <?php } ?>

                                    </select>
                                </div>

                                <div class="mb-2 col-md-4">
                                    <label>Grupos de clientes</label>
                                    <select id="select-grupos" class="form-select w-100 mb-3 select2" multiple data-placeholder="Grupos">

                                        <?php foreach ($grupos as $grupo) { ?>
                                            <option value="<?= $grupo['id'] ?>"><?= $grupo['nome'] ?></option>
                                        <?php } ?>

                                    </select>
                                </div>

                                <div class="mb-2 col-md-4">
                                    <label>Clientes</label>
                                    <select id="select-clientes" class="form-select w-100 mb-3 select2" multiple data-placeholder="Clientes">
                                        <?php foreach ($clientes as $cliente) { ?>
                                            <option value="<?= $cliente['id'] ?>"><?= $cliente['nome'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="mb-2 col-md-4">
                                    <label>Resíduos</label>
                                    <select id="select-residuos" class="form-select w-100 mb-3 select2" multiple data-placeholder="Resíduos">

                                        <?php foreach ($residuos as $residuo) { ?>
                                            <option value="<?= $residuo['id'] ?>"><?= $residuo['nome'] ?></option>
                                        <?php } ?>

                                    </select>
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label>Data Inicio</label>
                                    <input class="form-control datetimepicker input-data-inicio" required name="data_inicio" type="text" placeholder="Data Inicio" data-options='{"disableMobile":true,"allowInput":true}' style="cursor: pointer;" />
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label>Data Fim</label>
                                    <input class="form-control datetimepicker input-data-fim" required name="data_fim" type="text" placeholder="Data Fim" data-options='{"disableMobile":true,"allowInput":true}' style="cursor: pointer;" />
                                    <span><input id="filtrar-geral" type="checkbox"/><small> Filtrar geral</small></span>
                                </div>

                                <div class="flex-1 text-end my-5">
                                    <button class="btn px-3 btn-phoenix-secondary btn-relatorio-coletas" onclick="relatorioColetas()" type="button">
                                        Gerar PDF <span class="fa-solid fa-filter text-primary" data-fa-transform="down-3"></span>
                                    </button>
                                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                                </div>

                        </form>
                    </div>


                </div>

            </div>
        </div>
    </div>