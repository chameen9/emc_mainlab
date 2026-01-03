@extends('layouts.master')

@section('title', 'Batches')
@section('nav', 'batches')

@section('content')
    <div class="container-fluid disable-text-selection">
        <div class="row">
            <div class="col-12">
                <div class="mb-2">
                    <h1>Batches</h1>
                    <div class="top-right-button-container">
                        <button type="button" class="btn btn-primary btn-lg top-right-button mr-1" data-toggle="modal" data-target="#batchAddModal">ADD NEW</button>
                    </div>
                    
                </div>

                <div class="mb-2">
                    <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions"
                        role="button" aria-expanded="true" aria-controls="displayOptions">
                        Display Options
                        <i class="simple-icon-arrow-down align-middle"></i>
                    </a>
                    <div class="collapse dont-collapse-sm" id="displayOptions">
                        
                        <div class="d-block d-md-inline-block">
                            <div class="btn-group float-md-left mr-1 mb-1">
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown"
                                        id="courseDropdown">
                                    Course
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item course-item" data-course="all" href="#">All Courses</a>
                                    @foreach($courses as $course)
                                        <a class="dropdown-item course-item"
                                        data-course="{{ $course->id }}"
                                        href="#">
                                            {{ $course->course_code }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="btn-group float-md-left mr-1 mb-1">
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown"
                                        id="statusDropdown">
                                    Active
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($statuses as $status)
                                        <a class="dropdown-item status-item"
                                        data-status="{{ $status->status }}"
                                        href="#">
                                            {{ ucwords(str_replace('_', ' ', strtolower($status->status))) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <div class="float-md-right">
                            <span class="text-muted text-small">{{ count($batches) }} batches</span>
                        </div>
                    </div>
                </div>
                <div class="separator mb-5"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 list" id="batchList">
                @include('layouts.batchlist', ['batches' => $batches])
                
            </div>
        </div>
    </div>

    <!-- Add Batch Modal -->
    <div class="modal fade" id="batchAddModal" tabindex="-1">
        <div class="modal-dialog modal-md">
            <form  method="POST" action="{{ route('batches.store') }}">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Batch</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Batch Number</label>
                            <input type="text" class="form-control" name="batch_number" placeholder="Ex: DiIT 123" required>
                        </div>

                        <div class="form-group">
                            <label>Course</label>
                            <select class="form-control" name="course_id" required>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Active">Active</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Owner</label>
                            <input type="text" name="owner" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Student Count</label>
                            <input type="number" name="student_count" class="form-control" required min="1" step="1">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Batch Modal -->
    <div class="modal fade" id="batchEditModal" tabindex="-1">
        <div class="modal-dialog modal-md">
            <form id="batchEditForm">
                @csrf
                <input type="hidden" id="batch_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Batch</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Batch Number</label>
                            <input type="text" class="form-control" id="batch_number" readonly>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="status">
                                <option value="Scheduled">Scheduled</option>
                                <option value="Active">Active</option>
                                <option value="Delivery_Completed">Delivery Completed</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Owner</label>
                            <input type="text" class="form-control" id="owner">
                        </div>

                        <div class="form-group">
                            <label>Student Count</label>
                            <input type="number" class="form-control" id="student_count">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).on('click', '.openBatchModal', function () {

            $('#batch_id').val($(this).data('id'));
            $('#batch_number').val($(this).data('batch_number'));
            $('#status').val($(this).data('status'));
            $('#owner').val($(this).data('owner'));
            $('#student_count').val($(this).data('student_count'));

            $('#batchEditModal').modal('show');
        });
    </script>

    <script>
        $('#batchEditForm').on('submit', function (e) {
            e.preventDefault();

            const id = $('#batch_id').val();

            $.ajax({
                url: `/batches/${id}`,
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: $('#status').val(),
                    owner: $('#owner').val(),
                    student_count: $('#student_count').val()
                },
                success: function () {
                    $('#batchEditModal').modal('hide');
                    location.reload(); // optional, remove if using live DOM updates
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {

            let selectedCourse = 'all';
            let selectedStatus = 'Active'; // default

            function loadBatches() {
                $.ajax({
                    url: "{{ route('filterBatches') }}",
                    type: "GET",
                    data: {
                        course: selectedCourse,
                        status: selectedStatus
                    },
                    success: function (response) {
                        $('.list').html(response.html);
                    }
                });
            }

            // Course selection
            $(document).on('click', '.course-item', function (e) {
                e.preventDefault();

                selectedCourse = $(this).data('course');
                $('#courseDropdown').text($(this).text());

                loadBatches();
            });

            // Status selection
            $(document).on('click', '.status-item', function (e) {
                e.preventDefault();

                selectedStatus = $(this).data('status');
                $('#statusDropdown').text($(this).text());

                loadBatches();
            });

            // Initial load (Active + all courses)
            loadBatches();
        });
    </script>



@endsection