@extends('layouts.app')

@push('css')
    <style>
        .card-box {
            position: relative;
            color: #fff;
            padding: 20px 10px 40px;
            margin: 20px 0px;
        }

        .card-box:hover {
            text-decoration: none;
            color: #f1f1f1;
        }

        .card-box:hover .icon i {
            font-size: 100px;
            transition: 1s;
            -webkit-transition: 1s;
        }

        .card-box .inner {
            padding: 5px 10px 0 10px;
        }

        .card-box h3 {
            font-size: 27px;
            font-weight: bold;
            margin: 0 0 8px 0;
            white-space: nowrap;
            padding: 0;
            text-align: left;
        }

        .card-box p {
            font-size: 15px;
        }

        .card-box .icon {
            position: absolute;
            top: auto;
            bottom: 5px;
            right: 5px;
            z-index: 0;
            font-size: 72px;
            color: rgba(0, 0, 0, 0.15);
        }

        .card-box .card-box-footer {
            position: absolute;
            left: 0px;
            bottom: 0px;
            text-align: center;
            padding: 3px 0;
            color: rgba(255, 255, 255, 0.8);
            background: rgba(0, 0, 0, 0.1);
            width: 100%;
            text-decoration: none;
        }

        .card-box:hover .card-box-footer {
            background: rgba(0, 0, 0, 0.3);
        }

        .bg-blue {
            background-color: #00c0ef !important;
        }

        .bg-green {
            background-color: #00a65a !important;
        }

        .bg-orange {
            background-color: #f39c12 !important;
        }

        .bg-red {
            background-color: #d9534f !important;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="card-box bg-blue">
                                    <div class="inner">
                                        <h3> My Classroom </h3>
                                        <p>&nbsp;</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                    </div>
                                    <a href="{{ route('classroom.index') }}" class="card-box-footer">View More <i
                                            class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="card-box bg-green">
                                    <div class="inner">
                                        <h3> Join Requests </h3>
                                        <p>&nbsp;</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                                    </div>
                                    <a href="{{ route('join.request.sent') }}" class="card-box-footer">View More <i
                                            class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <div class="card-box bg-orange">
                                    <div class="inner">
                                        <h3>Joined Classrooms</h3>
                                        <p> &nbsp; </p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                    </div>
                                    <a href="{{ route('classroom.as.student') }}" class="card-box-footer">View More <i
                                            class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
