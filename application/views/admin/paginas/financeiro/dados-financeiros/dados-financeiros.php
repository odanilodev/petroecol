<div class="content">
    <div id="members" data-list='{"valueNames":["nome"],"page":10,"pagination":true}'>
        <div class="row align-items-center justify-content-between g-3 mb-4">

            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-900 me-4 px-0 d-none"><span class="fa-solid fa-file-export fs--1 me-2"></span>Export</button>
                    <a href="<?= base_url("finDadosFinanceiros/formulario") ?>" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Cadastrar Dados Financeiros</a>
                    <a href="#" class="btn btn-danger d-none btn-excluir-tudo mx-2" onclick="deletaDadosFinanceiros()"><span class="fas fa-trash"></span> Excluir tudo</a>
                </div>

            </div>

            <div class="col col-auto">
                <div class="search-box">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                        <input class="form-control search-input search" type="search" placeholder="Buscar Dados Financeiros" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>

                    </form>
                </div>
            </div>
        </div>
        <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
            <div class="table-responsive scrollbar ms-n1 ps-1">
                <table class="table table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs--1 align-middle ps-0">
                                <!-- Check para todos -->
                                <div class="form-check mb-0 fs-0">
                                    <input class="form-check-input check-all-element cursor-pointer" type="checkbox" />
                                </div>
                            </th>

                            <th class="sort align-middle pe-3" scope="col" data-sort="nome">Nome</th>
                            <th class="sort align-middle pe-3">Visualizar</th>
                            <th class="sort align-middle pe-3">Editar</th>
                            <th class="sort align-middle pe-3">Excluir</th>
                        </tr>
                    </thead>

                    <tbody class="list" id="members-table-body">

                        <?php foreach ($dadosFinanceiros as $v) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                <!-- check para cada um -->
                                <td class="fs--1 align-middle ps-0 py-3">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input check-element cursor-pointer text-center" type="checkbox" value="<?= $v['id'] ?>" />
                                    </div>
                                </td>

                                <td class="nome align-middle white-space-nowrap">
                                    <?= $v['nome'] ?>
                                </td>

                                <td class="align-middle white-space-nowrap">
                                    <a href="#" class="btn btn-phoenix-warning" onclick="visualizarDadosFinanceiros(<?= $v['id'] ?>)" data-bs-toggle="modal" data-bs-target="#modalVisualizarDadosFinanceiros">
                                        <span class="fas fa-eye ms-1"></span>
                                    </a>
                                </td>

                                <td class="align-middle white-space-nowrap">
                                    <a href="<?= base_url('finDadosFinanceiros/formulario/' . $v['id']) ?>" class="btn btn-phoenix-info">
                                        <span class="fas fa-pencil ms-1"></span>
                                    </a>
                                </td>

                                <td class="align-middle white-space-nowrap">
                                    <a href="#" class="btn btn-phoenix-danger" onclick="deletaDadosFinanceiros(<?= $v['id'] ?>)">
                                        <span class="fas fa-trash ms-1"></span>
                                    </a>
                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
                <div class="col-auto d-none">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">Ver todos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">Ver menos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>

                <div class="col-auto d-flex w-100 justify-content-end">
                    <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal visualizar dados financeiros -->
    <div class="modal fade" tabindex="-1" id="modalVisualizarDadosFinanceiros">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Dados financeiros</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-dados-financeiros">
                    <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
                        <div class="card-header bg-100 pt-3 pb-2 border-bottom-0">
                            <ul class="nav justify-content-between nav-wizard" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-semi-bold active" href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1" aria-selected="true" role="tab">
                                        <div class="text-center d-inline-block">
                                            <span class="nav-item-circle-parent">
                                                <span class="nav-item-circle">
                                                    <span class="fas fa-money-check-alt"></span>
                                                </span>
                                            </span>
                                            <span class="d-none d-md-block mt-1 fs--1">Transação</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2" data-bs-toggle="tab" data-wizard-step="2" aria-selected="false" role="tab" tabindex="-1">
                                        <div class="text-center d-inline-block">
                                            <span class="nav-item-circle-parent">
                                                <span class="nav-item-circle">
                                                    <span class="fas fa-map-marked-alt"></span>
                                                </span>
                                            </span>
                                            <span class="d-none d-md-block mt-1 fs--1">Localização</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab4" data-bs-toggle="tab" data-wizard-step="4" aria-selected="false" tabindex="-1" role="tab">
                                        <div class="text-center d-inline-block">
                                            <span class="nav-item-circle-parent">
                                                <span class="nav-item-circle">
                                                    <span class="fas fa-user"></span>
                                                </span>
                                            </span>
                                            <span class="d-none d-md-block mt-1 fs--1">Intermédio</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body pt-4 pb-0">
                            <div class="tab-content">
                                <div class="tab-pane active show" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1">
                                    <!-- Transação Content -->
                                    <table class="w-100 table-stats">
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-id-card" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Nome</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break nome-transacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-users" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Grupo</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break grupo-transacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-id-card-alt" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">CNPJ</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break cnpj-transacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-building" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Razão Social</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break razao-social-transacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-phone" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Telefone</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break telefone-transacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-user-check" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Tipo de cadastro</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break tipo-cadastro-transacao html-clean"> -->
                                        <!-- JS -->
                                        <!-- </div>
                                            </td>
                                        </tr> -->
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-university" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Conta Bancária</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break conta-bancaria-transacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-envelope" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Email</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break email-transacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2">
                                    <!-- Localização Content -->
                                    <table class="w-100 table-stats">
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-map-marker-alt" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">CEP</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break cep-localizacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-road" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Rua</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break rua-localizacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-sort-numeric-up-alt" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Número</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break numero-localizacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-city" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Bairro</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break bairro-localizacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-building" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Cidade</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break cidade-localizacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-map" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Estado</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break estado-localizacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-comment-dots" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Complemento</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break complemento-localizacao html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3">
                                    Conteúdo Extra
                                </div>
                                <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4">
                                    <!-- Intermédio Content -->
                                    <table class="w-100 table-stats">
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-user" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Nome Intermédio</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break nome-intermedio html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-phone" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Telefone Intermédio</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break telefone-intermedio html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-envelope" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">Email Intermédio</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break email-intermedio html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 w-50">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                        <span class="text-info-600 dark__text-info-300 fas fa-id-card" style="width:16px; height:16px"></span>
                                                    </div>
                                                    <p class="fw-bold mb-0">CPF Intermédio</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2 w-50">
                                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break cpf-intermedio html-clean">
                                                    <!-- JS -->
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- <div class="card-footer border-top-0" data-wizard-footer="data-wizard-footer"> -->
                            <!-- <div class="d-flex pager wizard list-inline mb-0"> -->
                            <!-- <button class="btn btn-link ps-0 previous-btn" type="button">
                                        <svg class="svg-inline--fa fa-chevron-left me-1" data-fa-transform="shrink-3" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;">
                                            <g transform="translate(160 256)">
                                                <g transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                    <path fill="currentColor" d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z" transform="translate(-160 -256)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        Anterior
                                    </button> -->
                            <!-- <div class="flex-1 text-end"> -->
                            <!-- <button class="btn btn-primary px-6 px-sm-6 next-btn" type="button">
                                            Próximo
                                            <svg class="svg-inline--fa fa-chevron-right ms-1" data-fa-transform="shrink-3" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;">
                                                <g transform="translate(160 256)">
                                                    <g transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                        <path fill="currentColor" d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z" transform="translate(-160 -256)"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </button> -->
                            <!-- </div> -->
                            <!-- </div> -->
                            <!-- </div> -->
                        </div>
                        <div class="modal-footer border-top-0">
                            <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>