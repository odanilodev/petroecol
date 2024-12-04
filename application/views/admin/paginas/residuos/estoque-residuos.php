<div class="content">
    <div id="members">

        <a href="#" class="btn btn-phoenix-primary mb-3 btn-nova-venda" data-bs-toggle="modal" data-bs-target="#modalNovaVenda">
            <span class="fas fa-dollar-sign"></span>
            Nova Venda</a>

        <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">

            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <h3>Estoque de Resíduos</h3>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="row g-2 gy-3">

                        <div class="col-auto flex-1">
                            <div class="search-box">
                                <form action="<?= base_url('estoqueResiduos') ?>" method="POST" class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input name="residuos" value="<?= $cookie_filtro_estoque_residuos['residuos'] ?? null ?>" class="form-control search-input search" type="search" placeholder="Buscar Resíduos" aria-label="Search">
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>
                        </div>

                        <div class="col-auto d-none">

                            <button class="btn btn-sm btn-phoenix-secondary bg-white hover-bg-100 action-btn btn-novo-lancamento"
                                type="button" data-bs-toggle="modal" data-bs-target="#modalLancamentoEstoque" onclick="carregaSelect2('select2', 'modalLancamentoEstoque')">Novo Lançamento</button>

                        </div>

                    </div>
                </div>
            </div>
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table id="table-fluxo" class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr class="text-center">
                            <th class="sort align-middle text-center" scope="col" data-sort="td_recebido">Resíduo</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_transacao">Quantidade</th>
                            <th class="sort ps-5 align-middle text-center" scope="col" data-sort="td_setor">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">

                        <?php foreach ($estoqueResiduos as $estoqueResiduo) { ?>

                            <tr class="hover-actions-trigger btn-reveal-trigger position-static text-center">

                                <td class="align-middle text-center data white-space-nowrap td_data">
                                    <h6 class="mb-0 text-900 text-center">
                                        <?= $estoqueResiduo['residuo'];?>
                                    </h6>
                                </td>

                                <td class="align-middle text-center td_recebido">
                                    <h6 class="mb-0 text-900">

                                        <!-- formata com 3 casas decimais caso não seja numero inteiro -->
                                        <?= floor($estoqueResiduo['quantidade']) == $estoqueResiduo['quantidade']
                                            ? $estoqueResiduo['quantidade'] . ' ' . strtoupper($estoqueResiduo['unidade_medida'])
                                            : number_format($estoqueResiduo['quantidade'], 3, ',', '') . ' ' . strtoupper($estoqueResiduo['unidade_medida']);
                                        ?>

                                    </h6>
                                </td>

                                <td class="align-middle white-space-nowrap text-center pe-0">

                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                                class="fas fa-ellipsis-h fs--2"></span></button>
                                        <div class="dropdown-menu dropdown-menu-start py-2">
                                            <a class="dropdown-item" href="<?= base_url('estoqueResiduos/detalhes/' . $estoqueResiduo['idResiduo']) ?>">
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

            <!-- Links de Paginação usando classes Bootstrap -->
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation" style="display: flex; float: right">
                        <ul class="pagination mt-5">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal novo Lançamento no Estoque -->
    <div class="modal fade" tabindex="-1" id="modalLancamentoEstoque">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
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
                                                    <select class="form-select input-obrigatorio select-tipo-movimentacao">
                                                        <option selected disabled>Selecione</option>
                                                        <option value="1">Entrada</option>
                                                        <option value="0">Saída</option>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Resíduo</label>
                                                    <select class="form-select input-obrigatorio select-residuo select2" name="residuo">
                                                        <option selected disabled>Selecione</option>
                                                        <?php foreach ($residuos as $residuo) { ?>
                                                            <option value="<?= $residuo['id'] ?>"><?= $residuo['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Quantidade</label>
                                                    <input class="form-control input-quantidade input-obrigatorio" required name="valor" type="text" placeholder="Quantidade">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

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

                    <div class="spinner-border text-primary load-form-modal d-none" role="status"></div>
                    <button class="btn btn-success btn-form-modal" type="button" onclick="inserirLancamentoEstoqueResiduos()">Salvar</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal nova venda -->
    <div class="modal fade" tabindex="-1" id="modalNovaVenda">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nova venda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Cliente</label>
                                                    <select class="form-select input-obrigatorio-venda select2 select-cliente">
                                                        <option selected disabled>Selecione</option>
                                                        <?php foreach ($clientes_finais as $cliente_final) { ?>
                                                            <option value="<?= $cliente_final['id'] ?>"><?= $cliente_final['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Resíduo</label>
                                                    <select class="form-select input-obrigatorio-venda select-residuo-venda select2" name="residuo">
                                                        <option selected disabled>Selecione</option>

                                                        <?php foreach ($residuos as $residuo) { ?>
                                                            <option value="<?= $residuo['id'] ?>"><?= $residuo['nome'] ?></option>
                                                        <?php } ?>

                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Unidade de Medida</label>
                                                    <select class="form-select input-obrigatorio-venda select-unidade-medida select2" name="residuo">
                                                        <option selected disabled>Selecione</option>
                                                        <?php foreach ($unidades_medidas as $unidade_medida) { ?>
                                                            <option value="<?= $unidade_medida['id'] ?>"><?= $unidade_medida['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Quantidade</label>
                                                    <input class="form-control input-quantidade-venda input-obrigatorio-venda" required name="valor" type="number" placeholder="Quantidade">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Valor total da destinação</label>
                                                    <input class="form-control mascara-dinheiro input-obrigatorio-venda input-valor-total" required name="valor" type="text" placeholder="Valor total da destinação">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data da Destinação</label>
                                                    <input autocomplete="off" class="form-control datetimepicker input-data-destinacao input-obrigatorio-venda" required name="data_destinacao" type="text" placeholder="Data da Destinação"
                                                        data-options='{"disableMobile":true,"allowInput":true,"dateFormat":"d/m/Y"}' style="cursor: pointer;" />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

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
                    <button class="btn btn-success btn-form" type="button" onclick="salvarNovaVenda()">Salvar</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>