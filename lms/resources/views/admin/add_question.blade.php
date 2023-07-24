@extends('admin.layout.app')

@section('title', 'Add Question')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Add Question</div>
                    <form action="store_question" method="post" enctype="multipart/form-data" id="form">
                        @csrf
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Enter Question Detail</h3>
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
                                <label for="question_title" class="control-label mb-1">Question Title</label>
                                <input id="question_title" name="question_title" type="text" class="form-control" placeholder="Enter Question Title" value="{{ old('question_title') }}" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="course_id" class=" form-control-label">Select Course</label>
                                        <select name="course_id" id="course_id" class="form-control" required>
                                            <option value="">Please select</option>
                                            @foreach($course_list as $key => $val)
                                                <option value="{{ $key }}" {{ old('course_id') == $key ? 'selected' : '' }}> {{ $val }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="response_type" class=" form-control-label">Select Response Type</label>
                                        <select name="response_type" id="response_type" class="form-control" required>
                                            <option value="">Please select</option>
                                            @foreach($response_type as $key => $val)
                                                <option value="{{ $key }}" {{ old('response_type') == $key ? 'selected' : '' }}> {{ $val }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="difficulty_level" class=" form-control-label">Select Difficulty Level</label>
                                        <select name="difficulty_level" id="difficulty_level" class="form-control" required>
                                            <option value="">Please select</option>
                                            @foreach($difficulty_level as $key => $val)
                                                <option value="{{ $key }}" {{ old('difficulty_level') == $key ? 'selected' : '' }}> {{ $val }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="answer" class=" form-control-label">Select Answer</label>
                                        <select name="answer" id="answer" class="form-control" required>
                                            <option value="">Please select</option>
                                            @foreach($answers as $key => $val)
                                                <option value="{{ $key }}" {{ old('answer') == $key ? 'selected' : '' }}> {{ $val }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row option hide">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="option_1" class="control-label mb-1">Option 1</label>
                                        <input id="option_1" name="option_1" type="text" class="form-control" placeholder="Enter Option 1" value="{{ old('option_1') }}" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="option_2" class="control-label mb-1">Option 2</label>
                                        <input id="option_2" name="option_2" type="text" class="form-control" placeholder="Enter Option 2" value="{{ old('option_2') }}" >
                                    </div>
                                </div>
                            </div>
                            <div class="row option hide">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="option_3" class="control-label mb-1">Option 3</label>
                                        <input id="option_3" name="option_3" type="text" class="form-control" placeholder="Enter Option 3" value="{{ old('option_3') }}" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="option_4" class="control-label mb-1">Option 4</label>
                                        <input id="option_4" name="option_4" type="text" class="form-control" placeholder="Enter Option 4" value="{{ old('option_4') }}" >
                                    </div>
                                </div>
                            </div>
                            <div class="row option hide">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="option_5" class="control-label mb-1">Option 5</label>
                                        <input id="option_5" name="option_5" type="text" class="form-control" placeholder="Enter Option 5" value="{{ old('option_5') }}" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button id="question_button" type="submit" class="btn btn-lg btn-primary">
                                <i class="fa fa-dot-circle-o"></i>
                                <span id="payment-button-amount">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
