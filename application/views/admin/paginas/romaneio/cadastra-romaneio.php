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
                                <div class="tab-pane row" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-validation-tab2"
                                    id="bootstrap-wizard-validation-tab2">
                                    <form method="post" class="needs-validation" novalidate="novalidate"
                                        data-wizard-form="1">

                                        <div class="row">

                                            <div class="mb-2 col-md-3">
                                                <label>Escolha o setor</label>
                                                <select class="form-select w-100 select-setor select2"
                                                    id="select-setor">

                                                    <option disabled selected value="">Selecione o setor</option>
                                                    <?php foreach ($setores as $setor) { ?>
                                                        <option value="<?= $setor['id_setor_empresa'] ?>">
                                                            <?= strtoupper($setor['nome']); ?>
                                                        </option>
                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <div class="mb-2 col-md-3">
                                                <label>Etiquetas</label>
                                                <select disabled id="select-etiquetas"
                                                    class="form-select w-100 mb-3 select2 input-filtro-romaneio"
                                                    multiple data-placeholder="Selecione a(s) etiqueta(s)">
                                                    <!-- JS -->
                                                </select>
                                            </div>

                                            <div class="mb-2 col-md-3">
                                                <label>Cidades</label>
                                                <select disabled id="select-cidades"
                                                    class="form-select w-100 mb-3 select2 input-filtro-romaneio"
                                                    multiple data-placeholder="Selecione a(s) cidade(s)">
                                                    <!-- JS -->
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <label>Data Agendamento</label>

                                                <input class="form-control datetimepicker input-coleta" required
                                                    name="data_coleta" type="text" placeholder="Data Agendamento"
                                                    data-options='{"disableMobile":true,"allowInput":true}'
                                                    style="cursor: pointer;" />
                                                <span><input id="filtrar-data" type="checkbox"
                                                        autocomplete="off" /><small> Filtrar por data</small></span>
                                            </div>

                                            <div class="flex-1 text-end my-5">
                                                <button class="btn px-3 btn-phoenix-secondary btn-envia-romaneio"
                                                    onclick="filtrarClientesRomaneio()" type="button">
                                                    Buscar Clientes <span class="fa-solid fa-filter text-primary"
                                                        data-fa-transform="down-3"></span>
                                                </button>
                                                <div class="spinner-border text-primary load-form d-none load-form-romaneio"
                                                    role="status"></div>
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
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gerar um Romaneio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="busca-clientes mb-2">
                        <input type="text" id="searchInput" placeholder="Buscar clientes" class="form-control">
                    </div>

                    <div class="table-responsive scrollbar ms-n1 ps-1">
                        <table class="table table-sm fs--1 mb-0">
                            <tbody class="list clientes-modal-romaneio" id="members-table-body">
                                <!-- Manipulado JS -->
                            </tbody>

                        </table>

                        <i class="fas fa-plus mt-2 add-cliente btn btn-phoenix-secondary"
                            style="cursor: pointer; float: right"></i>


                    </div>

                    <div class="div-select-modal d-none">
                        <label>Atribuir novo cliente ao romaneio</label>
                        <select class="form-select w-100 mb-3 select2" id="select-cliente-modal">

                            <option selected value="">Selecione o cliente</option>


                        </select>
                    </div>

                </div>
                <div class="modal-footer">

                    <div class="col-12">

                        <select class="form-select w-100 input-obrigatorio select2" id="select-responsavel">
                            <option selected disabled>Selecione o responsável</option>
                            <?php
                            foreach ($responsaveis as $v) { ?>
                                <option value="<?= $v['IDFUNCIONARIO'] ?>"> <?= $v['nome'] ?> | <?= $v['CARGO'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                    </div>

                    <div class="col-12">

                        <select class="form-select w-100 input-obrigatorio select2" id="select-veiculo">
                            <option selected disabled>Selecione o veículo</option>
                            <?php
                            foreach ($veiculos as $veiculo) { ?>
                                <option value="<?= $veiculo['id'] ?>"> <?= $veiculo['modelo'] ?> |
                                    <?= strtoupper($veiculo['placa']) ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                    </div>


                    <div class="spinner-border text-primary load-form d-none load-form-modal-romaneio" role="status">
                    </div>
                    <input type="hidden" class="id-setor-empresa">
                    <input type="hidden" class="todos-clientes">
                    <input type="hidden" class="ids-selecionados">
                    <button type="button" class="btn btn-primary btn-salva-romaneio">Gerar Romaneio</button>
                </div>
            </div>
        </div>
    </div>


    <!-- lançar saldo para saída do motorista-->
    <div class="modal fade modal-romaneio-select2" id="modalSaldoMotoristaRomaneio" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollabe modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verba para o responsável pela coleta</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0 form-verba-responsavel-coleta">


                                            <div class="row">
                                                <div class="col-lg-6">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Grupos
                                                            Macros</label>
                                                        <select
                                                            class="form-select select2 select-macros input-obrigatorio-verba"
                                                            name="id_macro">
                                                            <option selected disabled value="">Selecione</option>
                                                            <?php foreach ($macros as $macro) { ?>
                                                                <option value="<?= $macro['id'] ?>"><?= $macro['nome'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                    </div>

                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-4 ">
                                                        <label class="text-body-highlight fw-bold mb-2 ">Grupos
                                                            Micros</label>
                                                        <select disabled
                                                            class="form-select select2 select-micros input-obrigatorio-verba"
                                                            name="id_micro">
                                                            <option selected disabled value="">Selecione</option>
                                                            <!-- JS -->
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="campos-pagamento row">
                                                <div class="col-lg-4 duplica-pagamento">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Conta
                                                            Bancária</label>
                                                        <select name="conta-bancaria"
                                                            class="form-select select2 select-conta-bancaria input-obrigatorio-verba">
                                                            <option value="" selected disabled>Selecione</option>
                                                            <?php foreach ($contasBancarias as $contaBancaria) { ?>
                                                                <option value="<?= $contaBancaria['id_conta_bancaria'] ?>">
                                                                    <?= $contaBancaria['apelido'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 duplica-pagamento">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Forma
                                                            Pagamento</label>
                                                        <select name="forma-pagamento"
                                                            class="form-select select2 select-forma-pagamento input-obrigatorio-verba">
                                                            <option value="" selected disabled>Selecione</option>
                                                            <?php foreach ($formasTransacao as $formaTransacao) { ?>
                                                                <option value="<?= $formaTransacao['id'] ?>">
                                                                    <?= $formaTransacao['nome'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 duplica-pagamento">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                        <input
                                                            class="form-control input-valor-recebido mascara-dinheiro input-valor-unic input-obrigatorio-verba"
                                                            required name="valor" type="text" placeholder="Valor">
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 mt-5">
                                                    <button title="Mais formas de pagamento" type="button"
                                                        class="btn btn-phoenix-success bg-white hover-bg-100 duplicar-pagamento">+</button>
                                                </div>

                                                <div class="campos-duplicados">
                                                    <!-- JS -->
                                                </div>

                                                <div class="mt-2">

                                                    <input type="checkbox"
                                                        class="check-sem-verba form-check-input cursor-pointer"> Sem
                                                    Verba
                                                </div>

                                            </div>


                                        </div>




                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="modal-footer">
                    <div class="spinner-border text-primary load-form-pagamento d-none" role="status"></div>
                    <button type="button" class="btn btn-primary btn-salva-verba-responsavel">Salvar</button>

                </div>
            </div>
        </div>
    </div>