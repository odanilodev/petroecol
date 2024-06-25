<div class="content">


    <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
        <div id="members" data-list='{"valueNames":["td_funcionario","td_saldo"],"page":10,"pagination":true}'>
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <h3>Prestação de Contas</h3>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="row g-2 gy-3">

                        <div class="col-auto flex-1">
                            <div class="search-box">
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input class="form-control search-input search form-control-sm" type="search" placeholder="Buscar" aria-label="Search" />
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr class="text-center">
                            <th class="white-space-nowrap" scope="col" data-sort="td_funcionario">Funcionario</th>
                            <th class="align-middle" scope="col" data-sort="td_recebido">Saldo</th>
                            <th class="text-end pe-0 align-middle" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">

                        <?php foreach ($prestacaoContas as $prestacaoConta) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static text-center">

                                <td class="align-middle text-center data white-space-nowrap td_funcionario">
                                    <h6 class="mb-0 text-900 text-center">
                                        <?= $prestacaoConta['nome']; ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-center data white-space-nowrap">
                                    <h6 class="mb-0 text-900 text-center">
                                        R$ <?= number_format($prestacaoConta['saldo'], 2, ',', '.'); ?>
                                    </h6>
                                    <div class="td_saldo">
                                        <input type="hidden" value="<?= $prestacaoConta['saldo'] ?>">
                                    </div>
                                </td>


                                <td class="align-middle white-space-nowrap text-end pe-0">
                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a data-funcionario="<?= $prestacaoConta['nome'] ?>" data-saldo="<?= number_format($prestacaoConta['saldo'], 2, ',', '.'); ?>" data-id="<?= $prestacaoConta['id'] ?>" class="dropdown-item btn-prestar-contas" href="#!" data-bs-toggle="modal" data-bs-target="#modalPrestarConta">
                                                Prestar Conta
                                            </a>

                                        </div>
                                    </div>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div>

            <!-- Links de Paginação usando classes Bootstrap -->
            <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
                <div class="col-auto d-none">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">Ver todos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">Ver menos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="col-auto d-flex w-100 justify-content-end mt-2 mb-2">
                    <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Prestar Contas -->
    <div class="modal fade" tabindex="-1" id="modalPrestarConta">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Prestar Conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body form-editar-pagar">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-12 mb-3">
                                                <p>
                                                    <span class="nome-funcionario"></span>
                                                    - <span class="saldo-funcionario"></span>
                                                </p>
                                            </div>


                                            <div class="col-lg-12">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data</label>
                                                    <input class="form-control datetimepicker data-romaneio input-obrigatorio-modal" required type="text" placeholder="Escolha uma Data" data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>

                                            <div class="col-lg-6 duplica-pagamento">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Tipo de custo</label>
                                                    <select class="form-select select2 input-obrigatorio-modal select-tipos-custos" name="tipos-custos">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($tiposCustos as $tipoCusto) { ?>
                                                            <option value="<?= $tipoCusto['id'] ?>"><?= $tipoCusto['nome']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 duplica-pagamento">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                    <input class="form-control input-obrigatorio-modal mascara-dinheiro input-valor" required name="valor" type="text" placeholder="Valor total da conta">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-2 mt-5">
                                                <button title="Mais custos" type="button" class="btn btn-phoenix-success duplicar-pagamento">+</button>
                                            </div>

                                            <div class="campos-duplicados">
                                                <!-- JS -->
                                            </div>

                                            <div class="col-lg-6 mt-4">

                                                <div class="mb-4 div-select-macro">
                                                    <label class="text-body-highlight fw-bold mb-2">Grupos Macros</label>
                                                    <select class="form-select select2 select-macros input-obrigatorio dados-conta" name="macros">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($macros as $macro) { ?>
                                                            <option value="<?= $macro['id'] ?>"><?= $macro['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-6 mt-4">
                                                <div class="mb-4 div-select-micro">
                                                    <label class="text-body-highlight fw-bold mb-2 ">Grupos Micros</label>
                                                    <select disabled class="form-select select2 select-micros input-obrigatorio dados-conta" name="micros">
                                                        <option selected disabled value="">Selecione</option>
                                                        <!-- JS -->
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>


                                            <div class="col-md-4">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Conta Bancária</label>
                                                    <select class="form-select select2 select-conta-bancaria">
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

                                            <div class="col-md-4">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Forma Pagamento</label>
                                                    <select class="form-select select2 select-forma-pagamento">
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

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Troco devolvido</label>
                                                    <input class="form-control mascara-dinheiro input-valor valor-devolvido" required name="valor-devolvido" type="text" placeholder="Valor total devolvido">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="div-obs d-none">
                                                <textarea class="form-control observacao" rows="2" name="observacao" value="" placeholder="Descreva o tipo de gasto"></textarea>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <p><span class="total-troco"></span></p>

                        </div>
                    </div>
                </div>

                <div class="modal-footer ">
                    
                    <input type="hidden" class="id-funcionario">
                    <input type="hidden" class="input-saldo-funcionario">
                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button class="btn btn-success btn-form btn-salvar-prestacao" type="button" onclick="salvarPrestacaoContas()">Salvar</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>