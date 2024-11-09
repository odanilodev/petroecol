<div class="content">
    <div id="members">
        <a href="<?= base_url('afericao/residuosAferidos')?>" class="btn btn-phoenix-primary mb-3">Resíduos Aferidos</a>

        <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
            <div class="table-responsive scrollbar ms-n1 ps-1">
                <table class="table table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th class="sort align-middle text-center" scope="col">Data da coleta</th>
                            <th class="sort align-middle text-center" scope="col">Romaneio</th>
                            <th class="sort align-middle text-center" scope="col">Responsável</th>
                            <th class="sort align-middle text-center" scope="col">Aferido</th>
                            <th class="sort align-middle text-center" scope="col">Trajeto</th>
                            <th class="sort align-middle text-center" scope="col">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="list" id="members-table-body">

                        <?php foreach ($afericoes as $afericao) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                <td class="align-middle text-center white-space-nowrap">
                                    <?= date('d/m/Y', strtotime($afericao['data_coleta'])) ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    <?= $afericao['cod_romaneio'] ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    <?= $afericao['nome'] ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    <i class="fas fa-check-circle <?= $afericao['aferido'] ? "text-success" : "text-secondary" ?>"></i>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    <?= $afericao['TRAJETO'] ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs--2"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">

                                            <?php if (!$afericao['aferido']) { ?>

                                                <a class="dropdown-item" href="<?= base_url('afericao/aferirResiduos/' . $afericao['cod_romaneio']) ?>">
                                                    <span class="fas fa-eye"></span> Aferir
                                                </a>

                                                <a data-codigo="<?= $afericao['cod_romaneio'] ?>" data-id-trajeto="<?= $afericao['ID_TRAJETO']?>" class="dropdown-item btn-add-trajeto" href="#" data-bs-toggle="modal" data-bs-target="#modalTrajeto">
                                                    <span class="fas fa-map-marked"></span> <?= $afericao['TRAJETO'] ? "Editar" : "Adicionar"?>  Trajeto
                                                </a>

                                            <?php } ?>

                                            <a data-id-setor-empresa="<?= $afericao['id_setor_empresa'] ?>" data-saldo="<?= $afericao['saldo'] ?>" data-id-funcionario="<?= $afericao['ID_FUNCIONARIO'] ?>" data-codigo="<?= $afericao['cod_romaneio'] ?>" data-funcionario="<?= $afericao['nome'] ?>" class="dropdown-item btn-prestar-contas-afericao" href="#" data-bs-toggle="modal" data-bs-target="#modalPrestarConta">
                                                <span class="fas fa-coins"></span> Adicionar Custos
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
                        <ul class="pagination mt-5">
                            <?= $this->pagination->create_links(); ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Prestar Contas -->
    <div class="modal fade" tabindex="-1" id="modalPrestarConta">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Prestação de Contas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-dados-financeiros">
                    <div class="card theme-wizard mb-5">
                        <div class="card-header bg-100 pt-3 pb-2 border-bottom-0">
                            <ul class="nav justify-content-between nav-wizard" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-semi-bold active btn-custos" href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1" aria-selected="true" role="tab">
                                        <div class="text-center d-inline-block">
                                            <span class="nav-item-circle-parent">
                                                <span class="nav-item-circle">
                                                    <span class="fas fa-money-check-alt"></span>
                                                </span>
                                            </span>
                                            <span class="d-none d-md-block mt-1 fs--1">Custos</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a disabled class="nav-link fw-semi-bold btn-troco" href="#bootstrap-wizard-tab2" data-bs-toggle="tab" data-wizard-step="2" aria-selected="false" role="tab" tabindex="-1">
                                        <div class="text-center d-inline-block">
                                            <span class="nav-item-circle-parent">
                                                <span class="nav-item-circle">
                                                    <span class="fas fa-coins"></span>
                                                </span>
                                            </span>
                                            <span class="d-none d-md-block mt-1 fs--1">Troco</span>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body pt-4 pb-0">
                            <div class="tab-content">
                                <div class="tab-pane active show" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1">

                                    <!-- Tipos de Custos-->
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="mx-0 mx-sm-3 mx-lg-0 px-lg-0">
                                            <div class="campos-form">
                                                <div class="row campos-pretacao">

                                                    <div class="col-12 mb-3">
                                                        <p>
                                                            <span class="nome-funcionario"></span>
                                                            - <span class="saldo-funcionario"></span>
                                                        </p>
                                                    </div>

                                                    <div class="col-lg-6">

                                                        <div class="mb-4">
                                                            <label class="text-body-highlight fw-bold mb-2">Grupos Macros</label>
                                                            <select required class="form-select select2 select-macros-prestacao input-obrigatorio-custo dados-conta" name="id_macro">
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
                                                            <select disabled class="form-select select2 select-micros-prestacao input-obrigatorio-custo dados-conta" name="id_micro">
                                                                <option selected disabled value="">Selecione</option>
                                                                <!-- JS -->
                                                            </select>
                                                            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-6">

                                                        <div class="mb-4 ">
                                                            <label class="text-body-highlight fw-bold mb-2">Tipo de Pagamento</label>
                                                            <select class="form-select select2 select-tipo-pagamento input-obrigatorio-custo dados-conta" name="tipo-pagamento">
                                                                <option selected disabled value="">Selecione</option>
                                                                <option value="ato" data-tipo="0">Pagamento no Ato</option>
                                                                <option value="prazo" data-tipo="1">Pagamento a Prazo</option>
                                                            </select>
                                                            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                            <input type="hidden" name="nome-recebido" class="nome-recebido">

                                                        </div>

                                                    </div>

                                                    <div class="col-lg-6">

                                                        <div class="mb-4">
                                                            <label class="text-body-highlight fw-bold mb-2">Tipo de custo</label>
                                                            <select class="form-select select2 input-obrigatorio-custo select-tipos-custos dados-conta" name="tipos-custos">
                                                                <option selected disabled value="">Selecione</option>
                                                                <?php foreach ($tiposCustos as $tipoCusto) { ?>
                                                                    <option value="<?= $tipoCusto['id'] ?>"><?= $tipoCusto['nome']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">

                                                        <div class="mb-4 ">
                                                            <label class="text-body-highlight fw-bold mb-2">Recebido</label>
                                                            <select class="form-select select2 select-recebido dados-conta" name="recebido">
                                                                <option selected disabled value="">Selecione</option>
                                                                <?php
                                                                $mesAtual = date('m');
                                                                $anoAtual = date('Y');
                                                                $dataAtual = date('Y-m-d');
                                                                foreach ($dadosFinanceiro as $dadoFinanceiro) {

                                                                    $dataFaturamento = $anoAtual . '-' . $mesAtual . '-' . $dadoFinanceiro['dia_faturamento'];

                                                                    $dataFaturamentoObj = new DateTime($dataFaturamento);

                                                                    if ($dataFaturamento < $dataAtual) {

                                                                        $dataFaturamentoObj->modify('+1 month');
                                                                    }

                                                                    $novaDataFaturamento = $dataFaturamentoObj->format('Y-m-d');

                                                                ?>
                                                                    <option data-faturamento="<?= $novaDataFaturamento ?>" data-nome="<?= $dadoFinanceiro['nome'] ?>" value="<?= $dadoFinanceiro['id'] ?>">
                                                                        <?= $dadoFinanceiro['nome'] ?>
                                                                    </option>

                                                                <?php } ?>

                                                            </select>
                                                            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                            <input type="hidden" name="nome-recebido" class="nome-recebido">

                                                        </div>

                                                    </div>


                                                    <div class="col-lg-4">

                                                        <div class="mb-4">
                                                            <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                            <input class="form-control input-obrigatorio-custo mascara-dinheiro input-valor dados-conta" required name="valor" type="text" placeholder="Valor total da conta">
                                                            <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                        </div>

                                                    </div>

                                                    <div class="col-lg-4">

                                                        <div class="mb-4">
                                                            <label class="text-body-highlight fw-bold mb-2">Data Para pagamento</label>
                                                            <input disabled autocomplete="off" class="form-control datetimepicker data-pagamento " required type="text" placeholder="Escolha uma Data" data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                                                            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                        </div>

                                                    </div>

                                                    <div class="text-end mt-3 btn-duplica-campos">
                                                        <button title="Mais custos" type="button" class="btn btn-phoenix-success duplicar-custo">+</button>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="campos-duplicados-prestacao-contas campos-form">
                                                <!-- JS -->
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2">
                                    <!-- Troco do Funcionário -->
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0 campos-form-troco">

                                            <div class="col-12 mb-3">
                                                <p>
                                                    <span class="nome-funcionario"></span>
                                                    - <span class="saldo-funcionario"></span>
                                                </p>
                                            </div>

                                            <div class="col-lg-4 duplica-pagamento">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Conta Bancária</label>
                                                    <select class="form-select select2 select-conta-bancaria conta-bancaria-troco">
                                                        <option value="" selected disabled>Selecione</option>
                                                        <?php foreach ($contasBancarias as $contaBancaria) { ?>
                                                            <option value="<?= $contaBancaria['id_conta_bancaria'] ?>">
                                                                <?= $contaBancaria['apelido'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 duplica-pagamento">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Forma Pagamento</label>
                                                    <select class="form-select select2 select-forma-pagamento forma-pagamento-troco">
                                                        <option value="" selected disabled>Selecione</option>
                                                        <?php foreach ($formasTransacao as $formaTransacao) { ?>
                                                            <option value="<?= $formaTransacao['id'] ?>">
                                                                <?= $formaTransacao['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Troco devolvido</label>
                                                    <input class="form-control mascara-dinheiro valor-devolvido valor-troco" required name="valor-devolvido" type="text" placeholder="Valor total devolvido">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="div-obs d-none">
                                                <textarea class="form-control observacao" rows="2" name="observacao" value="" placeholder="Descreva o tipo de gasto"></textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-1" data-wizard-footer="data-wizard-footer">
                    <input type="hidden" class="valor-troco-parcial">
                    <input type="hidden" class="input-saldo-funcionario">
                    <input type="hidden" class="codigo-romaneio">
                    <input type="hidden" class="id-funcionario">
                    <input type="hidden" class="id-setor-empresa">

                    <div class="spinner-border text-primary load-form d-none load-form-modal-romaneio" role="status"></div>
                    <button id="btn-voltar-etapa" class="btn btn-secondary d-none btn-form" type="button" data-wizard-prev-btn="data-wizard-prev-btn">Voltar</button>
                    <button id="btn-proxima-etapa" class="btn btn-info btn-form btn-proxima-etapa" type="button">Próxima Etapa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Prestar Contas -->
    <div class="modal fade" tabindex="-1" id="modalTrajeto">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atribuir Trajeto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-dados-financeiros">
                    <div class="card theme-wizard mb-5">

                        <div class="card-body pt-4 pb-0">

                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <label class="text-body-highlight fw-bold mb-2">Adicionar Trajeto</label>
                                    <select class="form-select select2 input-obrigatorio-trajeto select-trajeto">
                                        <option selected disabled value="">Selecione</option>
                                        <?php foreach ($trajetos as $trajeto) { ?>
                                            <option value="<?= $trajeto['id']?>"><?= $trajeto['nome']?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-1">
                    <div class="spinner-border text-primary load-form d-none load-form-modal-romaneio" role="status"></div>
                    <button class="btn btn-info btn-form" onclick="finalizarTrajetoAfericao()" type="button">Finalizar</button>
                </div>

            </div>
        </div>
    </div>