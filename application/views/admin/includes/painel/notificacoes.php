<?php $dataAtualObj = new DateTime();
if (aprovacaoInativacao() && permissaoComponentes('btn-notificacao-cabecalio')) { ?>
    <li class="nav-item dropdown btn-aprovacao-inativacao">
        <a class="nav-link px-2 icon-indicator icon-indicator-primary" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside">
            <span data-feather="bell" style="height:20px;width:20px;"></span>
            <span class="icon-indicator-number"><?= count(aprovacaoInativacao()) >= 100 ? '99+' : count(aprovacaoInativacao()) ?></span>
        </a>
        <input type="hidden" class="quantidade-notificacao" value="<?=count(aprovacaoInativacao())?>">


        <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border border-300 navbar-dropdown-caret" id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">
            <div class="card position-relative border-0">
                <div class="card-header p-2">
                    <div class="d-flex justify-content-between">
                        <h5 class="text-black mb-0">Aprovação de Inativação</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="scrollbar-overlay" style="height: 27rem;">
                        <div class="border-300">
                            <?php foreach (aprovacaoInativacao() as $v) { ?>
                                <?php
                                $dataUltimaColetaObj = new DateTime($v['ULTIMA_COLETA']);
                                $diferenca = $dataUltimaColetaObj->diff($dataAtualObj);
                                ?>
                                <div class="px-2 px-sm-3 py-3 border-300 notification-card position-relative unread border-bottom notificacao-<?=$v['id']?>">
                                    <div class="d-flex align-items-center justify-content-between position-relative">
                                        <div class="d-flex">
                                            <div class="flex-1 me-sm-3">
                                                <h4 class="fs--1"><a class="text-black text-decoration-none" href="<?= base_url('clientes/detalhes/' . $v['id']) ?>"><?= $v['nome'] ?></a></h4>
                                                <?php if ($v['ULTIMA_COLETA']) { ?>
                                                    <p class="fs--1 text-1000 mb-sm-3 fw-normal">Sem coletas á<span class="ms-2 text-danger fw-bold fw-normal"><?= $diferenca->days; ?> Dias</span></p>
                                                <?php } else { ?>
                                                    <p class="fs--1 text-1000 mb-sm-3 fw-normal">Nunca coletado</p>
                                                <?php } ?>
                                                <p class="text-800 fs--1 mb-0 cursor-pointer"><span class="me-1 fas fa-check text-success"></span><span onclick="inativaCliente(<?= $v['id'] ?>)" class="fw-bold">CONFIRMAR INATIVAÇÃO?</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </li>
<?php } ?>