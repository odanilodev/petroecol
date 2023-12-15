var baseUrl = $('.base-url').val();

var dataAtual = new Date();
var mes = (dataAtual.getMonth() + 1).toString().padStart(2, '0'); // Adiciona um zero à esquerda, se necessário
var dia = dataAtual.getDate().toString().padStart(2, '0'); // Adiciona um zero à esquerda, se necessário
var ano = dataAtual.getFullYear();
var dataAtualFormatada = ano + '-' + mes + '-' + dia;

const { dayjs } = window;
const currentDay = dayjs && dayjs().format('DD');
const currentMonth = dayjs && dayjs().format('MM');
const prevMonth = dayjs && dayjs().subtract(1, 'month').format('MM');
const nextMonth = dayjs && dayjs().add(1, 'month').format('MM');
const currentYear = dayjs && dayjs().format('YYYY');

var events = []; // inicia vazio e é alimentado na função abaixo
exibirAgendamentos(currentYear, currentMonth); // exibe os agendamentos no calendario

(function (factory) {
  typeof define === 'function' && define.amd ? define(factory) :
    factory();
})((function () {
  'use strict';

  /* -------------------------------------------------------------------------- */

  const camelize = str => {
    const text = str.replace(/[-_\s.]+(.)?/g, (_, c) =>
      c ? c.toUpperCase() : ''
    );
    return `${text.substr(0, 1).toLowerCase()}${text.substr(1)}`;
  };

  const getData = (el, data) => {
    try {
      return JSON.parse(el.dataset[camelize(data)]);
    } catch (e) {
      return el.dataset[camelize(data)];
    }
  };

  /* -------------------------------------------------------------------------- */
  /*                                   Calendar                                 */

  /* -------------------------------------------------------------------------- */
  const renderCalendar = (el, option) => {
    const { merge } = window._;

    const options = merge(
      {
        initialView: 'dayGridMonth',
        editable: true,
        direction: document.querySelector('html').getAttribute('dir'),
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
          month: 'Month',
          week: 'Week',
          day: 'Day'
        }
      },
      option
    );
    const calendar = new window.FullCalendar.Calendar(el, options);
    calendar.render();
    document
      .querySelector('.navbar-vertical-toggle')
      ?.addEventListener('navbar.vertical.toggle', () => calendar.updateSize());
    return calendar;
  };

  const fullCalendarInit = () => {
    const { getData } = window.phoenix.utils;

    const calendars = document.querySelectorAll('[data-calendar]');
    calendars.forEach(item => {
      const options = getData(item, 'calendar');
      renderCalendar(item, options);
    });
  };

  const fullCalendar = {
    renderCalendar,
    fullCalendarInit
  };


  const getTemplate = event => `
      <div class="modal-header ps-card border-bottom">
        <div>
          <h4 class="modal-title text-1000 mb-0">${event.title}</h4>
        </div>

        <button type="button" class="btn p-1 fw-bolder" data-bs-dismiss="modal" aria-label="Close">
          <span class='fas fa-times fs-0'></span>
        </button>
  
      </div>
  
      <div class="modal-body">
        <div class="container">
          <div class="row table-responsive" align="center">
            <table class="table tabela-clientes-agendados">
              <thead>
                <tr>
                  <th scope="col">Cliente</th>
                  <th scope="col">Endereço</th>
                  <th scope="col">Telefone</th>
                  <th scope="col">Data</th>
                  <th scope="col">Hora</th>
                  <th scope="col">Período</th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody class="clientes-agendados text-start">
                
                
              </tbody>
            </table>
          
          </div>
          <div class="spinner-border text-primary load-form" role="status"></div>

        </div>            
      </div>
  
    `;

  /*-----------------------------------------------
  |   Calendar
  -----------------------------------------------*/
  const monthTranslations = {
    'January': 'Janeiro',
    'February': 'Fevereiro',
    'March': 'Março',
    'April': 'Abril',
    'May': 'Maio',
    'June': 'Junho',
    'July': 'Julho',
    'August': 'Agosto',
    'September': 'Setembro',
    'October': 'Outubro',
    'November': 'Novembro',
    'December': 'Dezembro'
  };

  const appCalendarInit = () => {
    const Selectors = {
      ACTIVE: '.active',
      ADD_EVENT_FORM: '#addEventForm',
      ADD_EVENT_MODAL: '#addEventModal',
      CALENDAR: '#appCalendar',
      CALENDAR_TITLE: '.calendar-title',
      CALENDAR_DAY: '.calendar-day',
      CALENDAR_DATE: '.calendar-date',
      DATA_CALENDAR_VIEW: '[data-fc-view]',
      DATA_EVENT: 'data-event',
      DATA_VIEW_TITLE: '[data-view-title]',
      EVENT_DETAILS_MODAL: '#eventDetailsModal',
      EVENT_DETAILS_MODAL_CONTENT: '#eventDetailsModal .modal-content',
      EVENT_START_DATE: '#addEventModal [name="startDate"]',
      INPUT_TITLE: '[name="title"]'
    };

    const Events = {
      CLICK: 'click',
      SHOWN_BS_MODAL: 'shown.bs.modal',
      SUBMIT: 'submit'
    };

    const DataKeys = {
      EVENT: 'event',
      FC_VIEW: 'fc-view'
    };

    const eventList = events.reduce(
      (acc, val) =>
        val.schedules ? acc.concat(val.schedules.concat(val)) : acc.concat(val),
      []
    );

    const setCurrentDate = () => {
      const dateObj = new Date();
      const dayNames = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
      const monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

      const day = dateObj.getDay(); // Retorna o número do dia da semana (0 = Domingo, 1 = Segunda, etc.)
      const date = dateObj.getDate(); // Retorna o número do dia do mês
      const month = dateObj.getMonth(); // Retorna o número do mês (0 = Janeiro, 1 = Fevereiro, etc.)
      const year = dateObj.getFullYear();

      const newDate = `${date} de ${monthNames[month]} de ${year}`;

      if (document.querySelector(Selectors.CALENDAR_DAY)) {
        document.querySelector(Selectors.CALENDAR_DAY).textContent = dayNames[day];
      }
      if (document.querySelector(Selectors.CALENDAR_DATE)) {
        document.querySelector(Selectors.CALENDAR_DATE).textContent = newDate;
      }
    };

    setCurrentDate();

    const updateTitle = currentData => {

      const { currentViewType } = currentData;

      // Função para traduzir o mês
      const translateMonth = (date) => {
        const monthName = date.toLocaleString('en-US', { month: 'long' });
        return monthTranslations[monthName] || monthName;
      };

      if (currentViewType === 'timeGridWeek') {
        const weekStartsDate = currentData.dateProfile.currentRange.start;
        const startingMonth = translateMonth(weekStartsDate);
        const startingDate = weekStartsDate.getDate();
        const weekEndDate = currentData.dateProfile.currentRange.end;
        const endingMonth = translateMonth(weekEndDate);
        const endingDate = weekEndDate.getDate();

        document.querySelector(
          Selectors.CALENDAR_TITLE
        ).textContent = `${startingDate} de ${startingMonth} - ${endingMonth} ${endingDate}`;

      } else {
        // Se você deseja traduzir o mês em currentData.viewTitle e exibir o ano
        const viewTitleDate = new Date(currentData.viewTitle);
        const translatedMonth = translateMonth(viewTitleDate);
        const year = viewTitleDate.getFullYear();
        document.querySelector(Selectors.CALENDAR_TITLE).textContent = `${translatedMonth} ${year}`;
      }
    };

    const appCalendar = document.querySelector(Selectors.CALENDAR);
    const addEventForm = document.querySelector(Selectors.ADD_EVENT_FORM);
    const addEventModal = document.querySelector(Selectors.ADD_EVENT_MODAL);
    const eventDetailsModal = document.querySelector(
      Selectors.EVENT_DETAILS_MODAL
    );

    if (appCalendar) {
      const calendar = fullCalendar.renderCalendar(appCalendar, {
        headerToolbar: false,
        dayMaxEvents: 3,
        height: 800,
        stickyHeaderDates: false,
        views: {
          week: {
            eventLimit: 3
          }
        },
        eventTimeFormat: {
          hour: 'numeric',
          minute: '2-digit',
          omitZeroMinute: true,
          meridiem: true
        },
        events: eventList,
        eventClick: info => {
          if (info.event.url) {
            window.open(info.event.url, '_blank');
            info.jsEvent.preventDefault();
          } else {
            const template = getTemplate(info.event);
            document.querySelector(
              Selectors.EVENT_DETAILS_MODAL_CONTENT
            ).innerHTML = template;
            const modal = new window.bootstrap.Modal(eventDetailsModal);
            modal.show();
          }
        },
        dateClick(info) {
          const modal = new window.bootstrap.Modal(addEventModal);
          modal.show();
          /* eslint-disable-next-line */
          const flatpickr = document.querySelector(Selectors.EVENT_START_DATE)._flatpickr;
          flatpickr.setDate([info.dateStr]);
        }
      });

      // adiciona um novo agendamento
      const salvaAgendamento = (cliente, data, horario, periodo, obs, id) => {

        let dataNova = data;

        let permissao = true;

        if (!cliente || !data) {
          permissao = false;

          avisoRetorno('Algo deu errado', 'Preencha os campos obrigatórios', 'error', '#');
          return;
        }

        if (permissao) {

          let dataClicada = dataNova.split('-');
          let ano = dataClicada[0];
          let mes = dataClicada[1];

          calendar.removeAllEvents(); // remove todos agendamentos
          events = [];

          $.ajax({
            type: "post",
            url: `${baseUrl}agendamentos/cadastraAgendamento`,
            data: {
              cliente: cliente,
              data: dataNova,
              horario: horario,
              periodo: periodo,
              obs: obs,
              id: id
            },
            beforeSend: function () {
              $('.load-form').removeClass('d-none');
              $('.btn-envia').addClass('d-none');
            },
            success: function (data) {

              $('.periodo-agendamento').val('');

              $('.load-form').addClass('d-none');
              $('.btn-envia').removeClass('d-none');

              if (!data.success) {

                avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

              } else {

                let dataAntiga = $('.agendamento-' + id).data('data');

                $('#addEventModal').modal('hide');

                if (id && dataAntiga != dataNova) {
                  $('.agendamento-' + id).remove();
                }

                $('.salva-modal-' + cliente).addClass('d-none');
                $('.detalhes-modal-' + cliente).removeClass('d-none');

              }

              var atualizaAgenda = exibirAgendamentos(ano, mes);
              calendar.addEventSource(atualizaAgenda); // adiciona os novos agendamentos

            }
          });
        }
      }

      $(document).on('click', '.btn-salva-agendamento', function () {

        let cliente = $('.cliente-agendamento').val();
        let data = $('.data-agendamento').val();
        let horario = $('.horario-agendamento').val();
        let periodo = $('.periodo-agendamento').val();
        let obs = $('.obs-agendamento').val();

        let id = $('.input-id').val();

        salvaAgendamento(cliente, data, horario, periodo, obs, id);

      })


      $(document).on('change', '.data-modal', function () {

        changeValuesModal('.data-modal', 'data');

      })

      $(document).on('change', '.hora-modal', function () {

        changeValuesModal('.hora-modal', 'hora');

      })

      $(document).on('change', '.periodo-modal', function () {

        changeValuesModal('.periodo-modal', 'periodo');

      })


      function changeValuesModal(classe, atributo) {

        let momentoColeta = $(classe).data(atributo); // data ou hora ou periodo atual

        let idCliente = $(classe).data('id');
        let obs = $(classe).data('obs');
        let idAgendamento = $(classe).data('agendamento');

        let data = $(`.data-modal-${idCliente}`).val().split('/');
        let dataFormatada = `${data[2]}-${data[1]}-${data[0]}`;

        if (momentoColeta != $(classe).val()) {

          $(`.detalhes-modal-${idCliente}`).addClass('d-none');
          $(`.salva-modal-${idCliente}`).removeClass('d-none');
          $(`.salva-modal-${idCliente}`).attr('data-cliente', idCliente);
          $(`.salva-modal-${idCliente}`).attr('data-hora', $('.hora-modal').val());
          $(`.salva-modal-${idCliente}`).attr('data-periodo', $('.periodo-modal').val());
          $(`.salva-modal-${idCliente}`).attr('data-obs', obs);
          $(`.salva-modal-${idCliente}`).attr('data-agendamento', idAgendamento);
          $(`.salva-modal-${idCliente}`).attr('data-data', dataFormatada);

        } else {

          $(`.detalhes-modal-${idCliente}`).removeClass('d-none');
          $(`.salva-modal-${idCliente}`).addClass('d-none');

        }


      }


      $(document).on('click', '.btn-salva-modal', function () {

        let idCliente = $(this).data('cliente');
        let dataNova = $(this).data('data');
        let periodoNovo = $(this).data('periodo');
        let horaNova = $(this).data('hora');
        let idAgendamento = $(this).data('agendamento');
        let obs = $(this).data('obs');

        salvaAgendamento(idCliente, dataNova, horaNova, periodoNovo, obs, idAgendamento);

      })


      // remove o cliente da data agendada
      const removeClienteAgendamento = (idAgendamento, mes, ano) => {

        calendar.removeAllEvents(); // remove todos agendamentos
        events = [];

        $('.agendamento-' + idAgendamento).remove();

        $.ajax({
          type: "POST",
          url: `${baseUrl}agendamentos/cancelaAgendamentoCliente`,
          data: {
            idAgendamento: idAgendamento
          }, success: function () {

            // Atualize os eventos no calendário
            var atualizaAgenda = exibirAgendamentos(ano, mes);
            calendar.addEventSource(atualizaAgenda); // adiciona os novos agendamentos
          }
        })
      }

      // clique para chamar a função que remove o cliente da data agendada
      $(document).on('click', '.remove-cliente-agendamento', function () {

        let idAgendamento = $(this).data('id');
        let mes = $(this).data('mes');
        let ano = $(this).data('ano');

        removeClienteAgendamento(idAgendamento, mes, ano);
      })


      updateTitle(calendar.currentData);

      document.addEventListener('click', e => {
        // handle prev and next button click
        if (
          e.target.hasAttribute(Selectors.DATA_EVENT) ||
          e.target.parentNode.hasAttribute(Selectors.DATA_EVENT)
        ) {
          const el = e.target.hasAttribute(Selectors.DATA_EVENT)
            ? e.target
            : e.target.parentNode;
          const type = getData(el, DataKeys.EVENT);

          switch (type) {

            case 'prev':

              calendar.prev();

              updateTitle(calendar.currentData);

              var ano = calendar.currentData.viewTitle.split(" ");

              var monthName = calendar.currentData.viewTitle;

              var date = new Date(monthName + " 1, 2023");

              var monthNumber = date.getMonth() + 1;

              var atualizaAgenda = exibirAgendamentos(ano[1], monthNumber);

              // Atualize os eventos no calendário
              calendar.removeAllEvents(); // remove todos agendamentos
              events = [];
              calendar.addEventSource(atualizaAgenda); // adiciona os novos agendamentos

              break;

            case 'next':

              calendar.next();

              updateTitle(calendar.currentData);

              var ano = calendar.currentData.viewTitle.split(" ");

              var monthName = calendar.currentData.viewTitle;

              var date = new Date(monthName + " 1, 2023");

              var monthNumber = date.getMonth() + 1;

              var atualizaAgenda = exibirAgendamentos(ano[1], monthNumber);

              // Atualize os eventos no calendário
              calendar.removeAllEvents(); // remove todos agendamentos
              events = [];
              calendar.addEventSource(atualizaAgenda); // adiciona os novos agendamentos

              break;
            case 'today':

              calendar.today();
              updateTitle(calendar.currentData);

              var ano = calendar.currentData.viewTitle.split(" ");

              var monthName = calendar.currentData.viewTitle;

              var date = new Date(monthName + " 1, 2023");

              var monthNumber = date.getMonth() + 1;

              var atualizaAgenda = exibirAgendamentos(ano[1], monthNumber);

              // Atualize os eventos no calendário
              calendar.removeAllEvents(); // remove todos agendamentos
              events = [];
              calendar.addEventSource(atualizaAgenda); // adiciona os novos agendamentos

              break;
            default:
              calendar.today();
              updateTitle(calendar.currentData);
              break;
          }
        }

        // handle fc-view
        if (e.target.hasAttribute('data-fc-view')) {
          const el = e.target;
          calendar.changeView(getData(el, DataKeys.FC_VIEW));
          updateTitle(calendar.currentData);
          document
            .querySelectorAll(Selectors.DATA_CALENDAR_VIEW)
            .forEach(item => {
              if (item === e.target) {
                item.classList.add('active-view');
              } else {
                item.classList.remove('active-view');
              }
            });
        }
      });

      if (addEventForm) {
        addEventForm.addEventListener(Events.SUBMIT, e => {
          e.preventDefault();
          const { title, startDate, endDate, label, description, allDay } =
            e.target;
          calendar.addEvent({
            title: title.value,
            start: startDate.value,
            end: endDate.value ? endDate.value : null,
            allDay: allDay.checked,
            className: `text-${label.value}`,
            description: description.value
          });
          e.target.reset();
          window.bootstrap.Modal.getInstance(addEventModal).hide();
        });
      }

      if (addEventModal) {
        addEventModal.addEventListener(
          Events.SHOWN_BS_MODAL,
          ({ currentTarget }) => {
            currentTarget.querySelector(Selectors.INPUT_TITLE)?.focus();
          }
        );
      }
    }
  };

  const { docReady } = window.phoenix.utils;

  docReady(appCalendarInit);

}));
//# sourceMappingURL=calendar.js.mapv

// busca os agendamentos feitos manuais (prioridades)
function exibirAgendamentosManuais(currentYear, currentMonth) {

  events = [];

  $.ajax({
    url: baseUrl + 'agendamentos/exibirAgendamentos',
    method: 'POST',
    async: false,
    data: {
      anoAtual: currentYear,
      mesAtual: currentMonth,
      prioridade: 1
    },
    success: function (data) {

      let jsonString = JSON.stringify(data.agendamentos);

      var obj = JSON.parse(jsonString);

      for (var i = 0; i < obj.length; i++) {

        let titulo = obj[i].data_coleta < dataAtualFormatada ? " Atrasado(s)" : " Prioridade(s)";

        let tipo = obj[i].data_coleta < dataAtualFormatada ? "text-danger" : 'text-warning';

        var event = {
          title: obj[i].total_agendamento + titulo,
          start: obj[i].data_coleta,
          className: `${tipo} agendamento dataClicada-${obj[i].data_coleta} prioridade`
        };

        events.push(event);

      }

    }


  });

  return events;

}


function exibirAgendamentos(currentYear, currentMonth) {

  exibirAgendamentosManuais(currentYear, currentMonth); // exibe os agendamentos manuais (prioridades) no calendario

  $.ajax({
    url: baseUrl + 'agendamentos/exibirAgendamentos',
    method: 'POST',
    async: false,
    data: {
      anoAtual: currentYear,
      mesAtual: currentMonth,
      prioridade: 0
    },
    success: function (data) {

      let jsonString = JSON.stringify(data.agendamentos);

      var obj = JSON.parse(jsonString);

      for (var i = 0; i < obj.length; i++) {

        let titulo = obj[i].data_coleta < dataAtualFormatada ? " Atrasado(s)" : " Agendado(s)";

        let tipo = obj[i].data_coleta < dataAtualFormatada ? "text-danger" : 'text-success';

        var event = {
          title: obj[i].total_agendamento + titulo,
          start: obj[i].data_coleta,
          className: `${tipo} agendamento dataClicada-${obj[i].data_coleta}`
        };

        events.push(event);

      }

    }


  });

  return events;

}


$(document).on('click', '.agendamento', function () {

  let classeClicada = $(this).attr("class").split(" ");
  let dataClicada = classeClicada.find(function (className) {
    return className.match(/\d{4}-\d{2}-\d{2}/);
  });

  let dataFormatada = dataClicada.replace("dataClicada-", "");
  $(this).addClass(dataFormatada);

  // se for prioridade, busca somente os clientes que são prioridade
  exibirClientesAgendados(dataFormatada, $(this).hasClass('prioridade'));

})

const exibirClientesAgendados = (dataColeta, prioridade) => {

  let prd = prioridade ? 1 : 0;

  $.ajax({
    url: baseUrl + 'agendamentos/recebeClientesAgendados',
    method: 'POST',
    data: {
      dataColeta: dataColeta,
      prioridade: prd
    },
    beforeSend: function () {

      $('.tabela-clientes-agendados').addClass('d-none');
      $('.load-form').removeClass('d-none');

    },
    success: function (data) {

      $('.tabela-clientes-agendados').removeClass('d-none');
      $('.load-form').addClass('d-none');

      var clientes = data.agendados;


      $.each(clientes, function (index, cliente) {

        var dataDividida = cliente.data_coleta.split('-');

        var dataFormatada = dataDividida[2] + '/' + dataDividida[1] + '/' + dataDividida[0];

        let clientesAgendados = `

          <tr class="agendamento-${cliente.id}" data-data="${cliente.data_coleta}">
            <td>${cliente.nome}</td>
            <td>${cliente.rua} ${cliente.numero}</td>
            <td>${cliente.telefone}</td>

            <td>
           
              <input class="form-control datetimepicker flatpickr-input data-modal data-modal-${cliente.id_cliente}" id="datepicker" type="text" placeholder="dd/mm/yyyy" data-options="{&quot;disableMobile&quot;:true,&quot;}" readonly="readonly" value="${dataFormatada}" data-data="${dataFormatada}" data-id="${cliente.id_cliente}"  data-agendamento="${cliente.id}" data-obs="${cliente.observacao}">
          
            </td>

            <td>
           
            <input class="form-control datetimepicker2 flatpickr-input hora-modal hora-modal-${cliente.id_cliente}" id="timepicker1" type="text" placeholder="hora : minuto" data-options="{&quot;noCalendar&quot;:true,&quot;dateFormat&quot;:&quot;H:i&quot;,&quot;disableMobile&quot;:true}" readonly="readonly" value="${cliente.hora_coleta}" data-id="${cliente.id_cliente}" data-hora="${cliente.hora_coleta}" data-agendamento="${cliente.id}" data-data="${dataFormatada}" data-obs="${cliente.observacao}">

        
            </td>

            <td>
           
              <select class="form-select w-100 periodo-modal periodo-modal-${cliente.id_cliente}" data-id="${cliente.id_cliente}" data-hora="${cliente.hora_coleta}" data-agendamento="${cliente.id}" data-data="${dataFormatada}" data-obs="${cliente.observacao}">

                <option disabled selected value="">Período de Coleta</option>

                <option ${cliente.periodo_coleta == "Manhã" ? "selected" : ""} value="Manhã">Manhã</option>
                <option ${cliente.periodo_coleta == "Tarde" ? "selected" : ""} value="Tarde">Tarde</option>
                <option ${cliente.periodo_coleta == "Noite" ? "selected" : ""} value="Noite">Noite</option>
                
              </select>

        
            </td>

            <td style="text-align: center">
              <a class="detalhes-modal-${cliente.id_cliente}" href="${baseUrl}clientes/detalhes/${cliente.id_cliente}" title="Mais detalhes">
                <span class="fas fa-eye fs-1"></span>
              </a>
              <a class="btn-salva-modal d-none text-success salva-modal-${cliente.id_cliente}" href="#" title="Salvar Agendamento">
                <span class="fas fa-check-circle fs-1"></span>
              </a>
            </td>

            <td>
              <a style="cursor: pointer" class="text-danger remove-cliente-agendamento" data-mes="${dataDividida[1]}" data-ano="${dataDividida[0]}" data-id="${cliente.id}" title="Cancelar agendamento">
                <span class="fas fa-times fs-1 ml-5"></span>
              </a>
            </td>
            
            
          </tr>
          
        `;

        $('.clientes-agendados').append(clientesAgendados);

        $("#eventDetailsModal").find('.datetimepicker').flatpickr({
          dateFormat: "d/m/Y",
          disableMobile: true
        });

        $("#eventDetailsModal").find('.datetimepicker2').flatpickr({
          dateFormat: "H:i",
          disableMobile: true,
          noCalendar: true,
          enableTime: true
        });
      });


    }

  });

}


// remove a opção de arrastar os eventos do calendário
$(document).ready(function () {

  $('.fc-daygrid-event').removeClass('fc-event-draggable');
  $('.fc-timegrid-event').removeClass('fc-event-draggable');
  $('.fc-daygrid-event').css('cursor', 'pointer');

});


