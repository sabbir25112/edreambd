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
                            <tr class="text-center">
                                <th>SL</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Mark</th>
                                <th scope="col">Total Correct Answer</th>
                                <th scope="col">Total Correct Answer</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($exam_sheets as $index => $exam_sheet)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <th scope="row">
                                        <a href="{{ route('classroom.exam.result.individual', ['exam' => $exam->id, 'student' => $exam_sheet->student_id]) }}">
                                            {{ $exam_sheet->student->name }}
                                        </a>
                                    </th>
                                    <td>{{ $exam_sheet->mark }}</td>
                                    <td>{!! '<span class="badge badge-success">'. $exam_sheet->correct_answer .'</span>' !!}</td>
                                    <td>{!! '<span class="badge badge-danger">'. $exam_sheet->incorrect_answer .'</span>' !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
