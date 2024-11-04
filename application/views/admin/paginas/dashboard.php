<div class="content">
    <div class="pb-5">
        <div class="row g-4">

            <div class="row">
                <div class="mb-2 d-flex justify-content-between align-items-center flex-column flex-md-row text-center text-md-start">
                    <div class="mt-4">
                        <h2 class="mb-0">
                            Dashboard - <span class="dashboard-atual">Coletas</span>
                        </h2>
                        <small class="mb-0">Usuário - <?= $this->session->userdata('nome_usuario') ?></small>
                        </label>
                    </div>
                    <div class="mt-3">
                        <a href="#" title="Dashboard Coletas" class="btn icon-button mx-2 btn-troca-dashboard" data-nome-dashboard="Coletas">
                            <i class="fas fa-truck"></i> 
                        </a>
                        <a href="#" title="Dashboard Financeira" class="btn icon-button mx-2 btn-troca-dashboard" data-nome-dashboard="Financeira">
                            <i class="fas fa-dollar-sign"></i> 
                        </a>
                        <a href="#" title="Dashboard Estoque" class="btn icon-button mx-2 btn-troca-dashboard" data-nome-dashboard="Estoque">
                            <i class="fas fa-warehouse"></i> 
                        </a>
                    </div>
                </div>

                <!-- Botões -->


                <div class="col-12 col-md-6 col-xxl-6">

                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Status Agendamentos (Últimos 30 dias)</h4>
                            <hr>
                            <div class="row align-items-center g-3 text-center">
                                <div class="col-12 col-md-4 d-flex justify-content-center">
                                    <div class="d-flex align-items-center">
                                        <span class="fa-stack" style="min-height: 46px; min-width: 46px;">
                                            <a href="coletas.php" title="Ir para Coletas">
                                                <span class="fa-solid fa-square fa-stack-2x text-success-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                                <span class="fa-stack-1x fa-solid fa-check-circle text-success" data-fa-transform="shrink-2 up-8 right-6"></span>
                                            </a>
                                        </span>
                                        <div class="ms-2">
                                            <h4 class="mb-0">
                                                <a href="coletas.php" class="text-status-cabecalho text-decoration-none text-success hover-dark-coletas" title="Ir para Coletas">Coletados</a>
                                            </h4>
                                            <h5 class="mb-0 text-success text-status-cabecalho">0</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 d-flex justify-content-center">
                                    <div class="d-flex align-items-center">
                                        <span class="fa-stack" style="min-height: 46px; min-width: 46px;">
                                            <a href="agendamentos.php" title="Ir para agendamentos realizados">
                                                <span class="fa-solid fa-square fa-stack-2x text-info-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-info-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                                <span class="fa-stack-1x fa-solid fa-calendar-check text-info" data-fa-transform="shrink-2 up-8 right-6"></span>
                                            </a>
                                        </span>
                                        <div class="ms-2">
                                            <h4 class="mb-0">
                                                <a href="agendamentos.php" class="text-status-cabecalho text-decoration-none text-info hover-dark-agendamentos" title="Ir para agendamentos realizados">Realizados</a>
                                            </h4>
                                            <h5 class="mb-0 text-info text-status-cabecalho">0</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 d-flex justify-content-center">
                                    <div class="d-flex align-items-center">
                                        <span class="fa-stack icon-agendamentos-atrasados" style="min-height: 46px; min-width: 46px;">
                                            <a href="agendamentos_atrasados.php" title="Ir para agendamentos atrasados">
                                                <span class="fa-solid fa-square fa-stack-2x text-danger-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                                <span class="fa-stack-1x fa-solid fa-clock text-danger" data-fa-transform="shrink-2 up-8 right-6"></span>
                                            </a>
                                        </span>
                                        <div class="">
                                            <h4 class="mb-0 ms-2">
                                                <a href="agendamentos_atrasados.php" class="text-status-cabecalho text-decoration-none text-danger hover-dark-agendamentos-atrasados" title="Ir para agendamentos atrasados">Atrasados</a>
                                            </h4>
                                            <h5 class="mb-0 text-danger text-status-cabecalho"><?=$agendamentosAtrasados?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <hr class="bg-200 mb-6 mt-4" />

                    <div class="row flex-between-center mb-4 g-3">
                        <div class="col-auto">
                            <h3>Total sales</h3>
                            <p class="text-700 lh-sm mb-0">Payment received across all channels</p>
                        </div>
                        <div class="col-8 col-sm-4">
                            <select class="form-select form-select-sm mt-2" id="select-gross-revenue-month">
                                <option>Mar 1 - 31, 2022</option>
                                <option>April 1 - 30, 2022</option>
                                <option>May 1 - 31, 2022</option>
                            </select>
                        </div>
                    </div>
                    <div class="echart-total-sales-chart" style="min-height:320px;width:100%"></div>
                </div>
                <div class="col-12 col-md-6 col-xxl-6">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-1">Total orders<span class="badge badge-phoenix badge-phoenix-warning rounded-pill fs--1 ms-2"><span class="badge-label">-6.8%</span></span></h5>
                                            <h6 class="text-700">Last 7 days</h6>
                                        </div>
                                        <h4>16,247</h4>
                                    </div>
                                    <div class="d-flex justify-content-center px-4 py-6">
                                        <div class="echart-total-orders" style="height:85px;width:115px"></div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bullet-item bg-primary me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Completed</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">52%</h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bullet-item bg-primary-100 me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Pending payment</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">48%</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-1">New customers<span class="badge badge-phoenix badge-phoenix-warning rounded-pill fs--1 ms-2"> <span class="badge-label">+26.5%</span></span></h5>
                                            <h6 class="text-700">Last 7 days</h6>
                                        </div>
                                        <h4>356</h4>
                                    </div>
                                    <div class="pb-0 pt-4">
                                        <div class="echarts-new-customers" style="height:180px;width:100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-2">Top coupons</h5>
                                            <h6 class="text-700">Last 7 days</h6>
                                        </div>
                                    </div>
                                    <div class="pb-4 pt-3">
                                        <div class="echart-top-coupons" style="height:115px;width:100%;"></div>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bullet-item bg-primary me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Percentage discount</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">72%</h6>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bullet-item bg-primary-200 me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Fixed card discount</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">18%</h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bullet-item bg-info-500 me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Fixed product discount</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">10%</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-2">Paying vs non paying</h5>
                                            <h6 class="text-700">Last 7 days</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center pt-3 flex-1">
                                        <div class="echarts-paying-customer-chart" style="height:100%;width:100%;"></div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bullet-item bg-primary me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Paying customer</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">30%</h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bullet-item bg-primary-100 me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Non-paying customer</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">70%</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>