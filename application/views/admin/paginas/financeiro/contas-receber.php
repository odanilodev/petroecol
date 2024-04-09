<div class="content">

    <div class="pb-5">
        <div class="row g-4">
            <div class="col-12 col-xxl-6">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-md-4">
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
                    <div class="col-12 col-md-4">
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
                    <div class="col-12 col-md-4">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-warning-300"
                                    data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100"
                                    data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-warning"
                                    data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ 2.212.323,05</h4>
                                <p class="text-800 fs--1 mb-0">Contas a Receber</p>
                            </div>
                        </div>
                    </div>

                </div>
                <hr class="bg-200 mb-6 mt-3" />
            </div>

            <div class="col-12 col-xxl-6">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-md-3">


                        <div class="ms-3">

                            <select class="select-validation select-orientacao" required>
                                <option selected disabled value=''>Status</option>
                                <option value="horizontal">Horizontal</option>
                                <option value="vertical">Vertical</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-12 col-md-3">

                        <div class="ms-3">

                            <select class="select-validation select-orientacao" required>
                                <option selected disabled value=''>Selecione</option>
                                <option value="horizontal">Horizontal</option>
                                <option value="vertical">Vertical</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="ms-3">

                            <select class="select-validation select-orientacao" required>
                                <option selected disabled value=''>Selecione</option>
                                <option value="horizontal">Horizontal</option>
                                <option value="vertical">Vertical</option>
                            </select>

                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="ms-3">

                            <button type="button" class="btn btn-secondary w-100">Filtrar</button>

                        </div>
                    </div>

                </div>
                <hr class="bg-200 mb-6 mt-4" />
            </div>
        </div>
    </div>

    <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
        <div data-list='{"valueNames":["product","customer","rating","review","time"]}'>
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <h3>Contas a receber</h3>
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

                            <button
                                class="btn btn-sm btn-phoenix-secondary bg-white hover-bg-100 action-btn novo-lancamento"
                                type="button" data-bs-toggle="modal"
                                data-bs-target="#modalEntradaContasReceber">Lançamento</button>

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
                            <th class="sort white-space-nowrap align-middle" scope="col" data-sort="product">Vencimento
                            </th>
                            <th class="sort align-middle" scope="col" data-sort="rating">Valor</th>
                            <th class="sort text-start align-middle" scope="col" data-sort="time">Recebido</th>
                            <th class="sort text-start ps-5 align-middle" scope="col" data-sort="status">Status</th>
                            <th class="sort white-space-nowrap align-middle" scope="col" data-sort="product">Data
                                Recebimento</th>
                            <th class="sort align-middle" scope="col" data-sort="review">Valor Recebido</th>
                            <th class="sort text-end pe-0 align-middle" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">
                        <?php foreach ($contasReceber as $contaReceber) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                <td class="fs--1 align-middle ps-0">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input" type="checkbox"
                                            data-bulk-select-row='{"product":"Fitbit Sense Advanced Smartwatch with Tools for Heart Health, Stress Management & Skin Temperature Trends, Carbon/Graphite, One Size (S & L Bands)","productImage":"/products/60x60/1.png","customer":{"name":"Richard Dawkins","avatar":""},"rating":5,"review":"This Fitbit is fantastic! I was trying to be in better shape and needed some motivation, so I decided to treat myself to a new Fitbit.","status":{"title":"Approved","badge":"success","icon":"check"},"time":"Just now"}' />
                                    </div>
                                </td>

                                <td class="align-middle product white-space-nowrap">
                                    <h6 class="mb-0 text-900">
                                        <?= date('d/m/Y', strtotime($contaReceber['data_vencimento'])) ?>
                                    </h6>
                                </td>

                                <td class="align-middle rating white-space-nowrap fs--2">
                                    <h6 class="mb-0 text-900">
                                        <?= 'R$' . number_format($contaReceber['valor'], 2, ',', '.'); ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-start time">
                                    <h6 class="text-1000 mb-0">
                                        <?= $contaReceber['RECEBIDO'] ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-start ps-3 status">
                                    <span class="badge badge-phoenix fs--2 <?= $contaReceber['status'] ? "badge-phoenix-success" : "badge-phoenix-danger" ?> tipo-status-conta-<?= $contaReceber['id'] ?>">
                                        <span data-valor="<?= number_format($contaReceber['valor'], 2, ',', '.');?>"
                                            class="badge-label cursor-pointer receber-conta status-pagamento-table-<?= $contaReceber['id'] ?>"
                                            data-id-dado-financeiro="<?= $contaReceber['id_dado_financeiro'] ?>"
                                            data-id="<?= $contaReceber['id'] ?>" <?= !$contaReceber['status'] ? 'data-bs-toggle="modal" data-bs-target="#modalReceberConta"' : '' ?>>
                                            <?= $contaReceber['status'] ? "Recebido" : "A receber" ?>
                                        </span>

                                        <span class="ms-1 icone-status-conta-<?= $contaReceber['id'] ?>" data-feather="<?= $contaReceber['status'] ? "check" : "slash" ?>" style="height:12.8px;width:12.8px;"></span>
                                        
                                    </span>
                                </td>

                                <td class="align-middle product white-space-nowrap">
                                    <h6 class="mb-0 text-900">
                                        <?= $contaReceber['data_recebimento'] != "0000-00-00" ? date('d/m/Y', strtotime($contaReceber['data_recebimento'])) : '' ?>
                                    </h6>
                                </td>

                                <td class="align-middle rating white-space-nowrap fs--2">
                                    <h6 class="mb-0 text-900">
                                        <?= $contaReceber['valor_recebido'] ? 'R$' . number_format($contaReceber['valor_recebido'], 2, ',', '.') : 'Não Recebido' ?>
                                    </h6>
                                </td>

                                <td class="align-middle review">
                                    <h6 class="mb-0 text-900"></h6>
                                </td>

                                <td class="align-middle white-space-nowrap text-end pe-0">
                                    <div class="position-relative">
                                        <div class="hover-actions">
                                            <button title="Receber Conta"
                                                class="btn btn-sm btn-phoenix-success me-1 fs--2 receber-conta status-pagamento-<?= $contaReceber['id'] ?>"
                                                data-id-dado-financeiro="<?= $contaReceber['id_dado_financeiro'] ?>"
                                                data-id="<?= $contaReceber['id'] ?>" <?= !$contaReceber['status'] ? 'data-bs-toggle="modal" data-bs-target="#modalReceberConta"' : '' ?>>
                                                <span class="fas fa-check"></span>
                                            </button>
                                            <button class="btn btn-sm btn-phoenix-danger fs--2">
                                                <span class="fas fa-trash"></span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                                class="fas fa-ellipsis-h fs--2"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item" href="#!" data-bs-toggle="modal"
                                                data-bs-target="#modalVisualizarContasReceber">
                                                <span class="fas fa-eye"></span> Visualizar
                                            </a>
                                            <a class="dropdown-item" href="#!">
                                                <span class="fas fa-pencil"></span> Editar
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
    <div class="modal fade" tabindex="-1" id="modalVisualizarContasReceber">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalhes da conta</h5>
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
                                                                <p class="fw-bold mb-0">Empresa</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">
                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break data-coleta html-clean">
                                                                Centro da Inteligência
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
                                                                <p class="fw-bold mb-0">Data de vencimento</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">
                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break data-coleta html-clean">
                                                                10/04/2024
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
                                                                <p class="fw-bold mb-0">Data de Emissão</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">
                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break responsavel-coleta html-clean">
                                                                10/04/2024
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
                                                                <p class="fw-bold mb-0">Valor</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">

                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break residuos-coletados html-clean">
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
                                                                <p class="fw-bold mb-0">Valor Pago</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">

                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break residuos-coletados html-clean">
                                                                R$ 240,25
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
                                                                <p class="fw-bold mb-0">Valor em Aberto</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">

                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break residuos-coletados html-clean">
                                                                R$ 10,00
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
                                                                <p class="fw-bold mb-0">Observação</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">

                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break residuos-coletados html-clean">
                                                                observação detalhada aparecerá aqui
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

                    <button class="btn btn-success btn-form" type="button">Realizar Pagamento</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Entrada Contas a receber -->

    <div class="modal fade" tabindex="-1" id="modalEntradaContasReceber">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalhes da conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body form-entrada-receber">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Grupos
                                                        Macros</label>
                                                    <select class="form-select select2 select-macros input-obrigatorio"
                                                        name="macros">
                                                        <option selected disabled>Selecione</option>
                                                        <?php foreach ($macros as $macro) { ?>
                                                            <option value="<?= $macro['id'] ?>">
                                                                <?= $macro['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Grupos
                                                        Micros</label>
                                                    <select disabled
                                                        class="form-select select2 select-micros input-obrigatorio"
                                                        name="micros">
                                                        <option selected disabled value="">Selecione</option>

                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>



                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Recebido</label>
                                                    <select
                                                        class="form-select select2 select-recebido input-obrigatorio"
                                                        name="recebido">
                                                        <option selected disabled>Selecione</option>
                                                        <?php foreach ($dadosFinanceiro as $dadoFinanceiro) { ?>
                                                            <option value="<?= $dadoFinanceiro['id'] ?>">
                                                                <?= $dadoFinanceiro['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Parcelas</label>
                                                    <select class="form-select select2 select-parcelas" name="parcelas">
                                                        <option selected disabled>Selecione</option>
                                                        <option value="1">1x</option>
                                                        <option value="2">2x</option>
                                                        <option value="3">3x</option>
                                                        <option value="4">4x</option>
                                                        <option value="5">5x</option>
                                                        <option value="6">6x</option>
                                                        <option value="7">7x</option>
                                                        <option value="8">8x</option>
                                                        <option value="9">9x</option>
                                                        <option value="10">10x</option>
                                                        <option value="11">11x</option>
                                                        <option value="12">12x</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data
                                                        Vencimento</label>
                                                    <input
                                                        class="form-control datetimepicker cursor-pointer input-data-vencimento input-obrigatorio"
                                                        required name="data_vencimento" type="text"
                                                        placeholder="dd/mm/aaaa"
                                                        data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data Emissão</label>
                                                    <input
                                                        class="form-control datetimepicker cursor-pointer input-data-emissao"
                                                        required name="data_emissao" type="text"
                                                        placeholder="dd/mm/aaaa"
                                                        data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                    <input
                                                        class="form-control mascara-dinheiro input-valor input-obrigatorio"
                                                        required name="valor" type="text"
                                                        placeholder="Valor total da conta">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-8">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                    <textarea class="form-control observacao"
                                                        name="observacao"></textarea>
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
                    <button class="btn btn-primary btn-form" type="button"
                        onclick="cadastraContasReceber()">Salvar</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Receber conta -->
    <div class="modal fade" tabindex="-1" id="modalReceberConta">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Receber pagamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-md-4">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data
                                                        Recebimento</label>
                                                    <input
                                                        class="form-control datetimepicker input-data-recebimento cursor-pointer"
                                                        name="data_recebimento" type="text" placeholder="dd/mm/aaaa"
                                                        data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                                                </div>
                                            </div>

                                            <div class="campos-pagamento row">
                                                <div class="col-lg-4 duplica-pagamento">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Conta
                                                            Bancária</label>
                                                        <select class="form-select select2 select-conta-bancaria">
                                                            <option value="" selected disabled>Selecione</option>
                                                            <?php foreach ($contasBancarias as $contaBancaria) { ?>
                                                                <option value="<?= $contaBancaria['id_conta_bancaria'] ?>">
                                                                    <?= $contaBancaria['apelido'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 duplica-pagamento">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Forma
                                                            Pagamento</label>
                                                        <select class="form-select select2 select-forma-pagamento">
                                                            <option value="" selected disabled>Selecione</option>
                                                            <?php foreach ($formasTransacao as $formaTransacao) { ?>
                                                                <option value="<?= $formaTransacao['id'] ?>">
                                                                    <?= $formaTransacao['nome'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 duplica-pagamento">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                        <input
                                                            class="form-control input-valor-recebido mascara-dinheiro"
                                                            required name="valor" type="text" placeholder="Valor">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 mt-5">
                                                    <button title="Mais formas de pagamento" type="button"
                                                        class="btn btn-phoenix-secondary bg-white hover-bg-100"
                                                        onclick="duplicarFormasPagamento()">+</button>
                                                </div>
                                            </div>
                                            <div class="campos-duplicados row">
                                                <!-- JS -->
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                    <textarea class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p style="padding-left: 1rem;">Total:
                    <span class="valor-total-conta fw-bold">
                        <!-- JS -->
                    </span>
                </p>

                <div class="modal-footer">
                    <input type="hidden" class="id-conta-pagamento">
                    <input type="hidden" class="id-dado-financeiro">
                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button class="btn btn-primary btn-form" type="button" onclick="receberConta()">Pagar Conta</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>