@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card mb-4 bg-warning">
                                <div class="card-body row text-center">
                                    <div class="col">
                                        <div class="fs-5 fw-semibold">{{ $users }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="fs-5 fw-semibold">Users</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card mb-4 bg-secondary">
                                <div class="card-body row text-center">
                                    <div class="col">
                                        <div class="fs-5 fw-semibold">{{ $feedbacks }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="fs-5 fw-semibold">Feedbacks</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!--end of card-body-->
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection