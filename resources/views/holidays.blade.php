@extends('Layouts.master')

@section('title', 'Holidays')
@section('nav', 'holidays')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="mb-2">
                    <h1>Holidays</h1>
                    <div class="top-right-button-container">
                        <a href="#newHolidayModal" type="button" class="btn btn-primary btn-lg top-right-button mr-1" data-toggle="modal">ADD NEW</a>
                    </div>
                    
                </div>
                
                <div class="separator mb-5"></div>

                <div class="row mb-4">
                    
                    <div class="col-lg-9 col-md-9 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h5 class="card-title">Light Heading</h5> -->

                                <table class="table table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>Holiday</th>
                                            <th>Date</th>
                                            <th>Affected LABs</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $grouped = $holidays->groupBy('title')->map(function($items) {
                                                return $items->groupBy(function($item) {
                                                    return $item->start . ' - ' . $item->end;
                                                })->map(function($group) {
                                                    return [
                                                        'title' => $group->first()->title,
                                                        'date' => $group->first()->start . ' - ' . $group->first()->end,
                                                        'labs' => $group->pluck('lab_id')->unique()->join(', '),
                                                        'description' => $group->first()->description
                                                    ];
                                                });
                                            })->flatten(1)->unique('title');
                                        @endphp

                                        @foreach($grouped as $holiday)
                                            <tr>
                                                <td>{{ $holiday['title'] }}</td>
                                                <td>{{ $holiday['date'] }}</td>
                                                <td>
                                                    @php
                                                        $labIds = explode(', ', $holiday['labs']);
                                                    @endphp
                                                    @foreach($labIds as $labId)
                                                        @php
                                                            $labName = \App\Models\Lab::find($labId)->lab_name ?? 'Unknown Lab';
                                                        @endphp
                                                        <span>{{ $labName }}</span><br>
                                                    @endforeach
                                                </td>
                                                
                                                <td>
                                                    <form action="{{ route('deleteHoliday') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="holiday_title" value="{{ $holiday['title'] }}">
                                                        <input type="hidden" name="holiday_date" value="{{ $holiday['date'] }}">
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Upcoming Holidays</h5>
                                <p class="card-text">Holidays affect all Computer Labs and no one can reserve a slot in the selected date(s).</p>  
                                <div id="holidayList">
                                    <p class="text-muted text-small mb-0">Loading holidays...</p>
                                </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- New Holiday Modal -->
    <div class="modal fade" id="newHolidayModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Holiday</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('addHoliday') }}">
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
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="lab">Description</label>
                                    <input type="text" name="description" class="form-control" id="description" placeholder="Enter your description here" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <p>This Holidays affects all Computer Labs and no one can reserve a slot in this selected date.</p>
                            </div>
                        </div>


                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Holiday</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fethch and display holidays -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {

            $.ajax({
                url: '/get-holidays',
                type: 'GET',
                success: function (response) {

                    let holidays = response.holidays ?? [];
                    let html = '';

                    if (holidays.length === 0) {
                        html = '<p class="text-muted text-small mb-0">No holidays found</p>';
                    } else {
                        holidays.forEach(holiday => {

                            let types = holiday.type.join(', ');
                            let startDate = new Date(holiday.start).toLocaleDateString();
                            let endDate = new Date(holiday.end).toLocaleDateString();

                            html += `
                                <div class="mb-3">
                                    <div class="font-weight-bold">${holiday.name}</div>
                                    <div class="text-muted text-small">
                                        ${startDate}${holiday.start !== holiday.end ? ' - ' + endDate : ''}
                                    </div>
                                    <span class="badge badge-pill badge-outline-info mt-1">
                                        ${types}
                                    </span>
                                </div>
                            `;
                        });
                    }

                    $('#holidayList').html(html);
                },
                error: function () {
                    $('#holidayList').html(
                        '<p class="text-danger text-small mb-0">Failed to load holidays</p>'
                    );
                }
            });

        });
    </script>



@endsection