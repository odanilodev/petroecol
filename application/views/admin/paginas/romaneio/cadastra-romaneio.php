<!-- REMOVER ESSE STYLE FOI SÓ PRA TESTES -->
<style>
    .gradient-border {
        border: 1px solid transparent;
        /* Borda mais fina e transparente */
        padding: 10px;
        /* Ajuste conforme necessário */
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        /* Sombreado mais suave */
    }
</style>

<div class="content">
<h5>Apenas a data de agendamento é obrigatória <br>Deixar layout clean e tirar o style da view<br><br></h5>
    <div id="members">
        <div class="row">
            <div class="col-md-4 col-6 gradient-border">
                <h5>Etiquetas</h5>
                <?php foreach ($etiquetas as $v) { ?>
                    <div class="form-check mb-0">
                        <?= $v['nome'] ?> <input class="form-check-input" value="<?= $v['id'] ?>" type="checkbox">
                    </div>
                <?php } ?>
            </div>

            <div class="col-md-4 col-6 gradient-border">
                <h5>Cidades</h5>
                <?php foreach ($cidades as $v) { ?>
                    <div class="form-check mb-0">
                        <?= $v['cidade'] ?> <input class="form-check-input" value="<?= $v['cidade'] ?>" type="checkbox">
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-6 gradient-border">
                <input class="form-control datetimepicker" required name="data_coleta" type="text" placeholder="Data Agendamento" data-options='{"disableMobile":true,"allowInput":true}' />
            </div>

            <div class="col-md-4 col-6 gradient-border">
                <button class="btn px-3 btn-phoenix-secondary" onclick="alert('Usar a rota filtrarClientesRomaneio para exibir os dados no modal')" data-bs-toggle="modal" data-bs-target="#modalRomaneio" type="submit">
                    Buscar Clientes <span class="fa-solid fa-filter text-primary" data-fa-transform="down-3"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Romaneio-->
    <div class="modal fade" id="modalRomaneio" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gerar um Romaneio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive scrollbar ms-n1 ps-1">
                        <table class="table table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="align-middle" scope="col">Cliente</th>
                                    <th class="sort pe-3">Etiqueta/Cidade</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="list" id="members-table-body">
                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                    <!-- Cliente -->
                                    <td class="align-middle white-space-nowrap">
                                        Danilo Gonçalves de Oliveira
                                    </td>
                                    <td class="align-middle white-space-nowrap">
                                        Zona Sul Teste 123 / Bauru das teste 123
                                    </td>
                                    <td class="align-middle white-space-nowrap pt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" checked name="clientes" type="checkbox" value="">
                                        </div>
                                    </td>
                                </tr>

                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                    <!-- Cliente -->
                                    <td class="align-middle white-space-nowrap">
                                        Danilo
                                    </td>
                                    <td class="align-middle white-space-nowrap">
                                        Zona Sul Teste 123
                                    </td>
                                    <td class="align-middle white-space-nowrap pt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" checked name="clientes" type="checkbox" value="">
                                        </div>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                        <i onclick="alert('Criar uma busca para inserir nova linha de cliente')" class="fas fa-plus-square mt-2"></i>
                    </div>

                </div>
                <div class="modal-footer">

                    <select class="form-select w-50 campo-obrigatorio" id="select-motorista">
                        <option selected disabled value="">Selecione o motorista</option>
                        <option value="1">Alexandre Mariano</option>
                        <option value="2">Joao Pedro</option>
                        <option value="3">Glayltton Luiz</option>
                        <option value="4">Cristyan rafael</option>
                    </select>

                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button type="button" class="btn btn-primary btn-salva-romaneio" onclick="alert('Enviar via json para rota gerarRomaneioEtiqueta, lembrando que precisa ter uma regra de pelo menos um cliente selecionado e precisa ter motorista e data de agendamento obrigatório')">Gerar Romaneio</button>
                </div>
            </div>
        </div>
    </div>