@extends('layouts.master')

@section('title') @lang('translation.user') @endsection

@section('css')
    <link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Detail @endslot
        @slot('title') Users @endslot
    @endcomponent

    <div class="row">


        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail</h4>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" class="form-horizontal" action="{{ route('store')}}" >
                                        @csrf
                                       <img class="rounded-circle header-profile-user"
                                             src="{{ asset('/assets/images/users/avatar-1.jpg') }}"
                                             alt="">
                                        <div class="mb-3">
                                            <label for="avatar">Profile Picture</label>
                                            <div class="input-group">
                                                <input type="file" name="avatar" value="" class="form-control"  >
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                            </div>

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" id="name" value="" class="form-control" value="" required placeholder="Name" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="userdob">Date of Birth</label>
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" class="form-control" required placeholder="dd-mm-yyyy"
                                                       data-date-format="dd-mm-yyyy" data-date-container='#datepicker1' data-date-end-date="0d" value=""
                                                       data-provide="datepicker" name="dob" autofocus required>
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>

                                                <span class="invalid-feedback" role="alert">
                                                                <strong></strong>
                                                            </span>

                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div>
                                                <input type="password" name="password" value="" id="password" class="form-control" required placeholder="Password" />
                                            </div>
                                            <div class="mt-2">
                                                <input type="password" value="" class="form-control" required data-parsley-equalto="#password"
                                                       placeholder="Re-Type Password" />
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">E-Mail</label>
                                            <div>
                                                <input id="email" name="email" type="email" value="" class="form-control" required parsley-type="email"
                                                       placeholder="Enter a valid e-mail" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                Submit
                                            </button>
                                            <button type="reset" onclick="window.location.href='/users'" class="btn btn-secondary waves-effect">
                                                Cancel
                                            </button>
                                        </div>




                                    </form>

                                </div>
                            </div> <!-- end col -->
                        </div>



                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    @endsection

    @section('script')
            <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

            <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>

            <script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>
@endsection

