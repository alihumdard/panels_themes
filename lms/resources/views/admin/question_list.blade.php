@extends('admin.layout.app')

@section('title', 'Question List')

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
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Question List</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-borderless table-striped table-earning question-list-table">
                                <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Question</th>
                                    <th>Course Name</th>
                                    <th>Status</th>
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
