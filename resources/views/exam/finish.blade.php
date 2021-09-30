@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-10">
                                <h3>Exam Finished</h3>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('classroom.show', $exam->classroom->id) }}" class="btn btn-block btn-success">Back to Classroom</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            {{ $message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

