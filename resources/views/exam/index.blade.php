@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-10">
                                <h3>Exams of <a href="{{ route('classroom.show', $classroom->id) }}" style="text-decoration: none;">{{ $classroom->name }}</a></h3>
                            </div>
                            @if ($classroom->isTeacher())
                                <div class="col-md-2">
                                    <a href="{{ route('classroom.exam.create', $classroom->id) }}" class="btn btn-block btn-success">Create</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            @if (count($exams))
                                @foreach($exams as $exam)
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $exam->name }}</h5>
                                                <p class="card-text">Duration: {!! $exam->duration . ' Minute(s)' ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                                <p class="card-text">Start Time: {!! Carbon\Carbon::create($exam->start_time)->toDayDateTimeString() ?: '<span class="badge badge-danger">Not Set Yet</span>'  !!}</p>

                                                @if($classroom->isTeacher())
                                                    <p class="card-text">Question: {!! $exam->questions->count() > 0 ? '<b>' . $exam->questions->count() . '</b>' : '<span class="badge badge-danger">Not Set Yet</span>'  !!}</p>
                                                    <a href="{{ route('classroom.exam.question', $exam->id) }}" class="btn btn-success"><i class="far fa-question-circle"></i></a>
                                                    @if ($exam->isEditable())
                                                        <a href="{{ route('classroom.exam.edit', $exam->id) }}" class="btn btn-info"><i class="far fa-edit"></i></a>
                                                    @endif
                                                @endif

                                                @if($classroom->isStudent() && $exam->isRunning())
                                                    <a href="{{ route('classroom.exam.enter', $exam->id) }}" class="btn btn-info">Enter Exam</a>
                                                @endif

                                                @if ($exam->isEnded())
                                                    <a href="{{ route('classroom.exam.result', $exam->id) }}" class="btn btn-success">Show Result</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-sm-12">
                                    <h3 class="text-center">No Exam Found</h3>
                                </div>
                            @endif
                        </div>
                        <br>
                        {{ $exams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

