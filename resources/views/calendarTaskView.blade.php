@extends('Layouts.master')

@section('title', 'Calendar')
@section('nav', 'calendar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Calendar - Task View</h1>
                
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
                        <a href="{{ route('calendar') }}" class="card">
                            <div class="card-body text-center">
                                <i class="simple-icon-calendar"></i>
                                <p class="card-text font-weight-semibold mb-0">Calendar View</p>
                            </div>
                        </a>
                    </div>


                </div>

                <div class="row">

                    <div class="col-md-12 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex align-items-center mb-3 flex-wrap">

                                    <div class="btn-group mr-3">
                                        <button class="btn btn-outline-primary filter-btn active" data-range="day">Day</button>
                                        <button class="btn btn-outline-primary filter-btn" data-range="week">Week</button>
                                        <button class="btn btn-outline-primary filter-btn" data-range="month">Month</button>
                                    </div>

                                    <span class="text-muted mr-4">
                                        Showing:
                                        <strong id="currentRangeLabel">Today</strong>
                                    </span>

                                    <input type="text"
                                        id="bookingSearch"
                                        class="form-control form-control-sm"
                                        placeholder="Search Student ID or Batch"
                                        style="max-width: 260px;">
                                </div>

                                <div class="table-responsive">
                                    <table class="table" id="bookingTable">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Title</th>
                                                <th>Module</th>
                                                <th>Date</th>
                                                <th>Start</th>
                                                <th>End</th>
                                                <th>Lab</th>
                                                <th>Computer</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>

                                </div>

                            </div>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                        <!-- Calculate Range Script -->
                        <script>
                            function formatDate(date) {
                                const d = new Date(date);
                                const day = String(d.getDate()).padStart(2, '0');
                                const month = String(d.getMonth() + 1).padStart(2, '0');
                                const year = d.getFullYear();
                                return `${day}-${month}-${year}`;
                            }

                            function getWeekRange(date = new Date()) {
                                const d = new Date(date);
                                const day = d.getDay() || 7; // Sunday = 7
                                const start = new Date(d);
                                start.setDate(d.getDate() - day + 1); // Monday
                                const end = new Date(start);
                                end.setDate(start.getDate() + 6);
                                return { start, end };
                            }

                            function getMonthRange(date = new Date()) {
                                const start = new Date(date.getFullYear(), date.getMonth(), 1);
                                const end = new Date(date.getFullYear(), date.getMonth() + 1, 0);
                                return { start, end };
                            }
                        </script>

                        <!-- Range control buttons script -->
                        <script>
                            $(document).ready(function () {

                                let currentRange = 'day';

                                loadBookings(currentRange);
                                updateRangeLabel(currentRange);

                                $('.filter-btn').on('click', function () {

                                    $('.filter-btn').removeClass('active');
                                    $(this).addClass('active');

                                    currentRange = $(this).data('range');
                                    updateRangeLabel(currentRange);
                                    loadBookings(currentRange);
                                });

                                function updateRangeLabel(range) {

                                    const today = new Date();
                                    let label = '';

                                    if (range === 'day') {
                                        label = formatDate(today);
                                    }

                                    if (range === 'week') {
                                        const { start, end } = getWeekRange(today);
                                        label = `${formatDate(start)} → ${formatDate(end)}`;
                                    }

                                    if (range === 'month') {
                                        const { start, end } = getMonthRange(today);
                                        label = `${formatDate(start)} → ${formatDate(end)}`;
                                    }

                                    $('#currentRangeLabel').text(label);
                                }

                                function loadBookings(range) {

                                    $.get('/bookings/table', { range }, function (rows) {

                                        const tbody = $('#bookingTable tbody');
                                        tbody.empty();

                                        if (!rows.length) {
                                            tbody.append(`
                                                <tr>
                                                    <td colspan="10" class="text-center text-muted">
                                                        No bookings found
                                                    </td>
                                                </tr>
                                            `);
                                            return;
                                        }

                                        rows.forEach(b => {
                                            tbody.append(renderRow(b));
                                        });

                                        applySearchFilter();
                                    });
                                }

                                function renderRow(b) {

                                    const titleColor = b.raw.color ?? '#000000';

                                    return `
                                        <tr data-search="${(b.title ?? '').toLowerCase()}">

                                            <td>
                                                <span style="color:${titleColor}; font-weight:600;">
                                                    ${b.type}
                                                </span>
                                            </td>

                                            <td>${b.title}</td>
                                            <td>${b.module ?? '—'}</td>
                                            <td>${b.date}</td>
                                            <td>${b.start}</td>
                                            <td>${b.end}</td>
                                            <td>${b.lab}</td>
                                            <td>${b.computer}</td>
                                            <td>${renderBookingStatusBadge(b.status)}</td>
                                            <td>
                                                <a href="javascript:void(0)"
                                                class="view-booking"
                                                data-booking='${JSON.stringify(b.raw)}'>
                                                    <i class="simple-icon-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    `;
                                }

                                // Search handler
                                $('#bookingSearch').on('keyup', function () {
                                    applySearchFilter();
                                });

                                function applySearchFilter() {
                                    const term = $('#bookingSearch').val().toLowerCase();

                                    $('#bookingTable tbody tr').each(function () {
                                        const searchValue = $(this).data('search');
                                        $(this).toggle(searchValue.includes(term));
                                    });
                                }

                            });
                        </script>

                        <!-- View Modal Script -->
                        <script>
                            $(document).on('click', '.view-booking', function () {

                                const booking = $(this).data('booking');

                                $('#modalTitle').text(booking.title);
                                $('#modalStart').text(new Date(booking.start).toLocaleString());
                                $('#modalEnd').text(new Date(booking.end).toLocaleString());

                                $('#modalLab').text(booking.lab?.lab_name ?? 'N/A');
                                $('#modalBatch').text(booking.batch ?? 'N/A');
                                $('#modalLecturer').text(booking.lecturer ?? 'N/A');
                                $('#modalModule').text(booking.module ?? 'N/A');
                                $('#modalDescription').text(booking.description ?? 'N/A');
                                $('#modalStudents').text(booking.students_count ?? 'N/A');
                                $('#modalNotes').text(booking.notes ?? 'N/A');
                                $('#modalComputerId').text(booking.computer?.computer_label ?? 'N/A');
                                $('#createdBy').text(booking.created_by ?? 'N/A');

                                $('#modalStatus').html(renderBookingStatusBadge(booking.status));

                                $('#modalBookingID').val(booking.id);
                                $('#modalBookingCancelID').val(booking.id);
                                $('#modalBookingDeleteID').val(booking.id);

                                $('#eventModal').modal('show');
                            });
                        </script>

                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                
                <!-- Event Display Modal -->
                @include('Partials.Calendar.eventModal')

                <!-- New Batch Event Modal -->
                @include('Partials.Calendar.newEventModal')

                <!-- New Individual Event Modal -->
                @include('Partials.Calendar.newIndividualEventModal')

                <!-- Event Guide Modal -->
                @include('Partials.Calendar.eventGuideModal')

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