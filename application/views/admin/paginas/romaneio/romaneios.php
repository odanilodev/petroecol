<div class="content">
    <div id="members" data-list='{"valueNames":["customer","email","mobile_number","city","last_active","joined"],"page":10,"pagination":true}'>

        <div class="row align-items-center justify-content-between g-3 mb-4">

            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-900 me-4 px-0 d-none"><span class="fa-solid fa-file-export fs--1 me-2"></span>Export</button>
                    <a href="<?= base_url("romaneios/formulario") ?>" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Novo Romaneio</a>
                </div>
            </div>

            <div class="col col-auto">
                <div class="search-box">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                        <input class="form-control search-input search" type="search" placeholder="Buscar Romaneios" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>

                    </form>
                </div>
            </div>
        </div>

        <?php if (!empty($ultimosRomaneios)) { ?>

            <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">


                <div class="accordion" id="accordionExample">

                    <input type="hidden" class="id-setor-empresa" value="<?= $ultimosRomaneios[0]['id_setor_empresa'] ?>">

                    <?php foreach ($ultimosRomaneios as $romaneio) { ?>


                        <div class="accordion-item border-top">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed btn-accordion-<?= $romaneio['ID_ROMANEIO'] ?>" type="button" data-bs-toggle="collapse" data-bs-target="#romaneio-<?= $romaneio['ID_ROMANEIO'] ?>" aria-expanded="true" aria-controls="romaneio-<?= $romaneio['ID_ROMANEIO'] ?>" onclick="buscarRomaneioPorData('<?= $romaneio['data_romaneio'] ?>', '<?= $romaneio['ID_ROMANEIO'] ?>')">
                                    <?= date('d/m/Y', strtotime($romaneio['data_romaneio'])); ?>
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="romaneio-<?= $romaneio['ID_ROMANEIO'] ?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body pt-0">

                                    <div class="spinner-border text-primary load-form load-<?= $romaneio['ID_ROMANEIO'] ?> ml-3 d-none" role="status" style="height: 15px; width: 15px; margin-left: 20px"></div>


                                    <div class="table-responsive scrollbar ms-n1 ps-1">

                                        <table class="table table-lg mb-0 text-center">
                                            <thead class="head-romaneio">
                                                <tr>

                                                    <th class="sort align-middle">Código</th>
                                                    <th class="sort align-middle">Responsável</th>
                                                    <th class="sort align-middle">Gerado em</th>
                                                    <th class="sort align-middle">Status</th>
                                                    <th class="sort align-middle p-3">Ação</th>
                                                    <th class="sort align-middle p-3"></th>
                                                </tr>
                                            </thead>

                                            <tbody class="list accortion-<?= $romaneio['ID_ROMANEIO'] ?>" id="members-table-body">

                                                <!-- JS -->
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                </div>

            </div>

        <?php } ?>
    </div>

    <!-- Modal Romaneio-->
    <div class="modal fade" id="modalConcluirRomaneio" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollabe">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">



                        <div class="accordion dados-clientes-div" id="accordionConcluir">

                            <!-- Manipulado JS -->
                        </div>

                    </div>

                </div>


                <div class="modal-footer">
                    <div class="spinner-border text-primary load-form d-none load-form-modal-romaneio" role="status"></div>
                    <button type="button" class="btn btn-primary btn-finaliza-romaneio" onclick="finalizarRomaneio()">Finalizar Romaneio</button>
                    <input type="hidden" class="id_responsavel">
                    <input type="hidden" class="code_romaneio">
                    <input type="hidden" class="data_romaneio">
                    <input type="hidden" class="input-id-setor-empresa">

                </div>
            </div>
        </div>
    </div>

    <!-- edita romaneio-->
    <div class="modal fade" id="modalEditarRomaneio" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollabe">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Edita romaneio -->
                    <div class="col-4">

                        <button type="button" class="btn btn-secondary btn-adicionar-clientes-romaneio mb-5" onclick="novoClienteRomaneio()">+ Novo Cliente</button>
                    </div>

                    <div class="col-12 row div-select-cliente d-none">
                        <input type="hidden" class="nome-setor">

                        <div class="col-4">

                            <div class="mt-2 mb-4">
                                <select class="form-select w-50 mb-3 select2-edita add-novo-cliente-romaneio" id="select-cliente-modal">

                                    <option selected value="">Selecione o cliente</option>


                                </select>
                                <div class="d-none aviso-obrigatorio aviso-novo-cliente-romaneio">Preencha este campo</div>

                            </div>
                        </div>

                        <div class="col-2 mt-2 mb-4">
                            <button type="button" class="btn btn-secondary adicionar-cliente">Adicionar</button>
                        </div>

                    </div>


                    <div class="row">

                        <div class="accordion dados-clientes-div-editar" id="accordionExample">

                            <!-- Manipulado JS -->
                        </div>

                    </div>

                </div>


                <div class="modal-footer">
                    <div class="spinner-border text-primary load-form d-none load-form-modal-romaneio" role="status"></div>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Salvar</button>
                    <input type="hidden" class="id_responsavel">
                    <input type="hidden" class="code_romaneio">
                    <input type="hidden" class="data_romaneio">
                    <input type="hidden" class="input-id-setor-empresa">

                </div>
            </div>
        </div>
    </div>