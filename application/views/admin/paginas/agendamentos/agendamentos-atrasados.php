<div class="content">
  <div class="pb-5">
    <div class="row g-4">
      <div class="col-12 col-xxl-12">
        <div class="row align-items-center g-4">
          <div class="col-12 col-md-3">
            <div class="d-flex align-items-center">
              <span class="fa-stack" style="min-height: 46px; min-width: 46px;">
                <span class="fa-solid fa-square fa-stack-2x text-danger-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100" data-fa-transform="up-4 right-3 grow-2"></span>
                <span class="fa-stack-1x fa-solid fas fa-calendar-alt text-danger" data-fa-transform="shrink-2 up-8 right-6"></span>
              </span>

              <div class="ms-3">
                <h4 class="mb-0"><span class="total-clientes-atrasados"><?= count($agendamentosAtrasados); ?></span></h4>
                <span class="text-800 fs--1 mb-0">Clientes atrasados <?= !$dataInicio ? 'nos últimos 30 dias' : 'no período do filtro aplicado' ?></span>
              </div>
            </div>
          </div>
        </div>
        <hr class="bg-200 mb-6 mt-3" />
      </div>

      <div class="col-12 col-xxl-12 mt-0">
        <form id="filtroForm" action="<?= base_url('agendamentos/agendamentosAtrasados') ?>" method="post">
          <div class="col-12">
            <div class="row align-items-center g-4">
              <h4 class="ms-3">Filtrar resultados</h4>

              <div class="col-12 col-md-3">
                <div class="ms-3">
                  <input required class="form-control datetimepicker mascara-data" value="<?= isset($dataInicio) ? $dataInicio : '' ?>" name="data_inicio" id="data_inicio" type="text" placeholder="Selecione a data de início" data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                </div>
              </div>

              <div class="col-12 col-md-3">
                <div class="ms-3">
                  <input required class="form-control datetimepicker mascara-data" value="<?= isset($dataFim) ? $dataFim : '' ?>" name="data_fim" id="data_fim" type="text" placeholder="Selecione a data final" data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                </div>
              </div>

              <div class="col-12 col-md-2">
                <div class="ms-3">
                  <select class="form-control select-validation select-setor" required name="setor" id="setor">
                    <option selected disabled value="">Setor da conta</option>
                    <option <?= $idSetor == 'todos' ? 'selected' : '' ?> value="todos">Todos</option>
                    <?php foreach ($setoresEmpresa as $setor) { ?>
                      <option <?= $idSetor == $setor['id'] ? 'selected' : '' ?> value="<?= $setor['id'] ?>"><?= $setor['nome'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="col-12 col-md-2">
                <div class="ms-3">
                  <select class="form-control select-validation select-cidade select2" required name="cidadeFiltro" id="cidadeFiltro">
                    <option selected disabled value="">Cidade Agendamento</option>
                    <option <?= $cidadeFiltro == 'todas' ? 'selected' : '' ?> value="todas">Todos</option>
                    <?php foreach ($cidades as $cidade) { ?>
                      <option <?= isset($cidadeFiltro) && $cidadeFiltro == $cidade['cidade'] ? 'selected' : '' ?> value="<?= $cidade['cidade'] ?>"><?= mb_convert_case($cidade['cidade'], MB_CASE_TITLE, "UTF-8") ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <input type="hidden" name="nomeSetor" id="nomeSetor">

              <div class="col-12 col-md-2">
                <div class="d-flex ms-3">
                  <button type="submit" class="btn btn-phoenix-secondary bg-white hover-bg-100 me-2 <?= !$dataInicio ? 'w-100' : 'w-60'; ?>">Filtrar</button>
                  <?php if (isset($dataInicio)) { ?>
                    <a href="<?= base_url('agendamentos/agendamentosAtrasados'); ?>" class="btn btn-phoenix-danger w-25" title="Limpar Filtro"><i class="fas fa-ban"></i></a>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
    <div id="members" data-list='{"valueNames":["td_data_agendamento","td_nome_cliente","td_setor","td_cidade","td_telefone"],"page":20,"pagination":true}'>
      <div class="row align-items-end justify-content-between pb-5 g-3">
        <div class="col-auto">
          <div class="d-flex align-items-center">
            <h3 class="me-3">Agendamentos Atrasados</h3>
            <button class="d-none btn btn-phoenix-info btn-gerar-romaneio-atrasado" onclick="" data-bs-toggle="modal" data-bs-target="#modalRomaneiosAtrasados">
              <i class="fas fa-clipboard-list me-2"></i>Gerar Romaneio
            </button>
          </div>
        </div>
        <div class="col-12 col-md-auto">
          <div class="row g-2 gy-3">
            <div class="col-auto flex-1">
              <div class="search-box">
                <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                  <input class="form-control search-input search form-control-sm" type="search" placeholder="Buscar" aria-label="Search" />
                  <span class="fas fa-search search-box-icon"></span>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive mx-n1 px-1 scrollbar">
        <table class="table fs--1 mb-0 border-top border-200">
          <tr>
            <thead>
              <th class="white-space-nowrap fs--1 ps-0 align-middle">
                <div class="form-check mb-0 fs-0">
                  <input class="form-check-input check-all-element-agendamentos cursor-pointer" id="checkbox-bulk-reviews-select" type="checkbox" />
                </div>
              </th>
              <th class="align-middle text-center" scope="col" data-sort="td_data_agendamento">Data Agendamento</th>
              <th class="align-middle text-center" scope="col" data-sort="td_nome_cliente">Cliente</th>
              <th class="align-middle text-center" scope="col" data-sort="td_setor">Setor</th>
              <th class="align-middle text-center" scope="col" data-sort="td_cidade">Cidade</th>
              <th class="align-middle text-center" scope="col" data-sort="td_telefone">Telefone</th>
              <th class="text-end pe-0 align-middle text-center" scope="col"></th>
          </tr>
          </thead>
          <tbody class="list" id="table-latest-review-body">
            <?php foreach ($agendamentosAtrasados as $agendamentoAtrasado) { ?>
              <tr class="hover-actions-trigger btn-reveal-trigger position-static tr-pagamento">
                <td class="fs--1 align-middle ps-0">
                  <div class="form-check mb-0 fs-0">
                    <input class="form-check-input check-element-agendamentos cursor-pointer" data-id-cliente="<?= $agendamentoAtrasado['id_cliente'] ?>" type="checkbox" value="<?= $agendamentoAtrasado['id_cliente'] ?>|<?= $agendamentoAtrasado['id_setor_empresa'] ?>" />

                  </div>
                </td>
                <td class="align-middle td_data_agendamento text-center">
                  <h6 class="mb-0 text-900 data-antiga"><?= date('d/m/Y', strtotime($agendamentoAtrasado['data_coleta'])) ?></h6>
                </td>
                <td class="align-middle td_nome_cliente text-center">
                  <h6 class="mb-0 text-900"><?= $agendamentoAtrasado['NOME_CLIENTE'] ?></h6>
                </td>
                <td class="align-middle td_setor text-center">
                  <h6 class="mb-0 text-900"><?= $agendamentoAtrasado['NOME_SETOR'] ?></h6>
                </td>
                <td class="align-middle td_cidade text-center">
                  <h6 class="mb-0 text-900"><?= mb_convert_case($agendamentoAtrasado['cidade'], MB_CASE_TITLE, "UTF-8") ?></h6>
                </td>
                <td class="align-middle td_observacao text-center">
                  <h6 class="mb-0 text-900"><?= $agendamentoAtrasado['telefone'] ?></h6>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>


      <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
        <div class="col-auto d-none">
          <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">Ver todos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">Ver menos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
        </div>
        <div class="col-auto d-flex w-100 justify-content-end mt-2 mb-2">
          <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
          <ul class="mb-0 pagination"></ul>
          <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal gerar romaneio de atrasados -->
  <div class="modal fade" id="modalRomaneiosAtrasados" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Gerar um Romaneio</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body row form-agendamento-atrasado">

          <div class="col-md-12 mb-2">
            <label>Data para o Romaneio</label>
            <input class="form-control datetimepicker input-obrigatorio input-data-agendamento" required name="data_agendamento" type="text" placeholder="Data Romaneio" data-options='{"disableMobile":true,"allowInput":true,"dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
          </div>

          <div class="col-12 mt-2">
            <select class="form-select w-100 input-obrigatorio select2" id="select-responsavel">
              <option selected disabled value="">Selecione o responsável</option>
              <?php
              foreach ($responsaveis as $v) { ?>
                <option value="<?= $v['IDFUNCIONARIO'] ?>"> <?= $v['nome'] ?> | <?= $v['CARGO'] ?></option>
              <?php }  ?>
            </select>
            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
          </div>

          <div class="col-12 mt-2">
            <select class="form-select w-100 input-obrigatorio select2" id="select-veiculo">
              <option selected disabled value="">Selecione o veículo</option>
              <?php
              foreach ($veiculos as $veiculo) { ?>
                <option value="<?= $veiculo['id'] ?>"> <?= $veiculo['modelo'] ?> | <?= strtoupper($veiculo['placa']) ?></option>
              <?php }  ?>
            </select>
            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
          </div>

        </div>

        <div class="modal-footer">
          <div class="spinner-border text-primary load-form d-none load-form-modal-romaneio" role="status"></div>
          <button type="button" class="btn btn-primary btn-salva-romaneio btn-form" onclick="gerarRomaneioAtrasados()">Gerar Romaneio</button>
        </div>

      </div>
    </div>
  </div>