@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-10">
                                @if (Route::currentRouteName() == 'join.request.sent')
                                    <h3>Requests You Send</h3>
                                @elseif (Route::currentRouteName() == 'join.request.received')
                                    <h3>Requests You Have</h3>
                                @endif
                            </div>
                            <div class="col-md-2">
                            @if (Route::currentRouteName() == 'join.request.sent')
                                <a href="{{ route('join.request.received') }}" class="btn btn-block btn-success">Requests You Have</a>
                            @elseif (Route::currentRouteName() == 'join.request.received')
                                <a href="{{ route('join.request.sent') }}" class="btn btn-block btn-success">Requests You Send</a>
                            @endif
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
                                @endphp
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $classroom->name }}</h5>
                                            <p class="card-text">Subject: {!! $classroom->subject ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                            <p class="card-text">Section: {!! $classroom->section ?: '<span class="badge badge-danger">Not Set Yet</span>'  !!}</p>
                                            <p class="card-text">Room: {!! $classroom->room ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                            <p class="card-text">Class Code: <b>{!! $classroom->class_code !!}</b></p>
                                            <a href="{{ route('classroom.show', $classroom->id) }}" class="btn btn-primary">Enter Classroom</a>
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

