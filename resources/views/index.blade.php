@extends('layouts.master')

@section('title', 'Home')
@section('nav', 'dashboard')

@section('content')
    
    <div class="container-fluid">
        <div class="row  ">
            <div class="col-12">

                <h1>Dashboard</h1>
                
                <div class="separator mb-5"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 mb-4">
                <div class="card dashboard-filled-line-chart">
                    <div class="card-body ">
                        <div class="float-left float-none-xs">
                            <div class="d-inline-block">
                                <h5 class="d-inline">Overall Usage</h5>
                                <span class="text-muted text-small d-block">{{ $currentMonth }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="chart card-body pt-0">
                        <canvas id="studentUsageChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12 col-lg-6 col-xl-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Status Comparison - {{$currentMonth}}</h5>
                        <div class="dashboard-donut-chart chart">
                            <canvas id="comparisonChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4 mb-4">
                <div class="card dashboard-progress">
                    <div class="position-absolute card-top-buttons">
                        <button class="btn btn-header-light icon-button">
                            <i class="simple-icon-refresh"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Statistics - {{$currentMonth}}</h5>
                        <div class="mb-4">
                            <p class="mb-2">Exams - Individual
                                <span class="float-right text-muted">{{ $completedExamCount }}/{{ $scheduledExamCount }}</span>
                            </p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{ $completedExamPercentage }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="mb-2">Practical - Individual
                                <span class="float-right text-muted">{{ $completedPracticalCount }}/{{ $scheduledPracticalCount }}</span>
                            </p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{ $completedPracticalPercentage }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="mb-2">Batch Exams
                                <span class="float-right text-muted">{{ $completedBatchExamCount }}/{{ $scheduledBatchExamCount }}</span>
                            </p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{ $completedBatchExamPercentage }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="mb-2">Batch Practicals
                                <span class="float-right text-muted">{{ $completedBatchPracticalCount }}/{{ $scheduledBatchPracticalCount }}</span>
                            </p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{ $completedBatchPracticalPercentage }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="mb-2">This counts only valids for {{ $currentMonth }}.
                            </p>
                            
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-4">
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="card dashboard-small-chart-analytics">
                            <div class="card-body">
                                <p class="lead color-theme-1 mb-1 value">{{$thisWeekStartDate}} - {{$thisWeekEndDate}}</p>
                                <p class="mb-0 label text-small">Individual</p>
                                <br>
                                <h1>{{$thisWeekExamPracticalCount}}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card dashboard-small-chart-analytics">
                            <div class="card-body">
                                <p class="lead color-theme-1 mb-1 value">{{$thisWeekStartDate}} - {{$thisWeekEndDate}}</p>
                                <p class="mb-0 label text-small">Batches</p>
                                <br>
                                <h1>{{$thisWeekBatchExamPracticalCount}}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card dashboard-small-chart-analytics">
                            <div class="card-body">
                                <p class="lead color-theme-1 mb-1 value">{{$thisMonthStartDate}} - {{$thisMonthEndDate}}</p>
                                <p class="mb-0 label text-small">Individual</p>
                                <br>
                                <h1>{{$thisMonthExamPracticalCount}}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card dashboard-small-chart-analytics">
                            <div class="card-body">
                                <p class="lead color-theme-1 mb-1 value">{{$thisMonthStartDate}} - {{$thisMonthEndDate}}</p>
                                <p class="mb-0 label text-small">Batches</p>
                                <br>
                                <h1>{{$thisMonthBatchExamPracticalCount}}</h1>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-xl-3 col-lg-6 mb-4">
                <div class="card">
                    
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><span class="simple-icon-fire"></span> Trending in {{$lastMonth}}</h6>
                        
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 mb-4">
                <div class="card">
                    
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><span class="iconsminds-student-male-female"></span> Batch : {{$TrendingBatch ? $TrendingBatch->batch : 'No Trending Batch'}}</h6>
                        
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 mb-4">
                <div class="card">
                    
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><span class="iconsminds-student-male"></span>Student : {{$TrendingStudent ? $TrendingStudent->student_id : 'No Trending Student'}}</h6>
                        
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 mb-4">
                <div class="card">
                    
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><span class="iconsminds-calendar-4"></span>Busiest Day : {{$busiestDay ? $busiestDay->booking_date : 'No Busiest Day'}}</h6>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
    
@endsection