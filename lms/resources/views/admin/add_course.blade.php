@extends('admin.layout.app')

@section('title', 'Add Course')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Add Course</div>
                    <form action="store_course" method="post" enctype="multipart/form-data" id="form">
                        @csrf
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Enter Course Detail</h3>
                            </div>
                            <hr>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="course_title" class="control-label mb-1">Course Title</label>
                                <input id="course_title" name="course_title" type="text" class="form-control" placeholder="Enter Course Title" value="{{ old('course_title') }}" required>
                                @if ($errors->has('course_title'))
                                    <span class="help-block text-danger">
                                        <p>{{ $errors->first('course_title') }}</p>
                                    </span>
                                @endif
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Enter Course Content</h3>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="course_files" class=" form-control-label">Select Multiple Files</label>
                                <input type="file" id="course_files" name="course_files[]" multiple="" class="form-control-file">
                            </div>
                            <div class="form-group" style="text-align: center" >
                            <span class="col-xs-12 col-sm-1">
                                <i class="fa fa-plus add-field" id="target" ref="1"></i>
                            </span>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="video_title" class="control-label mb-1">Video Title</label>
                                        <input id="video_title_1" name="video_title[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="" placeholder="Enter Video Title"  data-val-required="Please enter the video title">
                                        <span class="help-block" data-valmsg-for="video_title" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="video_link" class="control-label mb-1">Video Link</label>
                                        <input id="video_link_1" name="video_link[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="" placeholder="Enter Video Link"  data-val-required="Please enter the video link">
                                        <span class="help-block" data-valmsg-for="video_link" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="target"></div>
                        </div>
                        <div class="card-footer">
                            <button id="course_button" type="submit" class="btn btn-lg btn-primary add-course">
                                <i class="fa fa-dot-circle-o"></i>
                                <span id="payment-button-amount">Save</span>
                                <span id="payment-button-sending" style="display:none;">Sending…</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
