<div class="content">
    <div id="members" data-list='{"valueNames":["customer","email","mobile_number","city","last_active","joined"],"pagination":false}'>
        <div class="row align-items-center justify-content-between g-3 mb-4">
            <div class="col-auto">
                <h4>Permissão por usuários</h4>
            </div>
            <div class="col col-auto">
                <div class="search-box">
                    <!-- Formulário de pesquisa -->
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                        <input class="form-control search-input search" type="search" placeholder="Buscar Usuários" aria-label="Search" />
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
                            <!-- Cabeçalho da tabela -->
                            <th class="align-middle" scope="col">Usuário</th>
                            <th class="sort pe-3" title="Liberar Todos"> 
                                <input class="check-all-element cursor-pointer form-check-input" type="checkbox">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="members-table-body">
                        <?php foreach ($usuarios as $usuario) {  ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                <td class="email align-middle white-space-nowrap">
                                    <?=$usuario['nome']?>
                                </td>
                                <td class="align-middle white-space-nowrap pt-3">

                                    <!-- check de permissão -->
                                    <div class="form-check">
                                        <input class="check-element cursor-pointer form-check-input" <?= in_array($usuario['id'], $id_usuarios) ? 'checked' : '' ?> name="permissao" type="checkbox" value="<?=$usuario['id']?>">
                                    </div>
                                </td>
                            </tr>
                        <?php }  ?>

                    </tbody>
                </table>
            </div>
            <div class="flex-1 text-end my-5">
                <button class="btn btn-primary px-6 px-sm-6" onclick="atualizaPermissoesComponente(<?= $this->uri->segment(3) ?>)">Atualizar
                    <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span>
                </button>
                <div class="spinner-border text-primary load-form d-none" role="status"></div>
            </div>
        </div>
    </div>