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
                        <button type="button" class="btn btn-primary btn-lg top-right-button mr-1">ADD NEW</button>
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
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Course
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($courses as $course)
                                        <a class="dropdown-item" href="#">{{ $course->course_code }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="btn-group float-md-left mr-1 mb-1">
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Status
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($statuses as $status)
                                        <a class="dropdown-item" href="#">{{ $status->status }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="float-md-right">
                            <span class="text-muted text-small">Displaying 1-10 of 210 items </span>
                            <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                20
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">10</a>
                                <a class="dropdown-item active" href="#">20</a>
                                <a class="dropdown-item" href="#">30</a>
                                <a class="dropdown-item" href="#">50</a>
                                <a class="dropdown-item" href="#">100</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="separator mb-5"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 list" data-check-all="checkAll">

                @foreach($batches as $batch)
                    <div class="card d-flex flex-row mb-3">
                        <div class="d-flex flex-grow-1 min-width-zero">
                            <div
                                class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                <a class="list-item-heading mb-0 truncate w-30 w-xs-100" href="#">
                                    {{ $batch->batch_number }}
                                </a>
                                <p class="mb-0 text-muted text-small w-15 w-xs-100">{{$batch->student_count}}</p>
                                <p class="mb-0 text-muted text-small w-15 w-xs-100">{{$batch->course_code}}</p>
                                <p class="mb-0 text-muted text-small w-15 w-xs-100">{{$batch->owner}}</p>
                                <div class="w-15 w-xs-100">
                                    @if($batch->status === 'Scheduled')
                                        <span class="badge badge-pill badge-primary">Scheduled</span>
                                    @elseif($batch->status === 'Active')
                                        <span class="badge badge-pill badge-success">Active</span>
                                    @elseif($batch->status === 'Delivery_Completed')
                                        <span class="badge badge-pill badge-info">Delivery Completed</span>
                                    @elseif($batch->status === 'Completed')
                                        <span class="badge badge-pill badge-secondary">Completed</span>
                                    @else
                                        <span class="badge badge-pill badge-dark">{{ $batch->status }}</span>
                                    @endif
                                </div>
                            </div>
                            <label class="custom-control custom-checkbox mb-1 align-self-center pr-4">
                                <span class="iconsminds-file-edit"></span>
                            </label>
                        </div>
                    </div>
                @endforeach


                <nav class="mt-4 mb-3">
                    <ul class="pagination justify-content-center mb-0">
                        <li class="page-item ">
                            <a class="page-link first" href="#">
                                <i class="simple-icon-control-start"></i>
                            </a>
                        </li>
                        <li class="page-item ">
                            <a class="page-link prev" href="#">
                                <i class="simple-icon-arrow-left"></i>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item ">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item ">
                            <a class="page-link next" href="#" aria-label="Next">
                                <i class="simple-icon-arrow-right"></i>
                            </a>
                        </li>
                        <li class="page-item ">
                            <a class="page-link last" href="#">
                                <i class="simple-icon-control-end"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection