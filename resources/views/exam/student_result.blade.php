@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-10">
                                <h3>Result of <a href="{{ route('classroom.exam', $exam->classroom_id) }}" style="text-decoration: none;">{{ $exam->name }}</a></h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Question</th>
                                <th scope="col">Your Answer</th>
                                <th scope="col">Correct Answer</th>
                                <th scope="col">Status</th>
                                <th scope="col">Mark</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $total_mark = 0;
                            @endphp
                            @foreach($exam_sheets as $exam_sheet)
                                @php
                                    $option = 'option_' . $exam_sheet->given_answer;
                                    $total_mark += $exam_sheet->mark;
                                @endphp
                                <tr>
                                    <th scope="row">{{ $exam_sheet->question->question }}</th>
                                    <td>{{ $exam_sheet->question->$option }}</td>
                                    <td>{{ $exam_sheet->question->answer_text }}</td>
                                    @if ($exam_sheet->is_correct)
                                        <td>{!! '<span class="badge badge-success">Correct</span>' !!}</td>
                                    @else
                                        <td>{!! '<span class="badge badge-danger">Wrong</span>' !!}</td>
                                    @endif
                                    <td>{{ $exam_sheet->mark }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="4">Total Mark</th>
                                <th>{{ $total_mark }}</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
