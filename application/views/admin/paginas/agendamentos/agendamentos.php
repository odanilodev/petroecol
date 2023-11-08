<div class="content">
  <div class="row g-0 mb-4 align-items-center">
    <div class="col-5 col-md-6">
      <h4 class="mb-0 text-1100 fw-bold fs-md-2">
        <span class="calendar-day d-block d-md-inline mb-1"></span>
        <span class="px-3 fw-thin text-400 d-none d-md-inline">|</span>
        <span class="calendar-date"></span>
      </h4>
    </div>
    <div class="col-7 col-md-6 d-flex justify-content-end">
      <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addEventModal"> <span class="fas fa-plus pe-2 fs--2"></span>Add new task </button>
    </div>
  </div>
  <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 border-y border-200">
    <div class="row py-3 gy-3 gx-0">
      <div class="col-6 col-md-4 order-1 d-flex align-items-center">
        <button class="btn btn-sm btn-phoenix-primary px-4" data-event="today">Hoje</button>
      </div>
      <div class="col-12 col-md-4 order-md-1 d-flex align-items-center justify-content-center">
        <button class="btn icon-item icon-item-sm shadow-none text-1100 p-0" type="button" data-event="prev" title="Previous"><span class="fas fa-chevron-left"></span></button>
        <h3 class="px-3 text-1100 fw-semi-bold calendar-title mb-0"> </h3>
        <button class="btn icon-item icon-item-sm shadow-none text-1100 p-0" type="button" data-event="next" title="Next"><span class="fas fa-chevron-right"></span></button>
      </div>

    </div>
  </div>

  <div class="calendar-outline mt-6 mb-9" id="appCalendar"></div>




  <div class="modal fade" id="addEventModal" data-bs-focus="false">
    <div class="modal-dialog">
      <div class="modal-content border">
        <form id="addEventForm" autocomplete="off">
          <div class="modal-header px-card border-0">
            <div class="w-100 d-flex justify-content-between align-items-start">
              <div>
                <h5 class="mb-0 lh-sm text-1000">Novo Agendamento</h5>
              </div>
              <span class="btn p-1 fs-2 text-900" type="button" data-bs-dismiss="modal" aria-label="Close">&times;</span>
            </div>
          </div>
          <div class="modal-body p-card py-0">

            <div class="mb-3">

              <select class="form-select w-100 cliente-agendamento" id="select-cliente" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}'>

                <option disabled selected value="">Selecione o Cliente</option>
                <?php foreach ($clientes as $v) { ?>
                  <option value="<?= $v['id'] ?>"><?= strtoupper($v['nome']); ?></option>
                <?php } ?>

              </select>

            </div>

            <div class="flatpickr-input-container mb-3">

              <div class="form-floating">
                <input class="form-control datetimepicker data-agendamento" id="eventStartDate" type="text" name="startDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"dateFormat":"Y-m-d"}' /><span class="uil uil-calendar-alt flatpickr-icon text-700"></span>
                <label class="ps-6" for="eventStartDate">Data de Coleta</label>
              </div>

            </div>

            <div class="flatpickr-input-container mb-3">

              <div class="form-floating">
                <input class="form-control datetimepicker horario-agendamento" id="timepicker1" type="text" name="startDate" placeholder="hh:mm" data-options='{"enableTime":true,"noCalendar":true,"disableMobile":true,"dateFormat":"H:i"}' />
                <span class="uil uil-clock flatpickr-icon text-700"></span>
                <label class="ps-6" for="timepicker1">Horário</label>
              </div>

            </div>

            <div class="form-floating my-5">
              <textarea class="form-control obs-agendamento" id="eventDescription" placeholder="Leave a comment here" name="observacao" style="height: 128px"></textarea>
              <label for="eventDescription">Observação</label>
            </div>
          </div>

          <div class="modal-footer d-flex justify-content-between align-items-center border-0">

            <!-- <button class="btn btn-primary px-4" type="submit">Save</button> -->
            <button class="btn btn-primary px-4 btn-envia" type="button" onclick="salvaAgendamento()">Salvar</button>
            <div class="spinner-border text-primary load-form d-none" role="status"></div>
          </div>

        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="eventDetailsModal" data-bs-focus="false">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <table class="table table-hover tabela-clientes-agendados">
          <thead>
            <tr>
              <th scope="col">Cliente</th>
              <th scope="col">Endereço</th>
              <th scope="col">Telefone</th>
              <th scope="col">Data</th>
              <th scope="col">Mais detalhes</th>
            </tr>
          </thead>
          <tbody class="clientes-agendados text-start">

            <td>

              <label class="form-label" for="datetimepicker">Start Date</label>
              <input class="form-control datetimepicker flatpickr-input" id="datetimepicker" type="text" placeholder="dd/mm/yyyy hour : minute" data-options="{&quot;enableTime&quot;:true,&quot;dateFormat&quot;:&quot;d/m/y H:i&quot;,&quot;disableMobile&quot;:true}" readonly="readonly">


            </td>


          </tbody>
        </table>
      </div>
    </div>
  </div>