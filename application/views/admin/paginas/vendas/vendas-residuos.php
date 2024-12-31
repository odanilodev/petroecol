<div class="content">

    <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
        <div id="members">
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
                                            <a class="dropdown-item" href="#" onclick="editarVenda(<?= $vendaResiduo['id']?>)" data-bs-toggle="modal" data-bs-target="#modalEditarVenda">
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