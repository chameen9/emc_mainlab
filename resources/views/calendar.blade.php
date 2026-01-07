@extends('Layouts.master')

@section('title', 'Calendar')
@section('nav', 'calendar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Calendar</h1>
                
                <div class="separator mb-5"></div>

                <div class="row">
                    <div class="col-md-3 col-lg-2 col-sm-4 col-6 mb-4">
                        <a href="#newEventModal" class="card" data-toggle="modal">
                            <div class="card-body text-center">
                                <i class="iconsminds-add"></i>
                                <p class="card-text font-weight-semibold mb-0">Batch Event</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 col-lg-2 col-sm-4 col-6 mb-4">
                        <a href="#newIndividualEventModal" class="card" data-toggle="modal">
                            <div class="card-body text-center">
                                <i class="iconsminds-add-user"></i>
                                <p class="card-text font-weight-semibold mb-0">Student Event</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 col-lg-2 col-sm-4 col-6 mb-4">
                        <a href="#newPermanentIndividualEventModal" class="card" data-toggle="modal">
                            <div class="card-body text-center">
                                <i class="simple-icon-calendar"></i>
                                <p class="card-text font-weight-semibold mb-0">Permanent Slots</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 col-lg-2 col-sm-4 col-6 mb-4">
                        <a href="{{ route('calendarTaskView') }}" class="card">
                            <div class="card-body text-center">
                                <i class="simple-icon-check"></i>
                                <p class="card-text font-weight-semibold mb-0">Task View</p>
                            </div>
                        </a>
                    </div>


                </div>

                <div class="row">

                    <div class="col-md-12 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body" style="display: flex; flex-direction: column;">
                                <div id="calendar" style="flex-grow: 1; min-height: 650px;"></div>

                                <!-- Calendar Rendering Script -->
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var calendarEl = document.getElementById('calendar');

                                        var calendar = new FullCalendar.Calendar(calendarEl, {
                                            initialView: 'timeGridWeek',
                                            height: '100%',
                                            themeSystem: 'standard',
                                            firstDay: 1, // Start week on Monday

                                            headerToolbar: {
                                                left: 'prev,next today',
                                                center: 'title',
                                                right: 'dayBtn,weekBtn,monthBtn'
                                            },

                                            customButtons: {
                                                dayBtn: { text: 'Day', click: function() { calendar.changeView('timeGridDay'); }},
                                                weekBtn: { text: 'Week', click: function() { calendar.changeView('timeGridWeek'); }},
                                                monthBtn:{ text: 'Month', click: function() { calendar.changeView('dayGridMonth'); }}
                                            },

                                            events: '/calendar-events', // ✅ this loads events from backend

                                            eventClick: function(info) {
                                                document.getElementById('modalTitle').innerText = info.event.title;
                                                document.getElementById('modalStart').innerText = info.event.start.toLocaleString();
                                                document.getElementById('modalEnd').innerText = info.event.end ? info.event.end.toLocaleString() : "N/A";

                                                document.getElementById('modalLab').innerText = info.event.extendedProps.lab ?? "N/A";
                                                document.getElementById('modalLecturer').innerText = info.event.extendedProps.lecturer ?? "N/A";
                                                document.getElementById('modalModule').innerText = info.event.extendedProps.module ?? "N/A";
                                                document.getElementById('modalBatch').innerText = info.event.extendedProps.batch ?? "N/A";
                                                document.getElementById('modalDescription').innerText = info.event.extendedProps.description ?? "N/A";
                                                document.getElementById('createdBy').innerText = info.event.extendedProps.created_by ?? "N/A";
                                                document.getElementById('modalStudents').innerText = info.event.extendedProps.student_count ?? "N/A";
                                                document.getElementById('modalNotes').innerText = info.event.extendedProps.notes ?? "N/A";
                                                document.getElementById('modalComputerId').innerText = info.event.extendedProps.computer_label ?? "N/A";
                                                document.getElementById('modalBookingID').value = info.event.id ?? "N/A";
                                                document.getElementById('modalBookingCancelID').value = info.event.id ?? "N/A";
                                                document.getElementById('modalBookingDeleteID').value = info.event.id ?? "N/A";
                                                document.getElementById('modalStatus').innerText = info.event.extendedProps.status ?? "N/A";
                                                $('#modalStatus').html(renderBookingStatusBadge(info.event.extendedProps.status));
                                                $('#eventModal').modal('show');
                                            },

                                            slotMinTime: '08:00:00',
                                            slotMaxTime: '18:00:00',
                                        });

                                        calendar.render();
                                    });
                                </script>

                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

                <!-- Event Display Modal -->
                @include('Partials.Calendar.eventModal')

                <!-- New Batch Event Modal -->
                @include('Partials.Calendar.newEventModal')

                <!-- New Individual Event Modal -->
                @include('Partials.Calendar.newIndividualEventModal')

                <!-- New Permanent Individual Event Modal -->
                @include('Partials.Calendar.newPermanentIndividualEventModal')

            </div>
        </div>
    </div>

    <!-- View Modal Status Badge Script -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function renderBookingStatusBadge(status) {
            let badgeClass = 'badge-dark';
            let label = status.replace('_', ' ');

            switch (status) {
                case 'Scheduled':
                    badgeClass = 'badge-primary';
                    break;
                case 'Completed':
                    badgeClass = 'badge-success';
                    break;
                case 'Cancelled':
                    badgeClass = 'badge-warning';
                    break;
                case 'Deleted':
                    badgeClass = 'badge-danger';
                    break;
            }

            return `<span class="badge badge ${badgeClass}">
                        ${label}
                    </span>`;
        }
    </script>

@endsection