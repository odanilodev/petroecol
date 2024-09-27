<div class="content">
    <div class="pb-2">
        <div class="row g-4">
            <div class="col-12 col-xxl-12">
                <div class="row align-items-center g-4">
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px; min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-danger-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-calendar-alt text-danger" data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>

                            <div class="ms-3">
                                <h4 class="mb-0"><span class="total-clientes-atrasados"><?= count(aprovacaoInativacao(false)); ?></span></h4>
                                <span class="text-800 fs--1 mb-0">Clientes sem atividades</span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="bg-200 mb-4 mt-3" />
            </div>
            <form id="filtroForm" action="<?= base_url('clientesSemAtividade/index') ?>" method="post">
                <div class="col-12">
                    <div class="row align-items-center g-4">

                        <div class="col-12 col-md-4">
                            <div class="ms-3">
                                <select class="select-validation select2" required name="cidade" id="cidade">
                                    <option selected disabled value=''>Cidade</option>
                                    <option <?= $cookie_filtro_clientes_sem_atividade['cidade'] == 'all' ? 'selected' : '' ?> value="all">Todos</option>


                                    <?php foreach ($cidades as $cidade) { ?>
                                        <option <?= $cookie_filtro_clientes_sem_atividade['cidade'] == $cidade['cidade'] ? "selected" : "" ?> value="<?= $cidade['cidade'] ?>"><?= $cidade['cidade'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="ms-3">
                                <select class="select-validation select2" required name="setor-empresa" id="setor-empresa">
                                    <option selected disabled value=''>Setor da Empresa</option>
                                    <option <?= $cookie_filtro_clientes_sem_atividade['setor-empresa'] == 'all' ? 'selected' : '' ?> value="all">Todos</option>

                                    <?php foreach ($setoresEmpresa as $setorEmpresa) { ?>
                                        <option <?= $cookie_filtro_clientes_sem_atividade['setor-empresa'] == $setorEmpresa['id'] ? "selected" : "" ?> value="<?= $setorEmpresa['id'] ?>"><?= $setorEmpresa['nome'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-4" style="padding:0;">
                            <div class="d-flex ms-3">
                                <button type="submit"
                                    class="btn btn-phoenix-secondary bg-white hover-bg-100 me-2 <?= !$cookie_filtro_clientes_sem_atividade['cidade'] ? 'w-100' : 'w-75'; ?>">Filtrar</button>

                                <?php if ($cookie_filtro_clientes_sem_atividade['cidade']) { ?>

                                    <a href="<?= base_url('clientesSemAtividade/index'); ?>" class="btn btn-phoenix-danger"
                                        title="Limpar Filtro"><i class="fas fa-ban"></i></a>
                                <?php } ?>
                            </div>
                        </div>


                    </div>
                    <hr class="bg-200 mb-6 mt-4" />
                </div>
            </form>

        </div>
    </div>

    <div class="mx-n4 px-4 px-lg-6 bg-white pt-5 border-y border-300 mb-5">
        <div id="members">
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <div class="d-flex align-items-center">
                        <h3 class="me-3">Clientes sem atividades</h3>
                        <button class="d-none btn btn-phoenix-info btn-gerar-romaneio-cliente" onclick="" data-bs-toggle="modal" data-bs-target="#modalRomaneiosAtrasados">
                            <i class="fas fa-clipboard-list me-2"></i>Gerar Romaneio
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="row g-2 gy-3">
                        <div class="col-auto flex-1">
                            <div class="search-box">
                                <form action="<?= base_url('clientesSemAtividade') ?>" method="POST" class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input name="nome" value="<?= $cookie_filtro_clientes_sem_atividade['nome'] ?? null ?>" class="form-control search-input search" type="search" placeholder="Buscar Clientes" aria-label="Search">
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table class="table fs--1 mb-0 border-top border-200">
                    <tr>
                        <thead>
                            <th class="white-space-nowrap fs--1 ps-0 align-middle">
                                <div class="form-check mb-0 fs-0">
                                    <input class="form-check-input check-all-element-agendamentos cursor-pointer" id="checkbox-bulk-reviews-select" type="checkbox" />
                                </div>
                            </th>
                            <th class="align-middle text-center" scope="col" data-sort="td_nome_cliente">Cliente</th>
                            <th class="align-middle text-center" scope="col" data-sort="td_setor">Setor</th>
                            <th class="align-middle text-center" scope="col" data-sort="td_cidade">Cidade</th>
                            <th class="align-middle text-center" scope="col" data-sort="td_telefone">Telefone</th>
                            <th class="align-middle text-center" scope="col" data-sort="td_ultima_coleta">Última coleta</th>
                            <th class="text-end pe-0 align-middle text-center" scope="col"></th>
                        </thead>
                    </tr>
                    <tbody class="list" id="table-latest-review-body">
                        <?php foreach ($clientes as $cliente) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static tr-pagamento">
                                <td class="fs--1 align-middle ps-0">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input check-element-agendamentos cursor-pointer" data-id-cliente="<?= $cliente['id'] ?>" type="checkbox" value="<?= $cliente['id'] ?>|" />

                                    </div>
                                </td>
                                <td class="align-middle td_nome_cliente text-center">
                                    <h6 class="mb-0 text-900"><?= $cliente['nome'] ?></h6>
                                </td>
                                <td class="align-middle td_setor text-center">
                                    <h6 class="mb-0 text-900"><?= $cliente['SETOR_EMPRESA'] ?></h6>
                                </td>
                                <td class="align-middle td_cidade text-center">
                                    <h6 class="mb-0 text-900"><?= mb_convert_case($cliente['cidade'], MB_CASE_TITLE, "UTF-8") ?></h6>
                                </td>
                                <td class="align-middle td_observacao text-center">
                                    <h6 class="mb-0 text-900"><?= $cliente['telefone'] ?></h6>
                                </td>

                                <td class="align-middle td_observacao text-center">
                                    <h6 class="mb-0 text-900"><?= $cliente['ULTIMA_COLETA'] ?? "<i>Nunca coletado</i>" ?></h6>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


            <!-- Links de Paginação usando classes Bootstrap -->
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation" style="display: flex; float: right">
                        <ul class="pagination mt-5">
                            <?= $this->pagination->create_links(); ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal gerar romaneio de atrasados -->
    <div class="modal fade" id="modalRomaneiosAtrasados" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gerar um Romaneio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body row form-agendamento-atrasado">

                    <div class="col-12 mt-2 mb-2">
                        <select class="form-select w-100 input-obrigatorio select2" id="select-setor">
                            <option selected disabled value="">Selecione o setor</option>
                            <?php
                            foreach ($setoresEmpresa as $v) { ?>
                                <option value="<?= $v['id'] ?>"> <?= $v['nome'] ?></option>
                            <?php }  ?>
                        </select>
                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                    </div>

                    <div class="col-md-12 mt-2 mb-2">
                        <input class="form-control datetimepicker input-obrigatorio input-data-agendamento" required name="data_agendamento" type="text" placeholder="Data Romaneio" data-options='{"disableMobile":true,"allowInput":true,"dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                    </div>

                    <div class="col-12 mt-2 mb-2">
                        <select class="form-select w-100 input-obrigatorio select2" id="select-responsavel">
                            <option selected disabled value="">Selecione o responsável</option>
                            <?php
                            foreach ($responsaveis as $v) { ?>
                                <option value="<?= $v['IDFUNCIONARIO'] ?>"> <?= $v['nome'] ?> | <?= $v['CARGO'] ?></option>
                            <?php }  ?>
                        </select>
                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                    </div>

                    <div class="col-12 mt-2 mb-2">
                        <select class="form-select w-100 input-obrigatorio select2" id="select-veiculo">
                            <option selected disabled value="">Selecione o veículo</option>
                            <?php
                            foreach ($veiculos as $veiculo) { ?>
                                <option value="<?= $veiculo['id'] ?>"> <?= $veiculo['modelo'] ?> | <?= strtoupper($veiculo['placa']) ?></option>
                            <?php }  ?>
                        </select>
                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="spinner-border text-primary load-form d-none load-form-modal-romaneio" role="status"></div>
                    <button type="button" class="btn btn-primary btn-salva-romaneio btn-form" onclick="gerarRomaneioClientesSemAtividades()">Gerar Romaneio</button>
                </div>

            </div>
        </div>
    </div>