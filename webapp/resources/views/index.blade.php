@extends('layouts.master')

@section('title') @lang('translation.Dashboard') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.App') @endslot
        @slot('title') @lang('translation.Dashboard') @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Venues</p>
                                    <h4 class="mb-0">0</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-building-house font-size-24"></i>
                                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Reservations</p>
                                    <h4 class="mb-0">0</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Tables</p>
                                    <h4 class="mb-0">0</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bxs-drink font-size-24"></i>
                                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Users</p>
                                    <h4 class="mb-0">0</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-user-circle font-size-24"></i>
                                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-start">
                        <h5 class="card-title me-2">Tables</h5>
                        <div class="ms-auto">
                            <div class="toolbar button-items text-end">
                                <button type="button" class="btn btn-light btn-sm">
                                    ALL
                                </button>
                                <button type="button" class="btn btn-light btn-sm">
                                    1M
                                </button>
                                <button type="button" class="btn btn-light btn-sm">
                                    6M
                                </button>
                                <button type="button" class="btn btn-light btn-sm active">
                                    1Y
                                </button>

                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-lg-4">
                            <div class="mt-4">
                                <p class="text-muted mb-1">Today</p>
                                <h5>0</h5>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mt-4">
                                <p class="text-muted mb-1">This Month</p>
                                <h5>0</h5>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mt-4">
                                <p class="text-muted mb-1">This Year</p>
                                <h5>0</h5>
                            </div>
                        </div>
                    </div>

                    <hr class="mb-4">

                    <div class="apex-charts" id="area-chart" dir="ltr"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Top Cities Selling Tables</h4>

                    <div class="text-center">
                        <div class="mb-4">
                            <i class="bx bx-map-pin text-primary display-4"></i>
                        </div>
                        <h3>1,456</h3>
                        <p>San Francisco</p>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table align-middle table-nowrap">
                            <tbody>
                            <tr>
                                <td style="width: 30%">
                                    <p class="mb-0">San Francisco</p>
                                </td>
                                <td style="width: 25%">
                                    <h5 class="mb-0">1,456</h5></td>
                                <td>
                                    <div class="progress bg-transparent progress-sm">
                                        <div class="progress-bar bg-primary rounded" role="progressbar"
                                             style="width: 94%" aria-valuenow="94" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="mb-0">Los Angeles</p>
                                </td>
                                <td>
                                    <h5 class="mb-0">1,123</h5>
                                </td>
                                <td>
                                    <div class="progress bg-transparent progress-sm">
                                        <div class="progress-bar bg-success rounded" role="progressbar"
                                             style="width: 82%" aria-valuenow="82" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="mb-0">San Diego</p>
                                </td>
                                <td>
                                    <h5 class="mb-0">1,026</h5>
                                </td>
                                <td>
                                    <div class="progress bg-transparent progress-sm">
                                        <div class="progress-bar bg-warning rounded" role="progressbar"
                                             style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-start">
                        <h5 class="card-title mb-3 me-2">Users</h5>

                        {{--<div class="dropdown ms-auto">
                            <a class="text-muted dropdown-toggle font-size-16" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                <i class="mdi mdi-dots-horizontal"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Separated link</a>
                            </div>
                        </div>--}}
                    </div>

                    <div class="d-flex flex-wrap">
                        <div>
                            <p class="text-muted mb-1">Total</p>
                            <h4 class="mb-3">0</h4>
                        </div>
                        <div class="ms-auto align-self-end">
                            <i class="bx bx-user display-4 text-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- subscribeModal -->
    {{--<div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar-md mx-auto mb-4">
                            <div class="avatar-title bg-light rounded-circle text-primary h1">
                                <i class="mdi mdi-email-open"></i>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h4 class="text-primary">Subscribe !</h4>
                                <p class="text-muted font-size-14 mb-4">Subscribe our newletter and get notification to stay
                                    update.</p>

                                <div class="input-group bg-light rounded">
                                    <input type="email" class="form-control bg-transparent border-0"
                                        placeholder="Enter Email address" aria-label="Recipient's username"
                                        aria-describedby="button-addon2">

                                    <button class="btn btn-primary" type="button" id="button-addon2">
                                        <i class="bx bxs-paper-plane"></i>
                                    </button>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
    <!-- end modal -->

@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    {{--<script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>--}}
    <script src="{{ URL::asset('/assets/js/pages/dashboard-blog.init.js') }}"></script>
@endsection
