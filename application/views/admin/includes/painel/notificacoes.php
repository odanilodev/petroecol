<?php
$dataAtualObj = new DateTime();
$dataAtualObj->setTime(0, 0);  // Garantir que estamos comparando com a data sem hora

$clientesCount = count(aprovacaoInativacao());
$documentos = documentosVencendo();

$documentosVencendo = $documentos['vencendo'];
$documentosVencidos = $documentos['vencido'];

$documentosVencidosVencendo = array_merge($documentosVencendo, $documentosVencidos);

$documentosCount = count($documentos['vencendo']) + count($documentos['vencido']);

$totalCount = $clientesCount + $documentosCount;
?>

<li class="nav-item dropdown btn-aprovacao-inativacao">
    <a class="nav-link px-2 icon-indicator icon-indicator-primary" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside" id="btnNotificacao">
        <span data-feather="bell" style="height:20px;width:20px;"></span>
        <span class="icon-indicator-number" id="notificacaoCount">
            <?= $totalCount >= 100 ? '99+' : $totalCount ?>
        </span>
    </a>

    <input type="hidden" class="quantidade-notificacao-clientes" value="<?= $clientesCount ?>">
    <input type="hidden" class="quantidade-notificacao-documentos-vencendo" value="<?= count($documentosVencendo) ?>">
    <input type="hidden" class="quantidade-notificacao-documentos-vencidos" value="<?= count($documentosVencidos) ?>">

    <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border border-300 navbar-dropdown-caret" id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">
        <div class="card position-relative border-0">
            <!-- Aprovação de Inativação -->
            <div class="card-header p-2">
                <div class="d-flex justify-content-between p-2 cursor-pointer collapsed" data-bs-toggle="collapse" data-bs-target="#collapseAprovacaoInativacao" aria-expanded="false" aria-controls="collapseAprovacaoInativacao">
                    <h5 class="text-black mb-0">Aprovação de Inativação</h5>
                    <?php if ($clientesCount > 0) { ?>
                        <div class="ms-auto">
                            <span class="badge bg-danger ms-2" id="clientesBadge"><?= $clientesCount >= 100 ? '99+' : $clientesCount ?></span>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div id="collapseAprovacaoInativacao" class="collapse">
                <div class="scrollbar-overlay" style="height: 500px;">
                    <div class="border-300">
                        <?php foreach (aprovacaoInativacao() as $v) { ?>
                            <?php
                            $dataUltimaColetaObj = new DateTime($v['ULTIMA_COLETA']);
                            $diferenca = $dataUltimaColetaObj->diff($dataAtualObj);
                            ?>
                            <div class="px-2 px-sm-3 py-3 border-300 notification-card position-relative unread border-bottom notificacao-<?= $v['id'] ?>">
                                <div class="d-flex align-items-center justify-content-between position-relative">
                                    <div class="d-flex">
                                        <div class="flex-1 me-sm-3">
                                            <h4 class="fs--1"><a class="text-black text-decoration-none" href="<?= base_url('clientes/detalhes/' . $v['id']) ?>"><?= $v['nome'] ?></a></h4>
                                            <?php if ($v['ULTIMA_COLETA']) { ?>
                                                <p class="fs--1 text-1000 mb-sm-3 fw-normal">Sem coletas há <span class="ms-2 text-danger fw-bold fw-normal"><?= $diferenca->days; ?> Dias</span></p>
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

            <hr style="margin:0; padding:0;">


            <!-- Documentos a Vencer -->
            <div class="card-header p-2">
                <div class="d-flex justify-content-between p-2 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapseDocumentos" aria-expanded="false" aria-controls="collapseDocumentos">
                    <h5 class="text-black mb-0">Documentos</h5>
                    <?php if ($documentosCount > 0) { ?>
                        <div class="ms-auto">
                            <span class="badge bg-warning ms-2" id="documentosVencendoBadge"><?= count($documentosVencendo) ?></span>
                            <span class="badge bg-danger" id="documentosVencidosBadge"><?= count($documentosVencidos) ?></span>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div id="collapseDocumentos" class="collapse">
                <div class="scrollbar-overlay">
                    <div class="border-300">
                        <?php foreach ($documentosVencendo as $documentoVencendo) { ?>
                            <?php
                            $dataValidadeObj = new DateTime($documentoVencendo['validade']);
                            $diferencaVencendo = $dataAtualObj->diff($dataValidadeObj);
                            ?>

                            <div class="px-2 px-sm-3 py-3 border-300 notification-card position-relative unread border-bottom">
                                <div class="d-flex align-items-center justify-content-between position-relative">
                                    <div class="d-flex">
                                        <div class="flex-1 me-sm-3">
                                            <h4 class="fs--1"><?= $documentoVencendo['nome'] ?></h4>
                                            <?php
                                            if ($diferencaVencendo->days == 0) { ?>
                                                <p class="fs--1 text-1000 mb-sm-3 fw-normal">Vence <strong class="text-danger">hoje!</strong></p>
                                            <?php } elseif ($diferencaVencendo->days == 1) { ?>
                                                <p class="fs--1 text-1000 mb-sm-3 fw-normal">Vence <strong class="text-warning">amanhã!</strong></p>
                                            <?php } elseif ($diferencaVencendo->days < 30) { ?>
                                                <p class="fs--1 text-1000 mb-sm-3 fw-normal">Vence em <strong class="text-warning"><?= $diferencaVencendo->days ?> dias</strong></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="<?= base_url('documentoEmpresa') ?>" class="btn btn-phoenix-warning"><i class="fas fa-external-link-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php foreach ($documentosVencidos as $documentoVencido) { ?>
                            <?php
                            $dataValidadeObj = new DateTime($documentoVencido['validade']);
                            $diferencaVencido = $dataAtualObj->diff($dataValidadeObj);
                            ?>
                            <div class="px-2 px-sm-3 py-3 border-300 notification-card position-relative unread border-bottom">
                                <div class="d-flex align-items-center justify-content-between position-relative">
                                    <div class="d-flex">
                                        <div class="flex-1 me-sm-3">
                                            <h4 class="fs--1"><?= $documentoVencido['nome'] ?></h4>
                                            <p class="fs--1 text-1000 mb-sm-3 fw-normal">Venceu há <span class="text-danger"><?= $diferencaVencido->days ?> dias</span></p>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="<?= base_url('documentoEmpresa') ?>" class="btn btn-phoenix-danger"><i class="fas fa-external-link-alt"></i></a>
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