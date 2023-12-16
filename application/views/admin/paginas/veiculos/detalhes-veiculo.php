<div class="content">

    <div class="pb-9">
        <div class="row g-0 g-md-4 g-xl-6">
            <div class="col-md-5 col-lg-5 col-xl-4">
                <div class="sticky-leads-sidebar">
                    <div class="lead-details-offcanvas bg-soft scrollbar phoenix-offcanvas phoenix-offcanvas-fixed" id="productFilterColumn">
                        <div class="d-flex justify-content-between align-items-center mb-2 d-md-none">
                            <h3 class="mb-0">Lead Details</h3><button class="btn p-0" data-phoenix-dismiss="offcanvas"><span class="uil uil-times fs-1"></span></button>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center g-3 text-center text-xxl-start">
                                    <div class="col-12 col-xxl-auto">
                                        <div class="avatar avatar-5xl"><img class="rounded-circle" src="<?= $veiculo['fotocarro'] ? base_url_upload('veiculos/fotocarro/' . ($veiculo['fotocarro'])) : base_url('assets/img/icons/sem_foto.jpg') ?>" alt=""></div>
                                    </div>
                                    <div class="col-12 col-sm-auto flex-1">
                                        <h3 class="fw-bolder mb-2"><?= $veiculo['modelo'] ?></h3>
                                        <p class="mb-0">
                                            <?= empty($veiculo['placa']) ? 'Não Cadastrado' : $veiculo['placa'] ?>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-5">
                                    <h3>Sobre o carro</h3>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="me-2 uil uil-house-user"></span>

                                        <h5 class="text-1000 mb-0">Modelo</h5>
                                    </div>
                                    <p class="mb-0 text-800">
                                        <?= empty($veiculo['modelo']) ? 'Não Cadastrado' : $veiculo['modelo'] ?>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-hourglass">
                                        </span>
                                        <h5 class="text-1000 mb-0">Placa</h5>
                                    </div>
                                    <p class="mb-0 text-800">
                                        <?= empty($veiculo['placa']) ? 'Não Cadastrado' : $veiculo['placa'] ?>
                                    </p>
                                </div>


                            </div>
                        </div>

                    </div>
                    <div class="phoenix-offcanvas-backdrop d-lg-none top-0" data-phoenix-backdrop="data-phoenix-backdrop"></div>
                </div>
            </div>
            <div class="col-md-7 col-lg-7 col-xl-8">
                <div class="lead-details-container">

                    <div class="mb-8">
                        <div class="d-flex justify-content-between align-items-center mb-4" id="scrollspyDeals">
                            <h3>Documentos</h3>
                            <a href="<?= base_url('veiculos/formulario/' . $this->uri->segment(3)) ?>" class="btn btn-phoenix-secondary px-3 px-sm-5 me-2">
                                <span class="fa-solid fa-edit me-sm-2"></span>
                                <span class="d-none d-sm-inline">Editar </span>
                            </a>

                        </div>

                        <div class="border-top border-bottom border-200" id="leadDetailsTable">
                            <div class="table-responsive scrollbar mx-n1 px-1">
                                <table class="table fs--1 mb-0">
                                    <tbody class="list" id="lead-details-table-body">
                                        <?php if ($veiculo['documento']) { ?>
                                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                <td>
                                                    <h5>Documento</h5>
                                                </td>
                                                <td class="type align-middle fw-semi-bold py-2 text-end">
                                                    <a download href="<?= base_url_upload('veiculos/documento/') . $veiculo['documento'] ?>"><span class="me-5 uil uil-file-download h2"></span></a>
                                                    <a href="<?= base_url('veiculos/deletaDocumentos/'.$veiculo['id'].'/'.urlencode($veiculo['documento'])) ?>/documento" class="" title="Excluir documento"><span class="me-5 uil uil-ban h2 text-danger"></span></a>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                        <?php if ($veiculo['fotocarro']) { ?>

                                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                <td>
                                                    <h5>Foto Carro</h5>
                                                </td>
                                                <td class="type align-middle fw-semi-bold py-2 text-end">
                                                    <a download href="<?= base_url_upload('veiculos/fotocarro/') . $veiculo['fotocarro'] ?>"><span class="me-5 uil uil-file-download h2"></span></a>
                                                    <a href="<?= base_url('veiculos/deletaDocumentos/'.$veiculo['id'].'/'.urlencode($veiculo['fotocarro'])) ?>/fotocarro" class="" title="Excluir foto carro"><span class="me-5 uil uil-ban h2 text-danger"></span></a>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>