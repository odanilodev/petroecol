<div class="content">
    <div id="members">

    <div class="row align-items-center justify-content-between g-3 mb-4">

            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-900 me-4 px-0 d-none"><span class="fa-solid fa-file-export fs--1 me-2"></span>Export</button>
                    <a href="<?= base_url("romaneios/formulario") ?>" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Novo Romaneio</a>
                </div>
            </div>
        </div>

        <?php if (!empty($ultimosRomaneios)) { ?>

            <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
                <div class="table-responsive scrollbar ms-n1 ps-1">

                    <table class="table table-lg mb-0 table-hover">
                        <thead>
                            <tr>
                                <th class="sort align-middle text-center">Código</th>
                                <th class="sort align-middle text-center">Motorista</th>
                                <th class="sort align-middle text-center">Data do Romaneio</th>
                                <th class="sort align-middle text-center">Gerado em</th>
                                <th class="sort align-middle p-3 text-center">Gerar</th>
                                <th class="sort align-middle p-3 text-center">Concluir Romaneio</th>
                            </tr>
                        </thead>

                        <tbody class="list" id="members-table-body">

                            <?php foreach ($ultimosRomaneios as $v) { ?>

                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                    <td class="email align-middle white-space-nowrap text-center">
                                        <?= $v['codigo']; ?>
                                    </td>

                                    <td class="mobile_number align-middle white-space-nowrap text-center">
                                        <?= $v['MOTORISTA']; ?>
                                    </td>

                                    <td class="mobile_number align-middle white-space-nowrap text-center">
                                        <?= date('d/m/Y', strtotime($v['data_romaneio'])) ?>
                                    </td>

                                    <td class="mobile_number align-middle white-space-nowrap text-center">
                                        <?= date('d/m/Y H:i:s', strtotime($v['criado_em'])) ?>
                                    </td>

                                    <td class="align-middle white-space-nowrap text-center">
                                        <a target="_blank" href="<?=base_url('romaneios/gerarromaneio/'.$v['codigo'])?>" class="btn btn-info">
                                            <span class="fas fa-download ms-1"></span>
                                        </a>
                                    </td>

                                    <td class="align-middle white-space-nowrap text-center">
                                        <a onclick="alert('Criar uma página ou modal listando todos os clientes vinculado a este romaneio, nessa página precisa ter os inputs dos dados que precisa ser preenchido para dar baixa no romaneio.. um ponto importante é que só vai dar baixa mudando o status desse romaneio se TODOS os inputs de TODOS os clientes forem preenchidos .. caso contrário nao dar baixa mantendo o icone cinzinha')" class="btn <?= $v['status'] != 1 ? 'btn-secondary' : 'btn-success'?>">
                                            <span class="fas ms-1 <?= $v['status'] != 1 ? 'fa-thumbs-down' : 'fa-thumbs-up'?>"></span>
                                        </a>
                                    </td>

                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>

        <?php } ?>
    </div>