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

                                            foreach($residuos_coletados as $key => $idResiduos){

                                                if(isset($total_residuo[$idResiduos])){ // ja exite (soma)
                                                    $total_residuo[$idResiduos] += $quantidade_coletada[$key];
                                                }else{
                                                    $total_residuo[$idResiduos] = $quantidade_coletada[$key];
                                                }
                                               
                                                echo "<p>$quantidade_coletada[$key] ($residuos[$idResiduos])</p>";
                                            } 
                                        ?>
                                    </td>


                                    <td class="mobile_number align-middle white-space-nowrap">
                                        <?php 
                                            foreach($forma_pagamento as $key => $idPagamento){

                                                if (isset($total_pagamento[$idPagamento])) {
                                                    $total_pagamento[$idPagamento] += $valor_pago[$key];
                                                } else {
                                                    $total_pagamento[$idPagamento] = $valor_pago[$key];
                                                }

                                                echo "<p>$valor_pago[$key] ($formasPagamento[$idPagamento])</p>";
                                            } 
                                        ?>
                                    </td>

                                    <td class="align-middle white-space-nowrap">
                                        teste
                                    </td>

                                    <td class="align-middle white-space-nowrap">
                                       teste2
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
                                        
                                        echo "<p>$v $residuos[$key]";
                                    }?>
                                </td>

                                <td>

                                    <?php foreach($total_pagamento as $key => $v) { 
                                        
                                        echo "<p>$v $formasPagamento[$key]";
                                    }?>
                                </td>

                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>

        <?php } ?>
    </div>

    <!-- Modal Romaneio-->
    <div class="modal fade" id="modalConcluirRomaneio" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollabe">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <div class="modal-body">


                    <div class="row">

                    

                        <div class="accordion dados-clientes-div" id="accordionExample">

                            <!-- Manipulado JS -->
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <div class="spinner-border text-primary load-form d-none load-form-modal-romaneio" role="status"></div>
                    <button type="button" class="btn btn-primary btn-finaliza-romaneio" onclick="finalizarRomaneio()">Finalizar Romaneio</button>
                    <input type="hidden" class="id_responsavel">
                    <input type="hidden" class="code_romaneio">
                    <input type="hidden" class="data_romaneio">
                    <input type="hidden" class="input-id-setor-empresa">

                </div>
            </div>
        </div>
    </div>