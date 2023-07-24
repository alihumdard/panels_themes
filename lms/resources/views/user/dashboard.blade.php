@extends('user.layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="overview-wrap">
                    <h2 class="title-1">Dashboard</h2>
                </div>
            </div>
        </div>
        <div class="row m-t-25">
            @foreach($courses as $course)
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="text">
                                    <h2>{{$course->title}}</h2>
                                    <span>Test Start Date: {{$course->start_date}}</span><br>
                                    <span>Test End Date: {{$course->end_date}}</span>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-outline-success">Success</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
