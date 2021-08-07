@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('classroom.index') }}" class="btn btn-primary">My Classrooms</a>
                    <a href="{{ route('join.request.sent') }}" class="btn btn-primary">Join Requests</a>
                    <a href="{{ route('classroom.as.student') }}" class="btn btn-primary">Joined Classrooms</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
