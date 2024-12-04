<div class="content">

    <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
        <div id="members">
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <h3>Movimentações de <?= $estoqueResiduo[0]['RESIDUO']; ?></h3>
                </div>

            </div>
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table id="table-fluxo" class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr class="text-center">
                            <th class="sort align-middle text-center" scope="col" data-sort="td_transacao">Quantidade</th>
                            <th class="sort ps-5 align-middle text-center" scope="col" data-sort="td_setor">Tipo de Movimentação</th>
                            <th class="sort ps-5 align-middle text-center" scope="col" data-sort="td_setor">Data de Movimentação</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">

                        <?php foreach ($estoqueResiduo as $estoque) { ?>

                            <tr class="hover-actions-trigger btn-reveal-trigger position-static text-center">

                                <td class="align-middle text-center td_recebido">
                                    <h6 class="mb-0 text-900">
                                        <!-- formata com 3 casas decimais caso não seja numero inteiro -->
                                        <?= floor($estoque['quantidade']) == $estoque['quantidade']
                                            ? $estoque['quantidade'] . ' ' . strtoupper($estoque['UNIDADE_MEDIDA'])
                                            : number_format($estoque['quantidade'], 3, ',', '') . ' ' . strtoupper($estoque['UNIDADE_MEDIDA']);
                                        ?>
                                    </h6>
                                </td>


                                <td class="align-middle text-center ps-3 td_tipo">
                                    <?php if ($estoque['tipo_movimentacao'] == 0): ?>
                                        <span class="badge badge-phoenix fs--2 badge-phoenix-warning">
                                            <span class="badge-label">Saída</span>
                                            <span class="ms-1" data-feather="trending-down"
                                                style="height:12.8px;width:12.8px;"></span>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-phoenix fs--2 badge-phoenix-success">
                                            <span class="badge-label">Entrada</span>
                                            <span class="ms-1" data-feather="trending-up"
                                                style="height:12.8px;width:12.8px;"></span>
                                        </span>
                                    <?php endif; ?>
                                </td>


                                <td class="align-middle text-center">
                                    <h6 class="mb-0 text-900 text-center">
                                        <?= date('d/m/Y H:i:s', strtotime($estoque['criado_em'])) ?>
                                    </h6>
                                </td>


                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div>

            <!-- Links de Paginação usando classes Bootstrap -->
            <!--  -->
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
                    <button class="btn btn-success btn-form-modal" type="button" onclick="salvarLancamentoEstoqueResiduos()">Salvar</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>