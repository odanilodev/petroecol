<div class="content">
    <div id="members" data-list='{"valueNames":["customer","email","mobile_number","city","last_active","joined"],"pagination":false}'>
        <div class="row align-items-center justify-content-between g-3 mb-4">
            <div class="col-auto">
                <h4>Permissão de usuarios</h4>
            </div>
            <div class="col col-auto">
                <div class="search-box">
                    <!-- Formulário de pesquisa -->
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                        <input class="form-control search-input search" type="search" placeholder="Buscar Menus" aria-label="Search" />
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
                            <th class="align-middle" scope="col">Menu</th>
                            <th class="sort pe-3" title="Liberar Todos"> 
                                <input class="check-all-element cursor-pointer form-check-input" type="checkbox">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="members-table-body">

                        <?php function printMenu($menu, $id_menu, $level = 0)
                        {   ?> <!-- Quando o $level é igual a zero significa que a categoria é pai -->

                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                <td class="email align-middle white-space-nowrap" style="padding-left: <?= $level * 20 ?>px;">
                                    <?php
                                    // Verifica o nível do menu e formata o nome
                                    if ($level === 0) {

                                        $menu['nome'] = $menu['link'] == null ? '<strong>' . mb_strtoupper($menu['nome']) . '</strong>' : mb_strtoupper($menu['nome']);
                                    } elseif ($level === 1) {
                                        $menu['nome'] = ucwords($menu['nome']);
                                    }
                                    echo ($level > 0 ? '- ' : '') . $menu['nome'];
                                    ?>
                                </td>
                                <td class="align-middle white-space-nowrap pt-3">

                                    <!-- check de permissão -->
                                    <div class="form-check">
                                        <input class="check-element cursor-pointer form-check-input" <?= in_array($menu['id'], $id_menu) ? 'checked' : '' ?> name="permissao" type="checkbox" value="<?= $menu['id'] ?>">
                                    </div>
                                </td>
                            </tr>
                        <?php
                            if (isset($menu['sub_menus']) && is_array($menu['sub_menus'])) {
                                foreach ($menu['sub_menus'] as $submenu) {
                                    // Chama a função recursivamente para menus aninhados
                                    printMenu($submenu, $id_menu, $level + 1);
                                }
                            }
                        }

                        foreach ($menus as $menu) {
                            if (empty($menu['sub'])) {
                                // Chama a função para imprimir menus principais
                                printMenu($menu, $id_menu);
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="flex-1 text-end my-5">
                <button class="btn btn-primary px-6 px-sm-6" onclick="atualizaPermissoesUsuario(<?=$this->uri->segment(3)?>)">Atualizar
                    <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span>
                </button>
                <div class="spinner-border text-primary load-form d-none" role="status"></div>
            </div>
        </div>
    </div>