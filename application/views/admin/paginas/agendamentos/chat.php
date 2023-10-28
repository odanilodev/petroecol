<div class="content">

  <div class="row g-0 mb-4 align-items-center">
    <div class="col-5 col-md-6">
      <h4 class="mb-0 text-1100 fw-bold fs-md-2"><span class="calendar-day d-block d-md-inline mb-1"></span><span class="px-3 fw-thin text-400 d-none d-md-inline">|</span><span class="calendar-date"></span></h4>
    </div>
    <div class="col-7 col-md-6 d-flex justify-content-end">
      <button class="btn btn-link text-900 px-0 me-2 me-md-4"><span class="fa-solid fa-sync fs--2 me-2"></span><span class="d-none d-md-inline">Sync Now</span></button>
      <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addEventModal"> <span class="fas fa-plus pe-2 fs--2"></span>Add new task </button>
    </div>
  </div>

  <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 border-y border-200">
    <div class="row py-3 gy-3 gx-0">
      <div class="col-6 col-md-4 order-1 d-flex align-items-center">
        <button class="btn btn-sm btn-phoenix-primary px-4" data-event="today">Today</button>
      </div>
      <div class="col-12 col-md-4 order-md-1 d-flex align-items-center justify-content-center">
        <button class="btn icon-item icon-item-sm shadow-none text-1100 p-0" type="button" data-event="prev" title="Previous"><span class="fas fa-chevron-left"></span></button>
        <h3 class="px-3 text-1100 fw-semi-bold calendar-title mb-0"> </h3>
        <button class="btn icon-item icon-item-sm shadow-none text-1100 p-0" type="button" data-event="next" title="Next"><span class="fas fa-chevron-right"></span></button>
      </div>
      <div class="col-6 col-md-4 ms-auto order-1 d-flex justify-content-end">
        <div>
          <div class="btn-group btn-group-sm" role="group">
            <button class="btn btn-phoenix-secondary active-view" data-fc-view="dayGridMonth">Month</button>
            <button class="btn btn-phoenix-secondary" data-fc-view="timeGridWeek">Week</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="calendar-outline mt-6 mb-9" id="appCalendar"></div>
  <footer class="footer position-absolute">
    <div class="row g-0 justify-content-between align-items-center h-100">
      <div class="col-12 col-sm-auto text-center">
        <p class="mb-0 mt-2 mt-sm-0 text-900">Thank you for creating with Phoenix<span class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2023 &copy;<a class="mx-1" href="https://themewagon.com">Themewagon</a></p>
      </div>
      <div class="col-12 col-sm-auto text-center">
        <p class="mb-0 text-600">v1.13.0</p>
      </div>
    </div>
  </footer>
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

<script>
  var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
  var navbarTop = document.querySelector('.navbar-top');
  if (navbarTopStyle === 'darker') {
    navbarTop.classList.add('navbar-darker');
  }

  var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
  var navbarVertical = document.querySelector('.navbar-vertical');
  if (navbarVertical && navbarVerticalStyle === 'darker') {
    navbarVertical.classList.add('navbar-darker');
  }
</script>
<div class="support-chat-container">
  <div class="container-fluid support-chat">
    <div class="card bg-white">
      <div class="card-header d-flex flex-between-center px-4 py-3 border-bottom">
        <h5 class="mb-0 d-flex align-items-center gap-2">Demo widget<span class="fa-solid fa-circle text-success fs--3"></span></h5>
        <div class="btn-reveal-trigger">
          <button class="btn btn-link p-0 dropdown-toggle dropdown-caret-none transition-none d-flex" type="button" id="support-chat-dropdown" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h text-900"></span></button>
          <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="support-chat-dropdown"><a class="dropdown-item" href="#!">Request a callback</a><a class="dropdown-item" href="#!">Search in chat</a><a class="dropdown-item" href="#!">Show history</a><a class="dropdown-item" href="#!">Report to Admin</a><a class="dropdown-item btn-support-chat" href="#!">Close Support</a></div>
        </div>
      </div>
      <div class="card-body chat p-0">
        <div class="d-flex flex-column-reverse scrollbar h-100 p-3">
          <div class="text-end mt-6"><a class="mb-2 d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3" href="#!">
              <p class="mb-0 fw-semi-bold fs--1">I need help with something</p><span class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
            </a><a class="mb-2 d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3" href="#!">
              <p class="mb-0 fw-semi-bold fs--1">I can’t reorder a product I previously ordered</p><span class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
            </a><a class="mb-2 d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3" href="#!">
              <p class="mb-0 fw-semi-bold fs--1">How do I place an order?</p><span class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
            </a><a class="false d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3" href="#!">
              <p class="mb-0 fw-semi-bold fs--1">My payment method not working</p><span class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
            </a>
          </div>
          <div class="text-center mt-auto">
            <div class="avatar avatar-3xl status-online"><img class="rounded-circle border border-3 border-white" src="../assets/img/team/30.webp" alt="" /></div>
            <h5 class="mt-2 mb-3">Eric</h5>
            <p class="text-center text-black mb-0">Ask us anything – we’ll get back to you here or by email within 24 hours.</p>
          </div>
        </div>
      </div>
      <div class="card-footer d-flex align-items-center gap-2 border-top ps-3 pe-4 py-3">
        <div class="d-flex align-items-center flex-1 gap-3 border rounded-pill px-4">
          <input class="form-control outline-none border-0 flex-1 fs--1 px-0" type="text" placeholder="Write message" />
          <label class="btn btn-link d-flex p-0 text-500 fs--1 border-0" for="supportChatPhotos"><span class="fa-solid fa-image"></span></label>
          <input class="d-none" type="file" accept="image/*" id="supportChatPhotos" />
          <label class="btn btn-link d-flex p-0 text-500 fs--1 border-0" for="supportChatAttachment"> <span class="fa-solid fa-paperclip"></span></label>
          <input class="d-none" type="file" id="supportChatAttachment" />
        </div>
        <button class="btn p-0 border-0 send-btn"><span class="fa-solid fa-paper-plane fs--1"></span></button>
      </div>
    </div>
  </div>
  <button class="btn p-0 border border-200 btn-support-chat"><span class="fs-0 btn-text text-primary text-nowrap">Chat demo</span><span class="fa-solid fa-circle text-success fs--1 ms-2"></span><span class="fa-solid fa-chevron-down text-primary fs-1"></span></button>
</div>
</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->





<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<script src="<?= base_url() ?>vendors/popper/popper.min.js"></script>
<script src="<?= base_url() ?>vendors/bootstrap/bootstrap.min.js"></script>
<script src="<?= base_url() ?>vendors/anchorjs/anchor.min.js"></script>
<script src="<?= base_url() ?>vendors/is/is.min.js"></script>
<script src="<?= base_url() ?>vendors/fontawesome/all.min.js"></script>
<script src="<?= base_url() ?>vendors/lodash/lodash.min.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
<script src="<?= base_url() ?>vendors/list.js/list.min.js"></script>
<script src="<?= base_url() ?>vendors/feather-icons/feather.min.js"></script>
<script src="<?= base_url() ?>vendors/dayjs/dayjs.min.js"></script>
<script src="<?= base_url() ?>vendors/fullcalendar/main.min.js"></script>
<!-- <script src="<?= base_url() ?>vendors/dayjs/dayjs.min.js"></script> -->
<script src="<?= base_url() ?>assets/js/phoenix.js"></script>
<script src="<?= base_url() ?>assets/js/calendar.js"></script>

</body>

</html>