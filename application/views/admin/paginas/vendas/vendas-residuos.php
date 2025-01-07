<div class="content">

    <div id="members">
        <div class="row justify-content-between">
            <div class="col-auto">
                <a href="#" class="btn btn-phoenix-primary mb-3 btn-nova-venda" data-bs-toggle="modal" data-bs-target="#modalNovaVenda">
                    <span class="fas fa-dollar-sign"></span>
                    Nova Venda
                </a>
            </div>

            <div class="col-auto">
                <a href="#" class="btn btn-phoenix-primary mb-3 btn-nova-venda" data-bs-toggle="modal" data-bs-target="#modalConfiguracoesExibicoes">
                    <span class="uil-setting"></span>
                    Configurações de Exibições
                </a>
            </div>
        </div>
        <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <h3>Vendas de Resíduos</h3>
                </div>
            </div>
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table id="table-fluxo" class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr class="text-center">
                            <th class="sort ps-5 align-middle text-center" scope="col">Cliente</th>
                            <th class="sort align-middle text-center" scope="col">Resíduo</th>
                            <th class="sort ps-5 align-middle text-center" scope="col">Quantidade</th>
                            <th class="sort ps-5 align-middle text-center" scope="col">Valor total</th>
                            <th class="sort ps-5 align-middle text-center" scope="col">Data da Venda</th>
                            <th class="sort ps-5 align-middle text-center" scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">

                        <?php foreach ($vendasResiduos as $vendaResiduo) { ?>

                            <tr class="hover-actions-trigger btn-reveal-trigger position-static text-center">

                                <td class="align-middle text-center">
                                    <h6 class="mb-0 text-900">
                                        <?= $vendaResiduo['CLIENTE'] ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-center">
                                    <h6 class="mb-0 text-900 text-center">
                                        <?= $vendaResiduo['RESIDUO'] ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-center">
                                    <h6 class="mb-0 text-900">
                                        <!-- formata com 3 casas decimais caso não seja numero inteiro -->
                                        <?= floor($vendaResiduo['quantidade']) == $vendaResiduo['quantidade']
                                            ? $vendaResiduo['quantidade'] . ' ' . strtoupper($vendaResiduo['UNIDADE_MEDIDA'])
                                            : number_format($vendaResiduo['quantidade'], 3, ',', '') . ' ' . strtoupper($vendaResiduo['UNIDADE_MEDIDA']);
                                        ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-center">
                                    <h6 class="mb-0 text-900 text-center">
                                        R$ <?= number_format($vendaResiduo['valor_total'], 2, ',', '.'); ?>
                                    </h6>
                                </td>



                                <td class="align-middle text-center">
                                    <h6 class="mb-0 text-900">
                                        <?= date('d/m/Y', strtotime($vendaResiduo['data_venda'])) ?>
                                    </h6>
                                </td>

                                <td class="align-middle white-space-nowrap text-center pe-0">

                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                                class="fas fa-ellipsis-h fs--2"></span></button>
                                        <div class="dropdown-menu dropdown-menu-center py-2">
                                            <a class="dropdown-item" href="#" onclick="editarVenda(<?= $vendaResiduo['id'] ?>)" data-bs-toggle="modal" data-bs-target="#modalEditarVenda">
                                                <span class="fas fa-pencil"></span> Editar
                                            </a>

                                            <a class="dropdown-item" href="#" onclick="" data-bs-toggle="modal" data-bs-target="#modalEditarVenda">
                                                <span class="fas fa-trash"></span> Excluir
                                            </a>

                                        </div>
                                    </div>
                                </td>


                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation" style="display: flex; float: right">
                        <ul class="pagination-customizada mt-5">
                            <?= $this->pagination->create_links(); ?>
                        </ul>
                    </nav>
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
                                    <div class="col-sm-12 col-xxl-12">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-lg-6">

                                                <div class="mb-3">
                                                    <input id="check-agendar-recebimento" name="agendar_recebimento" class="form-check-input cursor-pointer" type="checkbox" />
                                                    <label class="text-body-highlight mb-2 cursor-pointer" for="check-agendar-recebimento">Agendar recebimento</label>
                                                </div>

                                            </div>


                                            <div class="col-lg-12">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Setor da Empresa</label>
                                                    <select class="form-select input-obrigatorio-venda select2 select-setor-empresa-venda">
                                                        <option selected disabled>Selecione</option>
                                                        <?php foreach ($setoresEmpresa as $setorEmpresa) { ?>
                                                            <option value="<?= $setorEmpresa['id'] ?>"><?= $setorEmpresa['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Grupos Macros</label>
                                                    <select class="form-select select2 select-macros input-obrigatorio-venda" name="macro">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($macros as $macro) { ?>
                                                            <option value="<?= $macro['id'] ?>"><?= $macro['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4 ">
                                                    <label class="text-body-highlight fw-bold mb-2 ">Grupos Micros</label>
                                                    <select disabled class="form-select select2 select-micros input-obrigatorio-venda" name="micro">
                                                        <option selected disabled value="">Selecione</option>
                                                        <!-- JS -->
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>

                                            <div class="col-lg-6 div-contas-receber">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2 ">Conta Bancária</label>
                                                    <select class="form-select select2 input-obrigatorio-venda select-conta-bancaria" name="conta_bancaria">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($contasBancarias as $contaBancaria) { ?>
                                                            <option value="<?= $contaBancaria['ID_CONTA_BANCARIA'] ?>"><?= $contaBancaria['apelido'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 div-contas-receber">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2 ">Forma de Recebimento</label>
                                                    <select class="form-select select2 input-obrigatorio-venda select-forma-recebimento" name="forma_recebimento">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($formasTransacoes as $formasTransacao) { ?>
                                                            <option value="<?= $formasTransacao['id'] ?>"><?= $formasTransacao['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>
                                            </div>

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
                                                    <label class="text-body-highlight fw-bold mb-2">Valor por <span class="nome-unidade-medida">Unidade</span></label>
                                                    <input class="form-control input-valor-unidade-medida input-obrigatorio-venda mascara-dinheiro" required name="valor" type="text" placeholder="Valor por unidade">
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
                                                <label class="text-body-highlight fw-bold mb-2">Desconto</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control input-desconto-venda" placeholder="Ex.: 15">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Valor total da Venda</label>
                                                    <input class="form-control mascara-dinheiro input-obrigatorio-venda input-valor-total" required name="valor" type="text" placeholder="Valor total da Venda">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2 label-data">Data da Venda</label>
                                                    <input autocomplete="off" class="form-control datetimepicker input-data-destinacao input-obrigatorio-venda cursor-pointer" required name="data_destinacao" type="text" placeholder="Selecione uma data" data-options='{"disableMobile":true,"allowInput":true,"dateFormat":"d/m/Y"}' />
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