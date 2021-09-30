@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-10">
                                <h3>Resources of <a style="text-decoration: none;" href="{{ route('classroom.show', $classroom->id) }}">{{ $classroom->name }}</a></h3>
                            </div>
                            @if ($classroom->isTeacher())
                                <div class="col-md-2">
                                    <a href="{{ route('classroom.resource.add', $classroom->id) }}" class="btn btn-block btn-primary">Add Resource</a>
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
                            @if (count($classroom->resource))
                                @foreach($classroom->resource as $resource)
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $resource->name }}</h5>
                                                <p class="card-text">Description: {!! $resource->description ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                                <p class="card-text">Type: {!! $resource->type ?: '<span class="badge badge-danger">Not Set Yet</span>'  !!}</p>
                                                @if ($resource->url)
                                                    <p class="card-text">URL: {!! $resource->url ?: '<span class="badge badge-danger">Not Set Yet</span>' !!}</p>
                                                @endif
                                                @if ($resource->location)
                                                    <a href="{{ asset('storage/'. $resource->location) }}" class="btn btn-info" target="_blank">Open Resource</a>
                                                @endif
                                                @if($classroom->isTeacher() && 0)
                                                    <a href="{{ route('classroom.edit', $resource->id) }}" class="btn btn-info"><i class="far fa-edit"></i></a>
                                                    <a href="{{ route('classroom.add.student', $resource->id) }}" class="btn btn-primary"><i class="far fa-user"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-sm-12">
                                    <h3 class="text-center">No Resource Found</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
