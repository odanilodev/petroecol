<?php
$dataAtualObj = new DateTime();
$dataAtualObj->setTime(0, 0);

$clientesCount = count(aprovacaoInativacao());
$documentos = documentosVencendo();

$documentosVencendo = $documentos['vencendo'] ?? [];
$documentosVencidos = $documentos['vencido'] ?? [];

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
                <div class="d-flex justify-content-between p-2 cursor-pointer collapsed" data-bs-toggle="collapse" data-bs-target="#collapseAprovacaoInativacao" aria-expanded="false" aria-controls="collapseAprovacaoInativacao" id="toggleAprovacao">

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

                            $badgeComodato = '';

                            if ($v['ID_COMODATO']) {
                                $badgeComodato = '
                                    <div class="d-flex justify-content-end align-items-center" style="position:absolute; right:0; bottom:0;">
                                        <span class="rounded-circle d-flex justify-content-center align-items-center" style="width:24px; height:24px;" title="Comodato existente">
                                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                                width="878.000000pt" height="959.000000pt" viewBox="0 0 878.000000 959.000000"
                                                preserveAspectRatio="xMidYMid meet">

                                                <g transform="translate(0.000000,959.000000) scale(0.100000,-0.100000)"
                                                fill="var(--phoenix-theme-control-toggle-color)" stroke="none">
                                                <path d="M3985 8288 c-601 -34 -1116 -127 -1520 -273 -349 -126 -576 -282
                                                -660 -450 -25 -51 -29 -71 -29 -140 0 -67 4 -89 28 -138 89 -184 362 -358 762
                                                -487 1328 -425 3510 -284 4256 276 190 142 260 304 200 462 -132 348 -891 636
                                                -1927 732 -312 29 -790 37 -1110 18z m-620 -533 c208 -31 335 -90 335 -155 0
                                                -80 -193 -147 -490 -170 -330 -25 -693 39 -769 136 -27 34 -27 37 10 78 95
                                                109 554 165 914 111z"/>
                                                <path d="M1832 5625 c3 -1082 5 -1236 18 -1248 17 -16 108 -47 316 -106 524
                                                -150 1092 -247 1649 -281 196 -12 703 -15 855 -5 575 38 879 80 1355 187 276
                                                62 758 205 921 273 l34 14 0 1177 0 1176 -24 -6 c-13 -3 -104 -44 -202 -92
                                                -378 -181 -472 -216 -805 -298 -303 -74 -512 -111 -829 -146 -412 -46 -1013
                                                -46 -1397 0 -46 6 -122 15 -170 20 -159 19 -301 43 -518 85 -251 50 -333 71
                                                -515 131 -235 78 -475 202 -631 325 -20 16 -42 29 -48 29 -9 0 -11 -323 -9
                                                -1235z m4380 -168 c56 -89 121 -200 145 -247 42 -83 43 -85 40 -170 -6 -148
                                                -77 -259 -205 -322 -61 -30 -74 -33 -162 -33 -81 0 -103 4 -150 26 -30 14 -70
                                                39 -89 55 -82 69 -139 209 -127 311 11 96 32 137 217 428 34 55 83 139 107
                                                188 l44 87 39 -80 c21 -45 85 -154 141 -243z"/>
                                                <path d="M5839 5200 c-74 -117 -72 -264 4 -338 33 -32 107 -62 153 -62 21 0
                                                17 6 -30 53 -69 67 -95 135 -104 272 -7 95 -8 98 -23 75z"/>
                                                <path d="M6890 4241 c-24 -14 -374 -127 -526 -170 -463 -132 -933 -217 -1474
                                                -268 -144 -13 -288 -17 -645 -17 -454 -1 -511 2 -860 40 -454 50 -966 155
                                                -1399 288 -98 31 -183 53 -188 50 -4 -3 -8 -444 -8 -981 l0 -975 -54 -60
                                                c-185 -204 -133 -418 148 -608 86 -57 293 -160 323 -160 10 0 27 -6 38 -14 75
                                                -52 487 -162 811 -216 419 -71 796 -101 1285 -101 387 0 602 11 924 46 682 76
                                                1234 232 1556 440 99 64 198 166 234 239 58 120 35 245 -68 365 l-47 55 0
                                                1028 c0 972 -1 1028 -17 1028 -10 0 -25 -4 -33 -9z"/>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>';
                            }
                            ?>
                            <div class="px-2 px-sm-3 py-3 border-300 notification-card position-relative unread border-bottom notificacao-<?= $v['id'] ?>">
                                <div class="d-flex align-items-center justify-content-between position-relative">
                                    <div class="d-flex flex-grow-1">
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
                                    <?= $badgeComodato ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php
            if ($documentosCount > 0) :
            ?>
                <hr style="margin:0; padding:0;">

                <!-- Documentos a Vencer -->
                <div class="card-header p-2">
                    <div class="d-flex justify-content-between p-2 cursor-pointer collapsed" data-bs-toggle="collapse" data-bs-target="#collapseDocumentos" aria-expanded="false" aria-controls="collapseDocumentos" id="toggleDocumentos">

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
                    <div class="scrollbar-overlay" style="height: 500px;">
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
            <?php endif ?>
        </div>
    </div>
</li>