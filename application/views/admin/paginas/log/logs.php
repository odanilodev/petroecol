<div class="content">
    <div id="members">
        <form method="post" action="<?= base_url('log/index') ?>" class="row align-items-center g-3 mb-7">

            <div class="col-md-2">
                <select name="usuario" class="form-select" aria-label="Default select example">
                    <option selected disabled>Usuário</option>

                    <?php foreach ($usuarios as $v) { ?>

                        <option value="<?= $v['id']; ?>"><?= $v['nome']; ?></option>

                    <?php } ?>

                </select>
            </div>

            <?php if ($this->session->userdata('id_empresa') == 1) { ?>

                <div class="col-md-2">
                    <select class="form-select" aria-label="Default select example">
                        <option selected disabled>Empresa</option>

                        <?php foreach ($empresas as $v) { ?>
                            <option value="<?= $v['id_empresa']; ?>"><?= $v['nome']; ?></option>
                        <?php } ?>
                    </select>
                </div>

            <?php } ?>

            <div class="col-md-2">
                <input type="text" name="tela" class="form-control" placeholder="Tela">
            </div>

            <div class="col-md-2">
                <input type="text" name="acao" class="form-control" placeholder="Ação">
            </div>

            <div class="col-md-2">

                <input class="form-control datetimepicker" name="data-inicio" type="text" placeholder="Data Início" data-options='{"disableMobile":true,"allowInput":true}' />
            </div>

            <div class="col-md-2">

                <input class="form-control datetimepicker" name="data-fim" type="text" placeholder="Data Fim" data-options='{"disableMobile":true,"allowInput":true}' />
            </div>

            <div class="col-md-2">
                <button class="btn px-3 btn-phoenix-secondary" type="submit">
                    Filtrar <span class="fa-solid fa-filter text-primary" data-fa-transform="down-3"></span>
                </button>
            </div>



        </form>

        <?php if (!empty($logs)) { ?>

            <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
                <div class="table-responsive scrollbar ms-n1 ps-1">

                    <table class="table table-lg mb-0 table-hover">
                        <thead>
                            <tr>
                                <th class="sort align-middle">Usuário</th>
                                <th class="sort align-middle p-3">Item</th>
                                <th class="sort align-middle">Classe</th>
                                <th class="sort align-middle p-3">Método</th>
                                <th class="sort align-middle p-3">Data e Hora</th>
                            </tr>
                        </thead>

                        <tbody class="list" id="members-table-body">

                            <?php foreach ($logs as $v) { ?>

                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                    <td class="email align-middle white-space-nowrap">
                                        <?= $v['nome']; ?>
                                    </td>

                                    <td class="mobile_number align-middle white-space-nowrap">
                                        <?= $v['item']; ?>
                                    </td>

                                    <td class="mobile_number align-middle white-space-nowrap">
                                        <?= $v['classe']; ?>
                                    </td>

                                    <td class="mobile_number align-middle white-space-nowrap">
                                        <?= $v['metodo']; ?>
                                    </td>

                                    <td class="mobile_number align-middle white-space-nowrap">
                                        <?= date('d/m/Y | H:i:s', strtotime($v['criado_em'])) ?>
                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>

        <?php } ?>
    </div>