@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-10">
                                <h3>Requests You Have</h3>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('join.request.sent') }}" class="btn btn-block btn-success">Requests You Send</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            @foreach($join_requests as $join_request)
                                @php
                                    $classroom = $join_request->classroom;
                                    $student = $join_request->student;
                                    $status_badge = 'primary';
                                    if ($join_request->status == 'PENDING') {
                                        $status_badge = 'primary';
                                    } elseif ($join_request->status == 'ACCEPTED') {
                                        $status_badge = 'success';
                                    } elseif ($join_request->status == 'REJECTED') {
                                        $status_badge = 'danger';
                                    }
                                @endphp
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $classroom->name }} <span class="badge badge-{{ $status_badge }}">{{ $join_request->status }}</span></h5>
                                            <p class="card-text">Subject: {!! $classroom->subject ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                            <p class="card-text">Section: {!! $classroom->section ?: '<span class="badge badge-danger">Not Set Yet</span>'  !!}</p>
                                            <p class="card-text">Room: {!! $classroom->room ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                            <p class="card-text">Class Code: <b>{!! $classroom->class_code !!}</b></p>
                                            <p class="card-text">Student Name: <b>{!! $student->name !!}</b></p>
                                            @if ($join_request->status == 'PENDING')
                                                <a href="{{ route('join.request.accept', $join_request->id) }}" class="btn btn-success">Accept</a>
                                                <a href="{{ route('join.request.reject', $join_request->id) }}" class="btn btn-danger">Reject</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        {{ $join_requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

