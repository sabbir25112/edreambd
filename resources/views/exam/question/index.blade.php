@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-10">
                                <h3>Questions of <a href="{{ route('classroom.exam', $exam->classroom->id) }}" style="text-decoration: none;">{{ $exam->name }}</a></h3>
                            </div>
                            @if ($exam->isEditable())
                                <div class="col-md-2">
                                    <a href="{{ route('classroom.exam.question.create', $exam->id) }}" class="btn btn-block btn-success">Create</a>
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
                            @if (count($questions))
                                @foreach($questions as $question)
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $question->question }}</h5>
                                                <div class="col-sm-3"></div>
                                                <p class="card-text">Option 1: {!! $question->option_1 ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                                <p class="card-text">Option 2: {!! $question->option_2 ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                                <p class="card-text">Option 3: {!! $question->option_3 ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                                <p class="card-text">Option 4: {!! $question->option_4 ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                                <p class="card-text">Answer: {!! $question->answer_text ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                                <p class="card-text">Mark: {!! $question->mark ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                                @if($question->exam->classroom->isTeacher() && $question->exam->isEditable())
                                                    <a href="{{ route('classroom.exam.question.edit', ['exam' => $question->exam->id, 'question' => $question->id]) }}" class="btn btn-info"><i class="far fa-edit"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-sm-12">
                                    <h3 class="text-center">No Question Found</h3>
                                </div>
                            @endif
                        </div>
                        <br>
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

