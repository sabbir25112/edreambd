@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <h3>Edit {{ $exam->name }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <form method="POST" action="{{ route('classroom.exam.update', $exam->id) }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }} (Required)</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $exam->name }}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="duration" class="col-md-4 col-form-label text-md-right">Duration (in Minutes)</label>

                                    <div class="col-md-6">
                                        <input type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') ?? $exam->duration }}">

                                        @error('duration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="start_at" class="col-md-4 col-form-label text-md-right">Start At</label>

                                    <div class="col-md-6">
                                        <input type="datetime-local" class="form-control @error('start_at') is-invalid @enderror" name="start_time" value="{{ old('start_time') ?? $exam->start_time_iso }}">

                                        @error('start_at')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Update Exam
                                        </button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

