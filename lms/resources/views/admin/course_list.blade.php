@extends('admin.layout.app')

@section('title', 'Course List')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if(session()->has('success'))
                    <div class="alert alert-success" id="flashmessage">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                    <div class="form-group">
                        <label><strong>Status :</strong></label>
                        <select id="status" class="form-control">
                            <option value="">--Select status--</option>
                            <option value="0">Active</option>
                            <option value="1">Deactive</option>
                        </select>
                    </div>
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Course List</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-borderless table-striped table-earning course-list-table">
                                <thead>
                                <tr>
                                    <th style="width: 10%">Sr No.</th>
                                    <th style="width: 80%">Title</th>
                                    <th style="width: 10%">Status</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
