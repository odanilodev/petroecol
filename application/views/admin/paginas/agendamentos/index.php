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
      <button class="btn btn-link text-900 px-0 me-2 me-md-4"><span class="fa-solid fa-sync fs--2 me-2"></span><span class="d-none d-md-inline">Sync Now</span></button>
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
      <div class="col-6 col-md-4 ms-auto order-1 d-flex justify-content-end">
        <div>
          <div class="btn-group btn-group-sm" role="group">
            <button class="btn btn-phoenix-secondary active-view" data-fc-view="dayGridMonth">Mês</button>
            <button class="btn btn-phoenix-secondary" data-fc-view="timeGridWeek">Semana</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="calendar-outline mt-6 mb-9" id="appCalendar"></div>




  <div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content border">
        <form id="addEventForm" autocomplete="off">
          <div class="modal-header px-card border-0">
            <div class="w-100 d-flex justify-content-between align-items-start">
              <div>
                <h5 class="mb-0 lh-sm text-1000">Add newdadqadada</h5>
                <div class="mt-2">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" id="inlineRadio1" type="radio" name="calendarTask" checked="checked" />
                    <label class="form-check-label" for="inlineRadio1">Event</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" id="inlineRadio2" type="radio" name="calendarTask" />
                    <label class="form-check-label" for="inlineRadio2">Task</label>
                  </div>
                </div>
              </div>
              <button class="btn p-1 fs--2 text-900" type="button" data-bs-dismiss="modal" aria-label="Close">DISCARD </button>
            </div>
          </div>
          <div class="modal-body p-card py-0">
            <div class="form-floating mb-3">
              <input class="form-control" id="eventTitle" type="text" name="title" required="required" placeholder="Event title" />
              <label for="eventTitle">Title</label>
            </div>
            <div class="form-floating mb-5">
              <select class="form-select" id="eventLabel" name="label">
                <option value="primary" selected="selected">Business</option>
                <option value="secondary">Personal</option>
                <option value="success">Meeting</option>
                <option value="danger">Birthday</option>
                <option value="info">Report</option>
                <option value="warinng">Must attend</option>
              </select>
              <label for="eventLabel">Label</label>
            </div>
            <div class="flatpickr-input-container mb-3">
              <div class="form-floating">
                <input class="form-control datetimepicker" id="eventStartDate" type="text" name="startDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' /><span class="uil uil-calendar-alt flatpickr-icon text-700"></span>
                <label class="ps-6" for="eventStartDate">Starts at</label>
              </div>
            </div>
            <div class="flatpickr-input-container mb-3">
              <div class="form-floating">
                <input class="form-control datetimepicker" id="eventEndDate" type="text" name="endDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' /><span class="uil uil-calendar-alt flatpickr-icon text-700"></span>
                <label class="ps-6" for="eventEndDate">Ends at</label>
              </div>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="eventAllDay" name="allDay" />
              <label class="form-check-label" for="eventAllDay">All day event
              </label>
            </div>
            <div class="form-floating my-5">
              <textarea class="form-control" id="eventDescription" placeholder="Leave a comment here" name="description" style="height: 128px"></textarea>
              <label for="eventDescription">Description</label>
            </div>
            <div class="form-floating mb-3">
              <select class="form-select" id="eventRepetition" name="repetition">
                <option value="" selected="selected">No Repeat</option>
                <option value="daily">Daily </option>
                <option value="deekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="dailyExceptHolidays">Daily (except holidays)</option>
                <option value="custom">Custom</option>
              </select>
              <label for="eventRepetition">Repetition</label>
            </div>
            <div class="form-floating mb-3">
              <select class="form-select" id="eventReminder" name="reminder">
                <option value="" selected="selected">30 minutes earlier</option>
                <option value="">8 am on the day</option>
                <option value="">8 am on the day before</option>
                <option value="">2 days earlier</option>
                <option value="">a week earlier</option>
              </select>
              <label for="eventReminder">Reminder</label>
            </div>
            <button class="btn btn-link p-0 mb-3" type="button"> <span class="fa-solid fa-plus me-2"></span>Add Reminder</button>
          </div>
          <div class="modal-footer d-flex justify-content-between align-items-center border-0"><a class="me-3 fs--1 text-900" href="../apps/events/create-an-event.html">More options<span class="fas fa-angle-right ms-1 fs--2"></span></a>
            <button class="btn btn-primary px-4" type="submit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="eventDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border"></div>
    </div>
  </div>
  <div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content border">
        <form id="addEventForm" autocomplete="off">
          <div class="modal-header px-card border-0">
            <div class="w-100 d-flex justify-content-between align-items-start">
              <div>
                <h5 class="mb-0 lh-sm text-1000">Add new</h5>
                <div class="mt-2">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" id="inlineRadio1" type="radio" name="calendarTask" checked="checked" />
                    <label class="form-check-label" for="inlineRadio1">Event</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" id="inlineRadio2" type="radio" name="calendarTask" />
                    <label class="form-check-label" for="inlineRadio2">Task</label>
                  </div>
                </div>
              </div>
              <button class="btn p-1 fs--2 text-900" type="button" data-bs-dismiss="modal" aria-label="Close">DISCARD </button>
            </div>
          </div>
          <div class="modal-body p-card py-0">
            <div class="form-floating mb-3">
              <input class="form-control" id="eventTitle" type="text" name="title" required="required" placeholder="Event title" />
              <label for="eventTitle">Title</label>
            </div>
            <div class="form-floating mb-5">
              <select class="form-select" id="eventLabel" name="label">
                <option value="primary" selected="selected">Business</option>
                <option value="secondary">Personal</option>
                <option value="success">Meeting</option>
                <option value="danger">Birthday</option>
                <option value="info">Report</option>
                <option value="warinng">Must attend</option>
              </select>
              <label for="eventLabel">Label</label>
            </div>
            <div class="flatpickr-input-container mb-3">
              <div class="form-floating">
                <input class="form-control datetimepicker" id="eventStartDate" type="text" name="startDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' /><span class="uil uil-calendar-alt flatpickr-icon text-700"></span>
                <label class="ps-6" for="eventStartDate">Starts at</label>
              </div>
            </div>
            <div class="flatpickr-input-container mb-3">
              <div class="form-floating">
                <input class="form-control datetimepicker" id="eventEndDate" type="text" name="endDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' /><span class="uil uil-calendar-alt flatpickr-icon text-700"></span>
                <label class="ps-6" for="eventEndDate">Ends at</label>
              </div>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="eventAllDay" name="allDay" />
              <label class="form-check-label" for="eventAllDay">All day event
              </label>
            </div>
            <div class="form-floating my-5">
              <textarea class="form-control" id="eventDescription" placeholder="Leave a comment here" name="description" style="height: 128px"></textarea>
              <label for="eventDescription">Description</label>
            </div>
            <div class="form-floating mb-3">
              <select class="form-select" id="eventRepetition" name="repetition">
                <option value="" selected="selected">No Repeat</option>
                <option value="daily">Daily </option>
                <option value="deekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="dailyExceptHolidays">Daily (except holidays)</option>
                <option value="custom">Custom</option>
              </select>
              <label for="eventRepetition">Repetition</label>
            </div>
            <div class="form-floating mb-3">
              <select class="form-select" id="eventReminder" name="reminder">
                <option value="" selected="selected">30 minutes earlier</option>
                <option value="">8 am on the day</option>
                <option value="">8 am on the day before</option>
                <option value="">2 days earlier</option>
                <option value="">a week earlier</option>
              </select>
              <label for="eventReminder">Reminder</label>
            </div>
            <button class="btn btn-link p-0 mb-3" type="button"> <span class="fa-solid fa-plus me-2"></span>Add Reminder</button>
          </div>
          <div class="modal-footer d-flex justify-content-between align-items-center border-0"><a class="me-3 fs--1 text-900" href="../apps/events/create-an-event.html">More options<span class="fas fa-angle-right ms-1 fs--2"></span></a>
            <button class="btn btn-primary px-4" type="submit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>