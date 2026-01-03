@extends('layouts.master')

@section('title', 'Computers')
@section('nav', 'computers')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Computers</h1>
                <div class="top-right-button-container">
                    <button type="button" class="btn btn-primary btn-lg top-right-button mr-1" data-toggle="modal" data-target="#addSoftwareModal">ADD NEW SOFTWARE</button>
                </div>
                
                <div class="separator mb-5"></div>

                <div class="row mb-4">
                    
                    <div class="col-lg-12 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h5 class="card-title">Light Heading</h5> -->

                                <table class="table table-responsive-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Label</th>
                                            <th scope="col">LAB</th>
                                            <th scope="col">Software</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($computers as $pc)
                                            <tr>
                                                <td>{{ $pc->computer_label }}</td>
                                                
                                                <td>{{ $pc->lab->lab_name ?? 'N/A' }}</td>

                                                <!-- SOFTWARE COLUMN -->
                                                <td>
                                                    @foreach($pc->software as $sw)
                                                        @if($sw->pivot->availability === 'Available')
                                                            <span class="badge badge-success">
                                                                ✔ {{ $sw->name }}
                                                            </span>
                                                        @else
                                                            <span class="badge badge-danger">
                                                                ✘ {{ $sw->name }}
                                                            </span>
                                                        @endif
                                                        <br>
                                                    @endforeach
                                                </td>

                                                <!-- STATUS COLUMN -->
                                                <td>
                                                    @if($pc->status === 'active')
                                                        <span class="badge badge-success">Active</span>
                                                    @elseif($pc->status === 'slow')
                                                        <span class="badge badge-warning">Slow</span>
                                                    @elseif($pc->status === 'too_slow')
                                                        <span class="badge badge-danger">Too Slow</span>
                                                    @else
                                                        <span class="badge badge-secondary">{{ $pc->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <label class="custom-control mb-0 align-self-center pr-4">
                                                        <a href="javascript:void(0)"
                                                            class="openComputerModal"
                                                            data-id="{{ $pc->id }}"
                                                            data-computer_label="{{ $pc->computer_label }}"
                                                            data-status="{{ $pc->status }}"
                                                            data-lab="{{ $pc->lab->lab_name ?? 'N/A' }}"
                                                            data-software='@json(
                                                                    $pc->software->map(fn($s) => [
                                                                        "id" => $s->id,
                                                                        "name" => $s->name,
                                                                        "availability" => $s->pivot->availability
                                                                    ])
                                                            )'>
                                                                <span class="simple-icon-note"></span>
                                                        </a>
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Edit Computer Modal -->
    <div class="modal fade" id="computerEditModal" tabindex="-1">
        <div class="modal-dialog modal-md">
            <form id="computerEditForm">
                @csrf
                <input type="hidden" id="computer_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Computer</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Computer Label</label>
                            <input type="text" class="form-control" id="computer_label" readonly>
                        </div>

                        <div class="form-group">
                            <label>Lab</label>
                            <input type="text" class="form-control" id="lab" readonly>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="too_slow">Too Slow</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Installed Software</label>
                            <div id="softwareCheckboxes"></div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Software Modal -->
    <div class="modal fade" id="addSoftwareModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Software</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('addSoftware') }}">
                    @csrf
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="software_name">Software Name *</label>
                                    <input type="text" class="form-control" id="software_name" name="software_name"
                                        placeholder="Enter Software Name" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).on('click', '.openComputerModal', function () {

            const softwareList = $(this).data('software');

            $('#computer_id').val($(this).data('id'));
            $('#computer_label').val($(this).data('computer_label'));
            $('#lab').val($(this).data('lab'));
            $('#status').val($(this).data('status'));

            let html = '';

            softwareList.forEach(sw => {
                html += `
                    <div class="custom-control custom-checkbox mb-1">
                        <input type="checkbox"
                            class="custom-control-input software-checkbox"
                            id="software_${sw.id}"
                            data-id="${sw.id}"
                            ${sw.availability === 'Available' ? 'checked' : ''}>
                        <label class="custom-control-label" for="software_${sw.id}">
                            ${sw.name}
                        </label>
                    </div>
                `;
            });

            $('#softwareCheckboxes').html(html);

            $('#computerEditModal').modal('show');
        });
    </script> 

    <script>
        $('#computerEditForm').on('submit', function (e) {
            e.preventDefault();

            const software = [];

            $('.software-checkbox').each(function () {
                software.push({
                    id: $(this).data('id'),
                    availability: $(this).is(':checked') ? 'Available' : 'N/A'
                });
            });

            $.ajax({
                url: '/computers/' + $('#computer_id').val(),
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify({
                    status: $('#status').val(),
                    software: software
                }),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (res) {
                    $.notify(
                        {
                            message: 'Computer updated successfully'
                        },
                        {
                            type: 'success',
                            delay: 3000,
                            placement: {
                                from: 'top',
                                align: 'right'
                            }
                        }
                    );

                    $('#computerEditModal').modal('hide');

                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>



@endsection