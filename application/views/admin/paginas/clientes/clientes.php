<div class="content">

    <div class="pb-8">
        <div id="reports" data-list="{&quot;valueNames&quot;:[&quot;title&quot;,&quot;text&quot;,&quot;priority&quot;,&quot;reportsby&quot;,&quot;reports&quot;,&quot;date&quot;],&quot;page&quot;:10,&quot;pagination&quot;:true}">
            <div class="row g-3 justify-content-between mb-2">
                <div class="col-12">
                    <div class="d-md-flex justify-content-between">

                        <div class="mb-3">
                            <a href="<?= base_url('clientes/formulario') ?>" class="btn btn-primary me-4">
                                <span class="fas fa-plus me-2"></span> Adicionar Cliente
                            </a>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="search-box me-2">
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input class="form-control search-input search" type="search" placeholder="Buscar Clientes" aria-label="Search">
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>

                            <button class="btn px-3 btn-phoenix-secondary" type="button" data-bs-toggle="modal" data-bs-target="#reportsFilterModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                <span class="fa-solid fa-filter text-primary" data-fa-transform="down-3"></span>
                            </button>

                            <div class="modal fade" id="reportsFilterModal" tabindex="-1" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border">
                                        <form id="addEventForm" autocomplete="off">
                                            <div class="modal-header border-200 p-4">
                                                <h5 class="modal-title text-1000 fs-2 lh-sm">Filter</h5>
                                                <button class="btn p-1 text-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                    <span class="fas fa-times fs--1"></span>
                                                </button>
                                            </div>
                                            <div class="modal-body pt-4 pb-2 px-4">
                                                <div class="mb-3"><label class="fw-bold mb-2 text-1000" for="priority">Priority</label><select class="form-select" id="priority">
                                                        <option value="urgent" selected="selected">Urgent</option>
                                                        <option value="medium">Medium </option>
                                                        <option value="high">High</option>
                                                        <option value="low">Low</option>
                                                    </select></div>
                                                <div class="mb-3"><label class="fw-bold mb-2 text-1000" for="createDate">Create Date</label><select class="form-select" id="createDate">
                                                        <option value="today" selected="selected">Today</option>
                                                        <option value="last7Days">Last 7 Days</option>
                                                        <option value="last30Days">Last 30 Days</option>
                                                        <option value="chooseATimePeriod">Choose a time period</option>
                                                    </select></div>
                                                <div class="mb-3"><label class="fw-bold mb-2 text-1000" for="category">Category</label><select class="form-select" id="category">
                                                        <option value="salesReports" selected="selected">Sales Reports</option>
                                                        <option value="hrReports">HR Reports</option>
                                                        <option value="marketingReports">Marketing Reports</option>
                                                        <option value="administrativeReports">Administrative Reports</option>
                                                    </select></div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-end align-items-center px-4 pb-4 border-0 pt-3">
                                                <button class="btn btn-sm btn-phoenix-primary px-4 fs--2 my-0" type="submit">
                                                    <span class="fas fa-arrows-rotate me-2 fs--2"></span> Reset
                                                </button>
                                                <button class="btn btn-sm btn-primary px-9 fs--2 my-0" type="submit">Done</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 list" id="reportsList">

                <div class="col-4 col-xl-4">
                    <div class="card h-100">

                        <div class="card-body">
                            <div class="border-bottom">

                                <div class="d-flex align-items-start mb-1 mt-3">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                    <div class="d-sm-flex align-items-center ps-2">
                                        <a class="fw-bold fs-1 lh-sm title line-clamp-1 me-sm-4 " href="#">Carrefour Prudente</a>
                                    </div>
                                </div>

                                <p class="fs--1 fw-semi-bold text-900 ms-4 text mb-4 ps-2 w-50">Av. Manoel Goulart, 400 Vila Santa Helena - Presidene Prudente / SP </p>

                                <div class="d-flex align-items-center" style="position: absolute; top: 5px; right: 10px">

                                    <div class="col-12 col-sm-auto flex-1 text-truncate">
                                        <div class="font-sans-serif btn-reveal-trigger position-static">
                                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                <span class="fas fa-ellipsis-h fs--2"></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end py-2">

                                                <a class="dropdown-item text-center" href="#!">
                                                    <span class="text-900 uil uil-eye"></span>
                                                    <span class="text-900"> Visualizar</span>
                                                </a>

                                                <div class="dropdown-divider"></div>

                                                <a class="dropdown-item text-danger text-center" href="<?= base_url('clientes/formulario/') ?>">
                                                    <span class="text-900 uil uil-pen"></span>
                                                    <span class="text-900"> Editar</span>
                                                </a>

                                                <div class="dropdown-divider"></div>

                                                <a class="dropdown-item text-danger text-center" href="#!">
                                                    <span class="text-900 uil uil-trash"></span>
                                                    <span class="text-900"> Excluir</span>
                                                </a>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="d-flex align-items-center" style="position: absolute; top: 10px; left: 10px">
                                    <span class="fw-bold fs--1 text-light lh-2 mr-5 badge rounded-pill bg-success">Ativo</span>
                                </div>

                            </div>

                            <div class="row g-1 g-sm-3 mt-2 lh-1">

                                <div class="col-12 col-sm-auto flex-1 text-truncate">
                                    <span class="far fa-clock text-success me-1"></span>
                                </div>

                                <div class="col-12 col-sm-auto">
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 fs--1 fw-semi-bold text-700 reports">
                                            <i class="fas fa-barcode"></i> RPN
                                        </p>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-auto">
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 fs--1 fw-semi-bold text-700 date">
                                            <i class="fas fa-phone-square"></i> (14) 99164-3110
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-4 col-xl-4">
                    <div class="card h-100">

                        <div class="card-body">
                            <div class="border-bottom">

                                <div class="d-flex align-items-start mb-1 mt-3">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                    <div class="d-sm-flex align-items-center ps-2">
                                        <a class="fw-bold fs-1 lh-sm title line-clamp-1 me-sm-4 " href="#">Carrefour Prudente</a>
                                    </div>
                                </div>

                                <p class="fs--1 fw-semi-bold text-900 ms-4 text mb-4 ps-2 w-50">Av. Manoel Goulart, 400 Vila Santa Helena - Presidene Prudente / SP </p>

                                <div class="d-flex align-items-center" style="position: absolute; top: 5px; right: 10px">

                                    <div class="col-12 col-sm-auto flex-1 text-truncate">
                                        <div class="font-sans-serif btn-reveal-trigger position-static">
                                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                <span class="fas fa-ellipsis-h fs--2"></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end py-2">

                                                <a class="dropdown-item text-center" href="#!">
                                                    <span class="text-900 uil uil-eye"></span>
                                                    <span class="text-900"> Visualizar</span>
                                                </a>

                                                <div class="dropdown-divider"></div>

                                                <a class="dropdown-item text-danger text-center" href="#!">
                                                    <span class="text-900 uil uil-pen"></span>
                                                    <span class="text-900"> Editar</span>
                                                </a>

                                                <div class="dropdown-divider"></div>

                                                <a class="dropdown-item text-danger text-center" href="#!">
                                                    <span class="text-900 uil uil-trash"></span>
                                                    <span class="text-900"> Excluir</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="d-flex align-items-center" style="position: absolute; top: 10px; left: 10px">
                                    <span class="fw-bold fs--1 text-light lh-2 mr-5 badge rounded-pill bg-danger">Inativo</span>
                                </div>

                            </div>

                            <div class="row g-1 g-sm-3 mt-2 lh-1">

                                <div class="col-12 col-sm-auto flex-1 text-truncate">
                                    <span class="far fa-clock text-success me-1"></span>
                                </div>

                                <div class="col-12 col-sm-auto">
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 fs--1 fw-semi-bold text-700 reports">
                                            <i class="fas fa-barcode"></i> RPN
                                        </p>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-auto">
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 fs--1 fw-semi-bold text-700 date">
                                            <i class="fas fa-phone-square"></i> (14) 99164-3110
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="row align-items-center justify-content-between py-2 pe-0 fs--1 mt-2">

                <div class="col-auto d-flex float-right">

                    <button class="page-link disabled" data-list-pagination="prev" disabled="">
                        <span class="fas fa-chevron-left"></span>
                    </button>

                    <ul class="mb-0 pagination">
                        <li class="active">
                            <button class="page" type="button" data-i="1" data-page="10">1</button>
                        </li>
                        <li>
                            <button class="page" type="button" data-i="2" data-page="10">2</button>
                        </li>
                    </ul>

                    <button class="page-link pe-0" data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>

                </div>

            </div>
        </div>
    </div>