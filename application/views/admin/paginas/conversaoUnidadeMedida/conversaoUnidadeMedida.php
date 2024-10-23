<div class="content">
    <div id="members" data-list='{"valueNames":["nome-residuo", "nome-grupo", "setor-residuo"],"page":10,"pagination":true}'>
        <div class="row align-items-center justify-content-between g-3 mb-4">

            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <a href="<?= base_url("conversaoUnidadeMedida/formulario") ?>" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Adicionar Conversão</a>
                </div>
            </div>

            <div class="col col-auto">
                <div class="search-box">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                        <input class="form-control search-input search" type="search" placeholder="Buscar Conversões" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
            </div>
        </div>
        <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
            <div class="table-responsive scrollbar ms-n1 ps-1">
                <table class="table table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th class="align-middle" scope="col" data-sort="nome-residuo">Resíduo</th>
                            <th class="align-middle" scope="col" data-sort="nome-residuo">Medida de origem</th>
                            <th class="align-middle" scope="col" data-sort="nome-grupo">Operador</th>
                            <th class="align-middle" scope="col" data-sort="setor-residuo">Valor</th>
                            <th class="align-middle" scope="col" data-sort="setor-residuo">Medida de destino</th>
                            <th class="align-middle" scope="col">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="list" id="members-table-body align-middle">

                        <?php foreach ($conversoesUnidadesMedidas as $conversao) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                <td class="nome-grupo align-middle white-space-nowrap">
                                    <?= $conversao['RESIDUO']; ?>
                                </td>

                                <td class="nome-grupo align-middle white-space-nowrap">
                                    <?= $conversao['nome_unidade_origem']; ?>
                                </td>

                                <td class="nome-grupo align-middle white-space-nowrap">
                                    <?= $conversao['simbolo_operacao']; ?>
                                </td>

                                <td class="setor-residuo align-middle white-space-nowrap">
                                    <?= $conversao['valor']; ?>
                                </td>

                                <td class="nome-grupo align-middle white-space-nowrap">
                                    <?= $conversao['nome_unidade_destino']; ?>
                                </td>

                                <td class="align-middle white-space-nowrap">

                                    <div class="font-sans-serif btn-reveal-trigger position-static">

                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs--2"></span>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-start py-2">
                                            <a class="dropdown-item" href="#"
                                                onclick="exemploConversaoMedidas('<?= $conversao['nome_unidade_origem'] ?>','<?= $conversao['tipo_operacao'] ?>','<?= $conversao['valor'] ?>', '<?= $conversao['nome_unidade_destino'] ?>', '<?= $conversao['RESIDUO']; ?>')" data-bs-toggle="modal" data-bs-target="#modalExemploConversaoMedidas">
                                                <span class="fas fa-eye"></span> Exemplo
                                            </a>

                                            <a class="dropdown-item editar-lancamento btn-editar-" href="<?= base_url("conversaoUnidadeMedida/formulario/" . $conversao['id']) ?>">
                                                <span class="fas fa-pencil"></span> Editar
                                            </a>

                                            <a class="dropdown-item editar-lancamento btn-excluir-"
                                                href="#" onclick="deletarConversao(<?= $conversao['id']?>)">
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
            <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
                <div class="col-auto d-none">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p>
                    <a class="fw-semi-bold" href="#!" data-list-view="*">Ver todos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">Ver menos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>

                <div class="col-auto d-flex w-100 justify-content-end">
                    <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal visualizar contas a pagar -->
    <div class="modal fade" tabindex="-1" id="modalExemploConversaoMedidas">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Exemplo de Conversao</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">
                                            <div class="col-sm-12 col-xxl-12 border-bottom py-3">

                                                <label class="text-body-highlight fw-bold mb-2 label-converter">
                                                    <!-- JS -->
                                                </label>
                                                <input class="quantidade-converter form-control" type="number">
                                                <p class="exemplo-conversao mt-3">
                                                    <!-- JS -->
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <input type="hidden" class="residuo">
                    <input type="hidden" class="nome-medida-origem">
                    <input type="hidden" class="tipo-operacao">
                    <input type="hidden" class="valor">
                    <input type="hidden" class="nome-medida-destino">

                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>