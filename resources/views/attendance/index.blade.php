@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <form action="{{ route('classroom.attendance', $classroom_id) }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Attendance of <a style="text-decoration: none;" href="{{ route('classroom.show', $classroom->id) }}">{{ $classroom->name }}</a></h3>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" name="date" value="{{ request()->get('date') }}" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-block btn-success">Search</button>
                                </div>
                            </div>
                        </form>
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
                                <th scope="col">Student Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <th scope="row">{{ $student->name }}</th>
                                    <td>{{ $date->toDateString() }}</td>
                                    @if (in_array($student->id, $attendance))
                                        <td>{!! '<span class="badge badge-success">Present</span>' !!}</td>
                                    @else
                                        <td>{!! '<span class="badge badge-danger">Absent</span>' !!}</td>
                                    @endif

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
