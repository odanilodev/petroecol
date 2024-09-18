<div class="content">
    <div id="members">

        <div class="row align-items-center justify-content-between g-3 mb-4">

            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-900 me-4 px-0 d-none"><span class="fa-solid fa-file-export fs--1 me-2"></span>Export</button>
                    <a href="<?= base_url("romaneios/formulario") ?>" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Novo Romaneio</a>
                </div>
            </div>

            <div class="col col-auto">
                <div class="search-box">
                    <form class="position-relative" method="post" action="<?= base_url("romaneios/")?>" data-bs-toggle="search" data-bs-display="static">
                        <input value="<?= $cod_romaneio?>" name="cod-romaneio" class="form-control search-input search" type="search" placeholder="Buscar Romaneios" aria-label="Search" />
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
    <div class="modal fade modal-romaneio-select2" id="modalConcluirRomaneio" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <span style="font-weight:700;">Responsável: </span> <span class="responsavel" style="margin-left:5px;"></span>
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
                                <select class="form-select w-100 mb-3 select2-edita add-novo-cliente-romaneio" id="select-cliente-modal">

                                    <option selected value="">Selecione o cliente</option>


                                </select>
                                <div class="d-none aviso-obrigatorio aviso-novo-cliente-romaneio">Preencha este campo</div>

                            </div>
                        </div>

                        <div class="col-2 mt-2 mb-4">
                            <button type="button" class="btn btn-secondary adicionar-cliente">Adicionar</button>
                        </div>

                    </div>

                    <div class="col-12 row">

                        <div class="col-4">

                            <div class="mt-2 mb-4">

                                <label>Motorista</label>
                                <select class="form-select w-100 mb-3 select2" id="select-editar-motorista">

                                    <option selected disabled value="">Alterar Motorista</option>

                                    <?php foreach ($responsaveis as $responsavel) { ?>
                                        <option value="<?= $responsavel['IDFUNCIONARIO'] ?>"><?= $responsavel['nome'] ?></option>
                                    <?php } ?>

                                </select>
                                <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="accordion dados-clientes-div-editar" id="accordionEditar">

                            <!-- Manipulado JS -->
                        </div>

                    </div>

                </div>


                <div class="modal-footer">
                    <div class="spinner-border text-primary load-form d-none load-form-modal-romaneio" role="status"></div>
                    <button type="button" class="btn btn-primary btn-salva-edicao-romaneio">Salvar</button>
                    <input type="hidden" class="id_responsavel">
                    <input type="hidden" class="code_romaneio">
                    <input type="hidden" class="data_romaneio">
                    <input type="hidden" class="input-id-setor-empresa">

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

                                                    <div class="text-start">

                                                        <input type="checkbox" class="check-sem-custos form-check-input cursor-pointer"> Sem custos
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

    <!-- Adicionar mais verbas para o responsável-->
    <div class="modal fade modal-verbas-select2" id="modalAdicinarVerbaRomaneio" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollabe modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verba para o responsável pela coleta</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0 form-verba-adicional-responsavel-coleta">

                                            <div class="row">

                                                <div class="col-12 mb-3">
                                                    <p>
                                                        <span class="nome-funcionario"></span>
                                                        - <span class="saldo-verba-funcionario"></span>
                                                    </p>
                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Grupos Macros</label>
                                                        <select class="form-select select2 select-macros input-obrigatorio-verba" name="id_macro">
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
                                                        <select disabled class="form-select select2 select-micros input-obrigatorio-verba" name="id_micro">
                                                            <option selected disabled value="">Selecione</option>
                                                            <!-- JS -->
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="campos-pagamento row">
                                                <div class="col-lg-4 duplica-pagamento">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Conta Bancária</label>
                                                        <select name="conta-bancaria" class="form-select select2 select-conta-bancaria input-obrigatorio-verba">
                                                            <option value="" selected disabled>Selecione</option>
                                                            <?php foreach ($contasBancarias as $contaBancaria) { ?>
                                                                <option value="<?= $contaBancaria['id_conta_bancaria'] ?>">
                                                                    <?= $contaBancaria['apelido'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 duplica-pagamento">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Forma Pagamento</label>
                                                        <select name="forma-pagamento" class="form-select select2 select-forma-pagamento input-obrigatorio-verba">
                                                            <option value="" selected disabled>Selecione</option>
                                                            <?php foreach ($formasTransacao as $formaTransacao) { ?>
                                                                <option value="<?= $formaTransacao['id'] ?>">
                                                                    <?= $formaTransacao['nome'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 duplica-pagamento">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                        <input class="form-control input-valor-recebido mascara-dinheiro input-valor-unic input-obrigatorio-verba" required name="valor" type="text" placeholder="Valor">
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 mt-5">
                                                    <button title="Mais formas de pagamento" type="button" class="btn btn-phoenix-success bg-white hover-bg-100 duplicar-verbas-pagamento">+</button>
                                                </div>

                                                <div class="campos-duplicados">
                                                    <!-- JS -->
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
                    <input type="hidden" class="id-responsavel">
                    <div class="spinner-border text-primary load-form-pagamento d-none" role="status"></div>
                    <button type="button" class="btn btn-primary btn-salva-verba-responsavel" onclick="salvarVerbasAdicionaisRomaneio()">Salvar</button>

                </div>
            </div>
        </div>
    </div>