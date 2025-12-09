@extends('layouts.master')

@section('title', 'Students')
@section('nav', 'students')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Students</h1>
                
                <div class="separator mb-5"></div>

                <div class="row mb-4">
                    
                    <div class="col-lg-12 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h5 class="card-title">Light Heading</h5> -->

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Student ID</th>
                                            <th scope="col">Start</th>
                                            <th scope="col">End</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Module</th>
                                            <th scope="col">Batch</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                            <tr>
                                                <td>{{ explode(' ', $student->title)[0] }}</td>
                                                <td>{{ $student->start }}</td>
                                                <td>{{ $student->end }}</td>
                                                <td>{{ $student->description }}</td>
                                                <td>{{ $student->module }}</td>
                                                <td>{{ $student->batch }}</td>
                                                <td>
                                                    @if($student->status === 'Scheduled')
                                                        <span class="badge badge-success">{{ $student->status }}</span>
                                                    @elseif($student->status === 'Cancelled')
                                                        <span class="badge badge-warning">{{ $student->status }}</span>
                                                    @elseif($student->status === 'Deleted')
                                                        <span class="badge badge-danger">{{ $student->status }}</span>
                                                    @else
                                                        <span class="badge badge-secondary">{{ $student->status }}</span>
                                                    @endif
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
@endsection