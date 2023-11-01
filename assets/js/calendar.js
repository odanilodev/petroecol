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

  const { dayjs } = window;
  const currentDay = dayjs && dayjs().format('DD');
  const currentMonth = dayjs && dayjs().format('MM');
  const prevMonth = dayjs && dayjs().subtract(1, 'month').format('MM');
  const nextMonth = dayjs && dayjs().add(1, 'month').format('MM');
  const currentYear = dayjs && dayjs().format('YYYY');

  const events = [

    {
      title: '145 agendados',
      start: `${currentYear}-${currentMonth}-${currentDay} 11:00:00`,
      description:
        'Time to start the conference and will briefly describe all information about the event.  ',
      className: 'text-success '
    },

    {
      title: '50 Atrasados',
      start: `${currentYear}-${currentMonth}-${currentDay} 11:00:00`,
      description:
        'Time to start the conference and will briefly describe all information about the event.  ',
      className: 'text-danger '
    }
    

  ];

  const getTemplate = event => `
    <div class="modal-header ps-card border-bottom">
      <div>
        <h4 class="modal-title text-1000 mb-0">${event.title}</h4>
        ${event.extendedProps.organizer
      ? `<p class="mb-0 fs--1 mt-1">
            by <a href="#!">${event.extendedProps.organizer}</a>
          </p>`
      : ''
    }
      </div>
      <button type="button" class="btn p-1 fw-bolder" data-bs-dismiss="modal" aria-label="Close">
        <span class='fas fa-times fs-0'></span>
      </button>

    </div>

    <div class="modal-body px-card pb-card pt-1 fs--1">
      ${event.extendedProps.description
      ? `
          <div class="mt-3 border-bottom pb-3">
            <h5 class='mb-0 text-800'>Description</h5>
            <p class="mb-0 mt-2">
              ${event.extendedProps.description.split(' ').slice(0, 30).join(' ')}
            </p>
          </div>
        `
      : ''
    } 
      <div class="mt-4 ${event.extendedProps.location ? 'border-bottom pb-3' : ''}">
        <h5 class='mb-0 text-800'>Date and Time</h5>
        <p class="mb-1 mt-2">
        ${window.dayjs &&
    window.dayjs(event.start).format('dddd, MMMM D, YYYY, h:mm A')
    } 
        ${event.end
      ? `– ${window.dayjs &&
      window
        .dayjs(event.end)
        .subtract(1, 'day')
        .format('dddd, MMMM D, YYYY, h:mm A')
      }`
      : ''
    }
      </p>

      </div>
      ${event.extendedProps.location
      ? `
            <div class="mt-4 ">
              <h5 class='mb-0 text-800'>Location</h5>
              <p class="mb-0 mt-2">${event.extendedProps.location}</p>
            </div>
          `
      : ''
    }
      ${event.schedules
      ? `
          <div class="mt-3">
            <h5 class='mb-0 text-800'>Schedule</h5>
            <ul class="list-unstyled timeline mt-2 mb-0">
              ${event.schedules
        .map(schedule => `<li>${schedule.title}</li>`)
        .join('')}
            </ul>
          </div>
          `
      : ''
    }
      </div>
    </div>

    <div class="modal-footer d-flex justify-content-end px-card pt-0 border-top-0">
      <a href="#!" class="btn btn-phoenix-secondary btn-sm">
        <span class="fas fa-pencil-alt fs--2 mr-2"></span> Edit
      </a>
      <button class="btn btn-phoenix-danger btn-sm" data-calendar-event-remove >
        <span class="fa-solid fa-trash fs--1 mr-2" data-fa-transform="shrink-2"></span> Delete
      </button>
      <a href='#!' class="btn btn-primary btn-sm">
        See more details
        <span class="fas fa-angle-right fs--2 ml-1"></span>
      </a>
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
              break;
            case 'next':
              calendar.next();
              updateTitle(calendar.currentData);
              break;
            case 'today':
              calendar.today();
              updateTitle(calendar.currentData);
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
//# sourceMappingURL=calendar.js.map


// remove a opção de arrastar os eventos do calendário
$(document).ready(function () {

  $('.fc-daygrid-event').removeClass('fc-event-draggable');
  $('.fc-timegrid-event').removeClass('fc-event-draggable');
  $('.fc-daygrid-event').css('cursor', 'pointer');

})