@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <h3>{{ $classroom->name }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a href="{{ route('classroom.resource', $classroom->id) }}" class="btn btn-primary">Resources</a>

                        @if ($classroom->isTeacher())
                            <a href="{{ route('classroom.attendance', $classroom->id) }}" class="btn btn-primary">Attendance</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
