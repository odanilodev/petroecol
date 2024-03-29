<div class="content">

    <div class="pb-5">
        <div class="row g-4">
            <div class="col-12 col-xxl-12">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-success-300"
                                    data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100"
                                    data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-success "
                                    data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ 2.212.323,05</h4>
                                <p class="text-800 fs--1 mb-0">Caixa Óleo</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-success-300"
                                    data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100"
                                    data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-success "
                                    data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ 2.212.323,05</h4>
                                <p class="text-800 fs--1 mb-0">Caixa Reciclagem</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-warning-300"
                                    data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100"
                                    data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-warning "
                                    data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ 2.212.323,05</h4>
                                <p class="text-800 fs--1 mb-0">Previsão Caixa Óleo</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-warning-300"
                                    data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100"
                                    data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-warning "
                                    data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ 2.212.323,05</h4>
                                <p class="text-800 fs--1 mb-0">Previsão Caixa Reciclagem</p>
                            </div>
                        </div>
                    </div>

                </div>
                <hr class="bg-200 mb-6 mt-3" />
            </div>

            <div class="col-12">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-md-3">


                        <div class="ms-3">

                            <input class="form-control datetimepicker" required name="data_inicio" type="text"
                                placeholder="Data Início" data-options='{"disableMobile":true,"allowInput":true}'
                                style="cursor: pointer;" />

                        </div>
                    </div>
                    <div class="col-12 col-md-3">

                        <div class="ms-3">

                            <input class="form-control datetimepicker" required name="data_fim" type="text"
                                placeholder="Data Fim" data-options='{"disableMobile":true,"allowInput":true}'
                                style="cursor: pointer;" />

                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="ms-3">

                            <select class="select-validation select-orientacao" required>
                                <option selected disabled value=''>Empresa</option>
                                <option value="oleo">Óleo</option>
                                <option value="reciclagem">Reciclagem</option>
                                <option value="ambas">Ambas</option>
                            </select>

                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="ms-3">

                            <button type="button"
                                class="btn btn-phoenix-secondary bg-white hover-bg-100 w-100">Filtrar</button>

                        </div>
                    </div>

                </div>
                <hr class="bg-200 mb-6 mt-4" />
            </div>
        </div>
    </div>

    <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
        <div data-list='{"valueNames":["product","customer","rating","review","time"],"page":6}'>
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <h3>Fluxo de caixa</h3>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="row g-2 gy-3">

                        <div class="col-auto flex-1">
                            <div class="search-box">
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input class="form-control search-input search form-control-sm" type="search"
                                        placeholder="Buscar" aria-label="Search" />
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>
                        </div>

                        <div class="col-auto">

                            <button class="btn btn-sm btn-phoenix-secondary bg-white hover-bg-100 action-btn"
                                type="button" data-bs-toggle="modal" data-bs-target="#modalEntradaContasPagar">Novo
                                Lançamento</button>

                        </div>

                    </div>
                </div>
            </div>
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs--1 ps-0 align-middle">
                                <div class="form-check mb-0 fs-0">
                                    <input class="form-check-input" id="checkbox-bulk-reviews-select" type="checkbox"
                                        data-bulk-select='{"body":"table-latest-review-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle" scope="col" data-sort="data">Data</th>
                            <th class="sort align-middle" scope="col" data-sort="pagoRecebido">Pago/Recebido</th>
                            <th class="sort text-start align-middle" scope="col" data-sort="categoria">Forma de
                                Transação</th>
                            <th class="sort align-middle text-start" scope="col" data-sort="tipo">Tipo</th>
                            <th class="sort text-start ps-5 align-middle" scope="col" data-sort="valor">Valor</th>
                            <th class="sort text-start ps-5 align-middle" scope="col" data-sort="valor">Observação</th>
                            <th class="sort text-end pe-0 align-middle" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">

                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                            <?php foreach ($movimentacoes as $movimentacao) { ?>

                                <td class="fs--1 align-middle ps-0">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input" type="checkbox"
                                            data-bulk-select-row='{"product":"Fitbit Sense Advanced Smartwatch with Tools for Heart Health, Stress Management & Skin Temperature Trends, Carbon/Graphite, One Size (S & L Bands)","productImage":"/products/60x60/1.png","customer":{"name":"Richard Dawkins","avatar":""},"rating":5,"review":"This Fitbit is fantastic! I was trying to be in better shape and needed some motivation, so I decided to treat myself to a new Fitbit.","status":{"title":"Approved","badge":"success","icon":"check"},"time":"Just now"}' />
                                    </div>
                                </td>

                                <td class="align-middle data white-space-nowrap">
                                    <h6 class="mb-0 text-900">
                                        <?= date('d/m/Y', strtotime($movimentacao['data_movimentacao'])); ?>
                                    </h6>
                                </td>

                                <td class="align-middle pagoRecebido">
                                    <h6 class="mb-0 text-900">
                                        <?= ucfirst($movimentacao['nome_dado_financeiro']) ?>
                                    </h6>
                                </td>


                                <td class="align-middle text-start categoria">
                                    <h6 class="text-900 mb-0">
                                        <?= $movimentacao['nome_forma_transacao'] ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-start ps-3 tipo">
                                    <?php if ($movimentacao['movimentacao_tabela'] == 0): ?>
                                        <span class="badge badge-phoenix fs--2 badge-phoenix-warning">
                                            <span class="badge-label">Saída</span>
                                            <span class="ms-1" data-feather="trending-down"
                                                style="height:12.8px;width:12.8px;"></span>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-phoenix fs--2 badge-phoenix-success">
                                            <span class="badge-label">Entrada</span>
                                            <span class="ms-1" data-feather="trending-up"
                                                style="height:12.8px;width:12.8px;"></span>
                                        </span>
                                    <?php endif; ?>
                                </td>


                                <td class="align-middle text-center valor">
                                    <h6 class="mb-0 text-900">
                                        <?= 'R$ ' . number_format($movimentacao['valor'], 2, ',', '.') ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-start categoria">
                                    <h6 class="text-900 mb-0">
                                        <?= $movimentacao['observacao'] ?>
                                    </h6>
                                </td>

                                <td class="align-middle white-space-nowrap text-end pe-0">
                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                                class="fas fa-ellipsis-h fs--2"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item" href="#!" data-bs-toggle="modal"
                                                data-bs-target="#modalVisualizarFluxoCaixa">
                                                <span class="fas fa-eye"></span> Visualizar
                                            </a>


                                        </div>
                                    </div>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal visualizar constas a receber -->
    <div class="modal fade" tabindex="-1" id="modalVisualizarFluxoCaixa">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Entrada dia 10/04/2024</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">
                                            <div class="col-sm-12 col-xxl-12 border-bottom py-3">
                                                <table class="w-100 table-stats">
                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span
                                                                        class="text-info-600 dark__text-info-300 fas fa-id-card-alt"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Categoria</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">
                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break data-coleta html-clean">
                                                                Conta de Água
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300"
                                                                        data-feather="calendar"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Recebido</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">
                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break data-coleta html-clean">
                                                                Five Works (Escritorio)
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300"
                                                                        data-feather="calendar"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Valor</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">
                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break responsavel-coleta html-clean">

                                                                R$ 250,25
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span
                                                                        class="text-info-600 dark__text-info-300 fas fa-money-check-alt"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Histórico</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">

                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break residuos-coletados html-clean">
                                                                Liquidação de conta a pagar - Five Works (Escritorio)
                                                            </div>

                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Incluir lançamento Caixa -->

    <div class="modal fade" tabindex="-1" id="modalEntradaContasPagar">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Lançamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Tipo</label>
                                                    <select class="form-select select-tipo-conta">
                                                        <option selected disabled>Selecione</option>
                                                        <option value="1">Entrada</option>
                                                        <option value="0">Saída</option>

                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Cadastro
                                                        Financeiro</label>
                                                    <select name="cadastroFinanceiro"
                                                        class="form-select select-tipo-conta">
                                                        <option selected disabled>Selecione</option>
                                                        <option value="1">Ronaldo Fornecedor</option>
                                                        <option value="2">Saulo Cliente</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data</label>
                                                    <input class="form-control datetimepicker input-coleta" required
                                                        name="data_movimentacao" type="text" placeholder="dd/mm/aaaa"
                                                        data-options='{"disableMobile":true,"allowInput":true}'
                                                        style="cursor: pointer;" />
                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Conta
                                                        Bancária</label>
                                                    <select name='contaBancaria' class="form-select select2">
                                                        <option selected disabled>Selecione</option>
                                                        <option value="24">Bradesco</option>
                                                        <option value="25">Santander</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-4">
                                                    <label
                                                        class="text-body-highlight fw-bold mb-2 label-forma-pagamento">Forma
                                                        Pagamento</label>
                                                    <select name='formaPagamento' class="form-select select2">
                                                        <option selected disabled>Selecione</option>
                                                        <option value="1">Pix</option>
                                                        <option value="1">Débito</option>
                                                        <option value="1">Crédito</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                    <input class="form-control" required name="valor" type="text"
                                                        placeholder="Valor">
                                                </div>

                                            </div>


                                            <div class="col-lg-12">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                    <textarea name="observacao" class="form-control"></textarea>
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

                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button class="btn btn-success btn-form" type="button">Salvar</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>