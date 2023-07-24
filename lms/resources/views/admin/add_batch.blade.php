@extends('admin.layout.app')

@section('title', 'Add Batch')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Add Batch</div>
                    <form action="store_batch" method="post" enctype="multipart/form-data" id="form">
                        @csrf
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Enter batch Detail</h3>
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
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="batch_title" class="control-label mb-1">Batch Title</label>
                                        <input id="batch_title" name="batch_title" type="text" class="form-control" placeholder="Enter Batch Title" value="{{ old('batch_title') }}" required>
                                    </div>
                                </div>
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
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="total_questions" class="control-label mb-1">Total Question</label>
                                        <input id="total_questions" name="total_questions" type="number" min="0" class="form-control" placeholder="Enter Question Quantity" value="{{ old('total_questions') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="total_marks" class="control-label mb-1">Total Marks</label>
                                        <input id="total_marks" name="total_marks" type="number" min="0" class="form-control" placeholder="Enter Total Marks" value="{{ old('total_marks') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="total_time" class="control-label mb-1">Time Limit</label>
                                        <input id="total_time" name="total_time" type="number" min="0" class="form-control" placeholder="Enter Test Time Limit in Minutes" value="{{ old('total_time') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="easy_question" class="control-label mb-1">Easy Question</label>
                                        <input id="easy_question" name="easy_question" type="number" min="0" class="form-control sum" placeholder="Enter Easy Question Quantity" value="{{ old('easy_question') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="normal_question" class="control-label mb-1">Normal Question</label>
                                        <input id="normal_question" name="normal_question" type="number" min="0" class="form-control sum" placeholder="Enter Normal Question Quantity" value="{{ old('normal_question') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="hard_question" class="control-label mb-1">Hard Question</label>
                                        <input id="hard_question" name="hard_question" type="number" min="0" class="form-control sum" placeholder="Enter Hard Question Quantity" value="{{ old('hard_question') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="ym_index" class="control-label mb-1">Batch Month/Year</label>
                                        <input id="ym_index" name="ym_index" type="month" class="form-control" value="{{ old('ym_index') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="registration_date" class="control-label mb-1">Apply Last Date</label>
                                        <input id="registration_date" name="registration_date" type="date" class="form-control" value="{{ old('registration_date') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="start_date" class="control-label mb-1">Test Start Date</label>
                                        <input id="start_date" name="start_date" type="date" class="form-control" value="{{ old('start_date') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="end_date" class="control-label mb-1">Test End Date</label>
                                        <input id="end_date" name="end_date" type="date" class="form-control" value="{{ old('end_date') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button id="batch_button" type="submit" class="btn btn-lg btn-primary" >
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
