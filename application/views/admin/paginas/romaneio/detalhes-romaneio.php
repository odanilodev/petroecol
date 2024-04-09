<div class="content">
    <div id="members" data-list='{"valueNames":["customer","email","mobile_number","city","last_active","joined"],"page":10,"pagination":true}'>

        <?php if (!empty($romaneio)) { ?>
            
            <div class="mb-4">

                <h5>Romaneio: <?= $romaneio[0]['cod_romaneio'] ?> Motorista:  <?= $romaneio[0]['nome_responsavel'] ?> </h5>
            </div>
            <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
                <div class="table-responsive scrollbar ms-n1 ps-1">
                    <table class="table table-lg mb-0 table-hover text-center">
                        <thead>
                            <tr>

                                <th class="sort align-middle">Cliente</th>
                                <th class="sort align-middle">Residuos</th>
                                <th class="sort align-middle">Pago</th>
                                <th class="sort align-middle p-3">Obs</th>
                                <th class="sort align-middle p-3">Coletado</th>
                            </tr>
                        </thead>

                        <tbody class="list" id="members-table-body">

                            <?php 
                                $total_residuo = []; 
                                $total_pagamento = []; 
                            ?>

                            <?php foreach ($romaneio as $v) { ?>

                            <?php 
                                $residuos_coletados = json_decode($v['residuos_coletados']);
                                $quantidade_coletada = json_decode($v['quantidade_coletada']);
                                $forma_pagamento = json_decode($v['forma_pagamento']);
                                $valor_pago = json_decode($v['valor_pago']);
                            ?>

                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                    <td class="email align-middle white-space-nowrap">
                                      <?= $v['nome_cliente']; ?>
                                    </td>

                                    <td class="mobile_number align-middle white-space-nowrap">
                                        <?php 
                                        if ($residuos_coletados && $quantidade_coletada) {

                                            foreach($residuos_coletados as $key => $idResiduos){
    
                                                if(isset($total_residuo[$idResiduos])){ // ja exite (soma)
                                                    $total_residuo[$idResiduos] += $quantidade_coletada[$key];
                                                }else{
                                                    $total_residuo[$idResiduos] = $quantidade_coletada[$key];
                                                }
                                               
                                                echo "<p>$quantidade_coletada[$key] ($residuos[$idResiduos])</p>";
                                            } 
                                        }

                                        ?>
                                    </td>


                                    <td class="mobile_number align-middle white-space-nowrap">
                                        <?php 

                                        if ($forma_pagamento) {
                                            
                                            foreach($forma_pagamento as $key => $idPagamento){

                                                if (isset($total_pagamento[$idPagamento])) {
                                                    $total_pagamento[$idPagamento] += $valor_pago[$key] ?? 0;
                                                } else {
                                                    $total_pagamento[$idPagamento] = $valor_pago[$key] ?? 0;
                                                }

                                                if (isset($valor_pago[$key]) && isset($formasPagamento[$idPagamento])) {

                                                    echo "<p>$valor_pago[$key] ($formasPagamento[$idPagamento])</p>";
                                                } else {
                                                    echo "<p>--</p>";
                                                }
                                            } 
                                        }
                                        ?>
                                    </td>

                                    <td class="align-middle white-space-nowrap">
                                        <?= !empty(trim($v['observacao'])) ? $v['observacao'] : "--" ?>
                                    </td>

                                    <td class="align-middle white-space-nowrap">
                                        <?= $v['coletado'] ? 'Sim' : 'Não' ?>
                                    </td>

                                </tr>

                            <?php } ?>
                            <tr>

                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="sort align-middle p-3">Total de Residuos</th>
                                <th class="sort align-middle p-3">Total pago</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>

                                    <?php foreach($total_residuo as $key => $v) { 
                                        
                                        if (isset($residuos[$key])) {

                                            echo "<p>$v $residuos[$key]";
                                        }
                                    }?>
                                </td>

                                <td>

                                    <?php foreach($total_pagamento as $key => $v) { 
                                        
                                        if (isset($formasPagamento[$key])) {

                                            echo "<p>$v $formasPagamento[$key]";
                                        } else {
                                            echo "--";
                                        }
                                    }?>
                                </td>

                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>

        <?php } ?>
    </div>
