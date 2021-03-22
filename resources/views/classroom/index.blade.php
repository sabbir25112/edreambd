@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <h3>Classrooms</h3>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('classroom.create') }}" class="btn btn-block btn-success">Create</a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('classroom.join') }}" class="btn btn-block btn-success">Join</a>
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
                            @foreach($classrooms as $classroom)
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
                        {{ $classrooms->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

