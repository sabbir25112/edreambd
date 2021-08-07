@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-10">
                                <h3>Requests You Send</h3>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('join.request.received') }}" class="btn btn-block btn-success">Requests You Have</a>
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
                                            @if ($join_request->status == 'ACCEPTED')
                                                <a href="{{ route('classroom.show', $classroom->id) }}" class="btn btn-primary">Enter Classroom</a>
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

