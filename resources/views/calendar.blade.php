@extends('layouts.master')

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
                        <a href="#eventGuide" class="card" data-toggle="modal">
                            <div class="card-body text-center">
                                <i class="simple-icon-info"></i>
                                <p class="card-text font-weight-semibold mb-0">Event Guide</p>
                            </div>
                        </a>
                        <!-- <div class="card">
                            <div class="card-body">

                                <div class="d-flex align-items-center mb-2">
                                    <span class="mr-2" style="background-color: #d45284ff; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                    <span class="text-small">Exam</span>
                                </div>

                                <div class="d-flex align-items-center mb-2">
                                    <span class="mr-2" style="background-color: #55ade3ff; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                    <span class="text-small">Practical</span>
                                </div>

                            </div>
                        </div> -->
                    </div>


                </div>

                <div class="row">

                    <div class="col-md-12 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body" style="display: flex; flex-direction: column;">
                                <div id="calendar" style="flex-grow: 1; min-height: 650px;"></div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var calendarEl = document.getElementById('calendar');

                                        var calendar = new FullCalendar.Calendar(calendarEl, {
                                            initialView: 'timeGridWeek',
                                            height: '100%',

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

                <!-- Event Display Modal -->
                <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eventModalLabel">Event Details </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Title:</strong></div>
                                    <div class="col-8" id="modalTitle"></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4"><strong>Start Time:</strong></div>
                                    <div class="col-8" id="modalStart"></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4"><strong>End Time:</strong></div>
                                    <div class="col-8" id="modalEnd"></div>
                                </div>

                                <hr>

                                <div class="row mb-2">
                                    <div class="col-4"><strong>Lab:</strong></div>
                                    <div class="col-8" id="modalLab"></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4"><strong>Batch:</strong></div>
                                    <div class="col-8" id="modalBatch"></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4"><strong>Invigilator:</strong></div>
                                    <div class="col-8" id="modalLecturer"></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4"><strong>Module:</strong></div>
                                    <div class="col-8" id="modalModule"></div>
                                </div>

                                <hr>

                                <div class="row mb-2">
                                    <div class="col-4"><strong>Description:</strong></div>
                                    <div class="col-8" id="modalDescription"></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4"><strong>Students Count:</strong></div>
                                    <div class="col-8" id="modalStudents"></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4"><strong>Created By:</strong></div>
                                    <div class="col-8" id="createdBy"></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4"><strong>Notes:</strong></div>
                                    <div class="col-8" id="modalNotes"></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4"><strong>Computer:</strong></div>
                                    <div class="col-8" id="modalComputerId"></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4"><strong>Status:</strong></div>
                                    <div class="col-8" id="modalStatus"></div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <!-- <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close</button> -->
                                    <form action="{{route('bookingComplete')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="booking_id" id="modalBookingID">
                                        <button type="submit" class="btn btn-success">Complete</button>
                                    </form>

                                    <form action="{{route('bookingCancel')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="booking_id" id="modalBookingCancelID">
                                        <button type="submit" class="btn btn-warning">Cancel</button>
                                    </form>

                                    <form action="{{route('bookingDelete')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="booking_id" id="modalBookingDeleteID">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Batch Event Modal -->
                <div class="modal fade" id="newEventModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newEventModalLabel">New Batch Event</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('eventStore') }}">
                                @csrf
                                <div class="modal-body">
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="date">Date *</label>
                                                <input type="date" class="form-control" id="date" name="date"
                                                    placeholder="Pick a Date" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="description">Type *</label>
                                                <select name="description" class="form-control select2-single" id="description" data-width="100%" required>
                                                    <option value="">Pick a Type</option>
                                                    <option value="Batch Exam">Batch Exam</option>
                                                    <option value="Batch Practical">Batch Practical</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="course">Course *</label>
                                                <select name="course" class="form-control select2-single" id="course" data-width="100%" required>
                                                    <option value="">Pick a Course</option>
                                                    @foreach($courses as $course)
                                                        <option value="{{ $course->id }}">{{ $course->course_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="module">Module *</label>
                                                <select name="module" class="form-control select2-single" id="module" data-width="100%" required>
                                                    <option value="">Pick a Module</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="batch">Batch *</label>
                                                <select name="batch" class="form-control select2-single" id="batch" data-width="100%" required>
                                                    <option value="">Pick a Batch</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                    document.addEventListener("DOMContentLoaded", function() {

                                        document.getElementById('course').addEventListener('change', function () {
                                            let courseId = this.value;

                                            // Reset dropdowns
                                            let batchSelect = document.getElementById('batch');
                                            let moduleSelect = document.getElementById('module');

                                            batchSelect.innerHTML = '<option value="">Pick your Batch</option>';
                                            moduleSelect.innerHTML = '<option value="">Pick a Module</option>';

                                            if (courseId === "") {
                                                return;
                                            }

                                            // ✅ Load Batches
                                            fetch(`/get-batches/${courseId}`)
                                                .then(response => response.json())
                                                .then(data => {
                                                    data.forEach(function(batch) {
                                                        let option = document.createElement('option');
                                                        option.value = batch.id;
                                                        option.text  = batch.batch_number;
                                                        batchSelect.appendChild(option);
                                                    });
                                                })
                                                .catch(error => console.log("Error loading batches:", error));

                                            // ✅ Load Modules
                                            fetch(`/get-modules/${courseId}`)
                                                .then(response => response.json())
                                                .then(data => {
                                                    data.forEach(function(module) {
                                                        let option = document.createElement('option');
                                                        option.value = module.module_number;
                                                        option.text  = module.module_number + " - " + module.name;
                                                        moduleSelect.appendChild(option);
                                                    });
                                                })
                                                .catch(error => console.log("Error loading modules:", error));
                                        });

                                    });
                                    </script>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="start">Start Time *</label>
                                                <select name="start" class="form-control select2-single" id="start" data-width="100%" required>
                                                    <option value="">Pick a Time</option>
                                                    <option value="08:00">08:00</option>
                                                    <option value="08:15">08:15</option>
                                                    <option value="08:30">08:30</option>
                                                    <option value="08:45">08:45</option>

                                                    <option value="09:00">09:00</option>
                                                    <option value="09:15">09:15</option>
                                                    <option value="09:30">09:30</option>
                                                    <option value="09:45">09:45</option>

                                                    <option value="10:00">10:00</option>
                                                    <option value="10:15">10:15</option>
                                                    <option value="10:30">10:30</option>
                                                    <option value="10:45">10:45</option>

                                                    <option value="11:00">11:00</option>
                                                    <option value="11:15">11:15</option>
                                                    <option value="11:30">11:30</option>
                                                    <option value="11:45">11:45</option>

                                                    <option value="12:00">12:00</option>
                                                    <option value="12:15">12:15</option>
                                                    <option value="12:30">12:30</option>
                                                    <option value="12:45">12:45</option>

                                                    <option value="13:00">13:00</option>
                                                    <option value="13:15">13:15</option>
                                                    <option value="13:30">13:30</option>
                                                    <option value="13:45">13:45</option>

                                                    <option value="14:00">14:00</option>
                                                    <option value="14:15">14:15</option>
                                                    <option value="14:30">14:30</option>
                                                    <option value="14:45">14:45</option>

                                                    <option value="15:00">15:00</option>
                                                    <option value="15:15">15:15</option>
                                                    <option value="15:30">15:30</option>
                                                    <option value="15:45">15:45</option>

                                                    <option value="16:00">16:00</option>
                                                    <option value="16:15">16:15</option>
                                                    <option value="16:30">16:30</option>
                                                    <option value="16:45">16:45</option>

                                                    <option value="17:00">17:00</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="end">End Time *</label>
                                                <select name="end" class="form-control select2-single" id="end" data-width="100%" required>
                                                    <option value="">Pick a Time</option>
                                                    <option value="08:00">08:00</option>
                                                    <option value="08:15">08:15</option>
                                                    <option value="08:30">08:30</option>
                                                    <option value="08:45">08:45</option>

                                                    <option value="09:00">09:00</option>
                                                    <option value="09:15">09:15</option>
                                                    <option value="09:30">09:30</option>
                                                    <option value="09:45">09:45</option>

                                                    <option value="10:00">10:00</option>
                                                    <option value="10:15">10:15</option>
                                                    <option value="10:30">10:30</option>
                                                    <option value="10:45">10:45</option>

                                                    <option value="11:00">11:00</option>
                                                    <option value="11:15">11:15</option>
                                                    <option value="11:30">11:30</option>
                                                    <option value="11:45">11:45</option>

                                                    <option value="12:00">12:00</option>
                                                    <option value="12:15">12:15</option>
                                                    <option value="12:30">12:30</option>
                                                    <option value="12:45">12:45</option>

                                                    <option value="13:00">13:00</option>
                                                    <option value="13:15">13:15</option>
                                                    <option value="13:30">13:30</option>
                                                    <option value="13:45">13:45</option>

                                                    <option value="14:00">14:00</option>
                                                    <option value="14:15">14:15</option>
                                                    <option value="14:30">14:30</option>
                                                    <option value="14:45">14:45</option>

                                                    <option value="15:00">15:00</option>
                                                    <option value="15:15">15:15</option>
                                                    <option value="15:30">15:30</option>
                                                    <option value="15:45">15:45</option>

                                                    <option value="16:00">16:00</option>
                                                    <option value="16:15">16:15</option>
                                                    <option value="16:30">16:30</option>
                                                    <option value="16:45">16:45</option>

                                                    <option value="17:00">17:00</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="lab">LAB *</label>
                                                <select name="lab" class="form-control select2-single" id="lab" data-width="100%" required>
                                                    <!-- <option value="">Pick a Course</option> -->
                                                    @foreach($labs as $lab)
                                                        <option value="{{ $lab->id }}">{{ $lab->lab_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="invigilator">Invigilator *</label>
                                                <select name="invigilator" class="form-control select2-single" id="invigilator" data-width="100%" required>
                                                    @foreach($invigilators as $invigilator)
                                                        <option value="{{ $invigilator->name }}">{{ $invigilator->name }}</option>
                                                    @endforeach
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="lab">Notes (Optional)</label>
                                                <input type="text" name="notes" class="form-control" id="notes" placeholder="Enter any notes here">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create Event</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- New Individual Event Modal -->
                <div class="modal fade" id="newIndividualEventModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Student Event</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('individualEventStore') }}">
                                @csrf
                                <div class="modal-body">
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="student_id">Student ID *</label>
                                                <input type="text" class="form-control" id="student_id" name="student_id"
                                                    placeholder="Enter Student ID" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="date">Date *</label>
                                                <input type="date" class="form-control" id="date" name="date"
                                                    placeholder="Pick a Date" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="description">Type *</label>
                                                <select name="description" class="form-control select2-single" id="idescription" data-width="100%" required>
                                                    <option value="">Pick a Type</option>
                                                    <option value="Exam">Exam</option>
                                                    <option value="Practical">Practical</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="course">Course *</label>
                                                <select name="course" class="form-control select2-single" id="icourse" data-width="100%" required>
                                                    <option value="">Pick a Course</option>
                                                    @foreach($courses as $course)
                                                        <option value="{{ $course->id }}">{{ $course->course_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="module">Module *</label>
                                                <select name="module" class="form-control select2-single" id="imodule" data-width="100%" required>
                                                    <option value="">Pick a Module</option>
                                                    
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="batch">Batch *</label>
                                                <select name="batch" class="form-control select2-single" id="ibatch" data-width="100%" required>
                                                    <option value="">Pick your Batch</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                    document.addEventListener("DOMContentLoaded", function() {

                                        document.getElementById('icourse').addEventListener('change', function () {
                                            let courseId = this.value;

                                            // Reset dropdowns
                                            let batchSelect = document.getElementById('ibatch');
                                            let moduleSelect = document.getElementById('imodule');

                                            batchSelect.innerHTML = '<option value="">Pick your Batch</option>';
                                            moduleSelect.innerHTML = '<option value="">Pick a Module</option>';

                                            if (courseId === "") {
                                                return;
                                            }

                                            // ✅ Load Batches
                                            fetch(`/get-batches/${courseId}`)
                                                .then(response => response.json())
                                                .then(data => {
                                                    data.forEach(function(batch) {
                                                        let option = document.createElement('option');
                                                        option.value = batch.id;
                                                        option.text  = batch.batch_number;
                                                        batchSelect.appendChild(option);
                                                    });
                                                })
                                                .catch(error => console.log("Error loading batches:", error));

                                            // ✅ Load Modules
                                            fetch(`/get-modules/${courseId}`)
                                                .then(response => response.json())
                                                .then(data => {
                                                    data.forEach(function(module) {
                                                        let option = document.createElement('option');
                                                        option.value = module.module_number;
                                                        option.text  = module.module_number + " - " + module.name;
                                                        moduleSelect.appendChild(option);
                                                    });
                                                })
                                                .catch(error => console.log("Error loading modules:", error));
                                        });

                                    });
                                    </script>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="start">Start Time *</label>
                                                <select name="start" class="form-control select2-single" id="start" data-width="100%" required>
                                                    <option value="">Pick a Time</option>
                                                    <option value="08:00">08:00</option>
                                                    <option value="08:15">08:15</option>
                                                    <option value="08:30">08:30</option>
                                                    <option value="08:45">08:45</option>

                                                    <option value="09:00">09:00</option>
                                                    <option value="09:15">09:15</option>
                                                    <option value="09:30">09:30</option>
                                                    <option value="09:45">09:45</option>

                                                    <option value="10:00">10:00</option>
                                                    <option value="10:15">10:15</option>
                                                    <option value="10:30">10:30</option>
                                                    <option value="10:45">10:45</option>

                                                    <option value="11:00">11:00</option>
                                                    <option value="11:15">11:15</option>
                                                    <option value="11:30">11:30</option>
                                                    <option value="11:45">11:45</option>

                                                    <option value="12:00">12:00</option>
                                                    <option value="12:15">12:15</option>
                                                    <option value="12:30">12:30</option>
                                                    <option value="12:45">12:45</option>

                                                    <option value="13:00">13:00</option>
                                                    <option value="13:15">13:15</option>
                                                    <option value="13:30">13:30</option>
                                                    <option value="13:45">13:45</option>

                                                    <option value="14:00">14:00</option>
                                                    <option value="14:15">14:15</option>
                                                    <option value="14:30">14:30</option>
                                                    <option value="14:45">14:45</option>

                                                    <option value="15:00">15:00</option>
                                                    <option value="15:15">15:15</option>
                                                    <option value="15:30">15:30</option>
                                                    <option value="15:45">15:45</option>

                                                    <option value="16:00">16:00</option>
                                                    <option value="16:15">16:15</option>
                                                    <option value="16:30">16:30</option>
                                                    <option value="16:45">16:45</option>

                                                    <option value="17:00">17:00</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="end">End Time *</label>
                                                <select name="end" class="form-control select2-single" id="end" data-width="100%" required>
                                                    <option value="">Pick a Time</option>
                                                    <option value="08:00">08:00</option>
                                                    <option value="08:15">08:15</option>
                                                    <option value="08:30">08:30</option>
                                                    <option value="08:45">08:45</option>

                                                    <option value="09:00">09:00</option>
                                                    <option value="09:15">09:15</option>
                                                    <option value="09:30">09:30</option>
                                                    <option value="09:45">09:45</option>

                                                    <option value="10:00">10:00</option>
                                                    <option value="10:15">10:15</option>
                                                    <option value="10:30">10:30</option>
                                                    <option value="10:45">10:45</option>

                                                    <option value="11:00">11:00</option>
                                                    <option value="11:15">11:15</option>
                                                    <option value="11:30">11:30</option>
                                                    <option value="11:45">11:45</option>

                                                    <option value="12:00">12:00</option>
                                                    <option value="12:15">12:15</option>
                                                    <option value="12:30">12:30</option>
                                                    <option value="12:45">12:45</option>

                                                    <option value="13:00">13:00</option>
                                                    <option value="13:15">13:15</option>
                                                    <option value="13:30">13:30</option>
                                                    <option value="13:45">13:45</option>

                                                    <option value="14:00">14:00</option>
                                                    <option value="14:15">14:15</option>
                                                    <option value="14:30">14:30</option>
                                                    <option value="14:45">14:45</option>

                                                    <option value="15:00">15:00</option>
                                                    <option value="15:15">15:15</option>
                                                    <option value="15:30">15:30</option>
                                                    <option value="15:45">15:45</option>

                                                    <option value="16:00">16:00</option>
                                                    <option value="16:15">16:15</option>
                                                    <option value="16:30">16:30</option>
                                                    <option value="16:45">16:45</option>

                                                    <option value="17:00">17:00</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="lab">Notes (Optional)</label>
                                                <input type="text" name="notes" class="form-control" id="notes" placeholder="Enter any notes here">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group" id="computerSection" style="display:none;">
                                                <label for="icomputer">Computer *</label>
                                                <select name="computer_id" id="icomputer" class="form-control select2-single">
                                                    <option value="">Pick a Computer</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div id="softwareDetails" style="display:none;" class="mt-2">
                                                <h6>Software Availability:</h6>
                                                <div id="softwareBadges"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                    document.addEventListener("DOMContentLoaded", function () {

                                        const typeSelect        = document.getElementById("idescription");
                                        const computerSection   = document.getElementById("computerSection");
                                        const computerSelect    = document.getElementById("icomputer");
                                        const softwareDetails   = document.getElementById("softwareDetails");
                                        const softwareList      = document.getElementById("softwareList");

                                        // Hide initially
                                        computerSection.style.display = "none";
                                        softwareDetails.style.display = "none";

                                        // ✅ When type is changed
                                        typeSelect.addEventListener("change", function () {
                                            if (this.value === "Practical") {
                                                computerSection.style.display = "block";
                                                loadActiveComputers();
                                            } else {
                                                computerSection.style.display = "none";
                                                softwareDetails.style.display = "none";
                                            }
                                        });

                                        // ✅ Fetch available computers (active only)
                                        function loadActiveComputers() {
                                            computerSelect.innerHTML = '<option value="">Pick a Computer</option>';

                                            fetch('/get-computers')
                                                .then(response => {
                                                    if (!response.ok) {
                                                        throw new Error("Server returned " + response.status);
                                                    }
                                                    return response.json();
                                                })
                                                .then(computers => {
                                                    computers.forEach(computer => {
                                                        let option = document.createElement('option');
                                                        option.value = computer.id;
                                                        option.text = computer.computer_label;
                                                        computerSelect.appendChild(option);
                                                    });
                                                })
                                                .catch(error => {
                                                    console.error("Error loading computers:", error);
                                                    alert("Unable to load computers. Please check server logs.");
                                                });
                                        }

                                        // ✅ When student selects a computer → fetch software availability
                                        computerSelect.addEventListener('change', function () {

                                            let computerId = this.value;

                                            if (!computerId) {
                                                softwareDetails.style.display = "none";
                                                return;
                                            }

                                            fetch(`/get-computer-details/${computerId}`)
                                                .then(response => {
                                                    if (!response.ok) {
                                                        throw new Error("Server returned " + response.status);
                                                    }
                                                    return response.json();
                                                })
                                                .then(data => {

                                                softwareBadges.innerHTML = ""; // Clear previous results

                                                Object.entries(data.software).forEach(([software, available]) => {

                                                    let value = (available ?? "").toString().trim().toLowerCase();

                                                    const isAvailable = ["available", "yes", "true", "1", "ok"].includes(value);

                                                    // Create a badge div
                                                    let badge = document.createElement('span');
                                                    badge.classList.add('badge', isAvailable ? 'badge-success' : 'badge-danger');
                                                    badge.style.margin = "3px";
                                                    badge.textContent = software;

                                                    softwareBadges.appendChild(badge);
                                                });

                                                softwareDetails.style.display = "block";
                                            })
                                                .catch(error => {
                                                    console.error("Error loading computer details:", error);
                                                    alert("Cannot load computer details. Check your route or controller.");
                                                });
                                        });

                                    });
                                    </script>


                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create Event</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Event Guide Modal -->
                <div class="modal fade" id="eventGuide" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Event Guide</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    <strong>Colour Guide:</strong>
                                    <div class="row">
                                        <div class="col-6">
                                            <p>Individual Events:</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="mr-2" style="background-color: #d45284ff; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                                <span class="text-small">Exam</span>
                                            </div>

                                            <div class="d-flex align-items-center mb-2">
                                                <span class="mr-2" style="background-color: #55ade3ff; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                                <span class="text-small">Practical</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6"><p>Batch Events</p></div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="mr-2" style="background-color: #961446ff; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                                <span class="text-small">Batch Exam</span>
                                            </div>

                                            <div class="d-flex align-items-center mb-2">
                                                <span class="mr-2" style="background-color: #1b6898ff; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                                <span class="text-small">Batch Practical</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6"><p>Event Status</p></div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="mr-2" style="background-color: #28A745; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                                <span class="text-small">Completed</span>
                                            </div>

                                            <div class="d-flex align-items-center mb-2">
                                                <span class="mr-2" style="background-color: #E0A800; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                                <span class="text-small">Cancelled</span>
                                            </div>

                                            <div class="d-flex align-items-center mb-2">
                                                <span class="mr-2" style="background-color: #C82333; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                                <span class="text-small">Deleted</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6"><p>Other Events</p></div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="mr-2" style="background-color: #FBB05C; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                                <span class="text-small">Holidays</span>
                                            </div>
                                        </div>
                                    </div>
                                </p>
                                <p style="text-align: justify;">
                                    <strong>Creating Batch Events:</strong><br>
                                    Use the "Batch Event" option to schedule events that involve any Batch, such as batch exams or practical sessions. Fill in the required details including date, time, lab, and invigilator.
                                </p>
                                <p style="text-align: justify;">
                                    <strong>Creating Individual Student Events:</strong><br>
                                    Use the "Student Event" option to create events for individual students, such as exams or practical sessions. Provide the student's ID along with other necessary information.
                                </p>
                                <p style="text-align: justify;">
                                    <strong>Marking Events:</strong><br>
                                    Make sure to mark events as "Completed" once they are done. If an event is cancelled or deleted, update its status accordingly to keep the records accurate.
                                </p>
                                <p style="text-align: justify;">
                                    <strong>Computer Selection for Practical Events:</strong><br>
                                    When scheduling a practical event for an individual student, selecting a computer is mandatory. This ensures that the student has access to the required resources during their practical session. <br>
                                    After selecting a computer for a practical event, the system will display the software installed on that computer. This helps in verifying if the necessary software is available for the student's practical work.
                                </p>
                                <p style="text-align: justify;">
                                    <strong>Reservation Availability:</strong><br>
                                    Systems works as FIFO (First In First Out) basis. If a slot is already booked for a particular date and time, new reservations cannot be made for that same slot.
                                    Also no one can reserve a any lab, any slot on a holiday.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

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