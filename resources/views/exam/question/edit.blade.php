@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <h3>Edit Question For {{ $exam->name }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <form method="POST" action="{{ route('classroom.exam.question.update', ['exam' => $question->exam->id, 'question' => $question->id]) }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="question" class="col-md-4 col-form-label text-md-right">Question</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question') ?? $question->question }}" required autocomplete="question" autofocus>

                                        @error('question')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="option_1" class="col-md-4 col-form-label text-md-right">Option 1</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('option_1') is-invalid @enderror" name="option_1" value="{{ old('option_1') ?? $question->option_1 }}">

                                        @error('option_1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="option_2" class="col-md-4 col-form-label text-md-right">Option 2</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('option_2') is-invalid @enderror" name="option_2" value="{{ old('option_2') ?? $question->option_2 }}">

                                        @error('option_2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="option_3" class="col-md-4 col-form-label text-md-right">Option 3</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('option_3') is-invalid @enderror" name="option_3" value="{{ old('option_3') ?? $question->option_3 }}">

                                        @error('option_3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="option_4" class="col-md-4 col-form-label text-md-right">Option 4</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('option_4') is-invalid @enderror" name="option_4" value="{{ old('option_4') ?? $question->option_4 }}">

                                        @error('option_4')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="option_4" class="col-md-4 col-form-label text-md-right">Correct Answer</label>

                                    <div class="col-md-6">
                                        @php
                                            $answers = $question->answer_array;
                                        @endphp
                                        <select name="answer[]" multiple class="form-control">
                                            <option value="1" @if (in_array(1, $answers)) selected @endif>Option 1</option>
                                            <option value="2" @if (in_array(2, $answers)) selected @endif>Option 2</option>
                                            <option value="3" @if (in_array(3, $answers)) selected @endif>Option 3</option>
                                            <option value="4" @if (in_array(4, $answers)) selected @endif>Option 4</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mark" class="col-md-4 col-form-label text-md-right">Mark</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('mark') is-invalid @enderror" name="mark" value="{{ old('mark') ?? $question->mark}}">

                                        @error('mark')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Update Question
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

