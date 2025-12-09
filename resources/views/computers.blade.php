@extends('layouts.master')

@section('title', 'Computers')
@section('nav', 'computers')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Computers</h1>
                
                <div class="separator mb-5"></div>

                <div class="row mb-4">
                    
                    <div class="col-lg-12 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h5 class="card-title">Light Heading</h5> -->

                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Label</th>
                                            <th scope="col">LAB</th>
                                            <th scope="col">Software</th>
                                            <th scope="col">Status</th>
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