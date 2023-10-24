<div class="content">

    <div class="pb-8">
        <div id="reports">
            <div class="row g-3 justify-content-between mb-2">
                <div class="col-12">
                    <div class="d-md-flex justify-content-between">

                        <div class="mb-3">
                            <a href="<?= base_url('clientes/formulario') ?>" class="btn btn-primary me-4">
                                <span class="fas fa-plus me-2"></span> Adicionar Cliente
                            </a>
                        </div>

                        <div class="d-flex mb-3">


                            <div class="flatpickr-input-container me-2">
                                <?php $date = date("M j, Y"); ?>
                                <input class="form-control ps-6 datetimepicker flatpickr-input active" id="datepicker" type="text" data-options="{&quot;dateFormat&quot;:&quot;M j, Y&quot;,&quot;disableMobile&quot;:true,&quot;defaultDate&quot;:&quot;<?= $date ?>&quot;}" readonly="readonly">
                                <span class="uil uil-calendar-alt flatpickr-icon text-700"></span>
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

                <div class="col-12 col-xs-12 col-xl-4 col-md-4">
                    <div class="card h-100">

                        <div class="card-body">
                            <div class="border-bottom">

                                <div class="d-flex align-items-start mb-1">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                    <div class="d-sm-flex align-items-center ps-2">
                                        <a title="" class="fw-bold fs-1 lh-sm title line-clamp-1 me-sm-4 " href="#">Cliente tal</a>
                                    </div>
                                </div>

                                <p class="fs--1 fw-semi-bold text-900 ms-4 text mb-4 ps-2 w-50">
                                    Rua General Marcondes Salgado, 1771 Vila Cardia - Bauru / SP
                                </p>

                                <div class="d-flex align-items-center" style="position: absolute; top: 5px; right: 10px">

                                    <div class="col-12 col-sm-auto flex-1 text-truncate">
                                        <div class="font-sans-serif btn-reveal-trigger position-static">
                                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                <span class="fas fa-ellipsis-h fs--2"></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end py-2">

                                                <a class="dropdown-item" href="#">
                                                    <span class="text-900 uil uil-eye"></span>
                                                    <span class="text-900"> Visualizar</span>
                                                </a>

                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalEtiqueta">
                                                    <span class="text-900 uil-pricetag-alt"></span>
                                                    <span class="text-900"> Etiquetas</span>
                                                </a>

                                                <a class="dropdown-item" href="#" onclick="exibirResiduoCliente()" data-bs-toggle="modal" data-bs-target="#modalResiduo">
                                                    <span class="text-900 uil-pricetag-alt"></span>
                                                    <span class="text-900"> Resíduos</span>
                                                </a>

                                                <a class="dropdown-item" href="#" onclick="exibirRecipientesCliente()" data-bs-toggle="modal" data-bs-target="#modalRecipiente">
                                                    <span class="text-900 uil-pricetag-alt"></span>
                                                    <span class="text-900"> Recipientes</span>
                                                </a>

                                                <a class="dropdown-item text-danger" href="<?= base_url('clientes/formulario/') ?>">
                                                    <span class="text-900 uil uil-pen"></span>
                                                    <span class="text-900"> Editar</span>
                                                </a>

                                                <a class="dropdown-item text-danger" href="#" onclick="deletaCliente()">
                                                    <span class="text-900 uil uil-trash"></span>
                                                    <span class="text-900"> Excluir</span>
                                                </a>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="row g-1 g-sm-3 mt-2 lh-1">

                                <div class="col-12 col-sm-auto flex-1 text-truncate">
                                    <span class="far fa-clock text-success me-1"></span> 20/10/23 manhã 
                                </div>

                                <div class="col-12 col-sm-auto">
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 fs--1 fw-semi-bold text-700 reports">
                                            <i class="fas fa-barcode"></i>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-auto">
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 fs--1 fw-semi-bold text-700 date">
                                            <i class="fas fa-phone-square"></i>
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>