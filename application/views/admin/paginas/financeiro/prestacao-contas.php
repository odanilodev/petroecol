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
                            <th class="white-space-nowrap" scope="col" data-sort="td_romaneio">Romaneio</th>
                            <th class="white-space-nowrap" scope="col" data-sort="td_funcionario">Funcionario</th>
                            <th class="white-space-nowrap" scope="col" data-sort="td_valor">Valor</th>
                            <th class="text-end pe-0 align-middle" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">

                        <?php foreach ($prestacaoContas as $prestacaoConta) { ?>

                            <tr class="hover-actions-trigger btn-reveal-trigger position-static text-center">

                                <td class="align-middle text-center data white-space-nowrap td_funcionario">
                                    <h6 class="mb-0 text-900 text-center">
                                        <?= $prestacaoConta['codigo_romaneio']; ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-center data white-space-nowrap td_funcionario">
                                    <h6 class="mb-0 text-900 text-center">
                                        <?= $prestacaoConta['FUNCIONARIO']; ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-center data white-space-nowrap td_funcionario">
                                    <h6 class="mb-0 text-900 text-center">
                                        R$ <?= number_format($prestacaoConta['valor_total'], 2, ',', '.') ?>
                                    </h6>
                                </td>

                                <td class="align-middle white-space-nowrap text-end pe-0">
                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs--2"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a onclick="visualizarPrestacaoContas(<?= $prestacaoConta['codigo_romaneio']?>, <?= $prestacaoConta['valor_total']?>)" class="dropdown-item" href="#!" data-bs-toggle="modal" data-bs-target="#modalVisualizarPrestarConta">
                                                Ver Custos
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
    <div class="modal fade" tabindex="-1" id="modalVisualizarPrestarConta">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Custos do romaneio:
                        <span class="cod-romaneio">
                            <!-- JS -->
                        </span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    
                    
                    <div class="card">
                        <div class="card-body form-editar-pagar">
                            <div class="spinner-border text-primary load-form-modal d-none" role="status"></div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="mx-0 mx-sm-1 mx-lg-0 px-lg-0 div-tabela-tipos-custos-modal">
                                            <div class="table-responsive mx-n1 px-1 scrollbar">

                                                <table class="table fs--1 mb-0 border-top border-200">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th class="white-space-nowrap" scope="col" data-sort="td_romaneio">Tipo de custo</th>
                                                            <th class="white-space-nowrap" scope="col" data-sort="td_valor">Valor</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="tabela-tipos-custos-modal">
                                                        <!-- JS -->
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>


                </div>

                <div class="modal-footer ">

                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>