@extends('layouts.master')

@section('title') @lang('translation.Users') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Users') @endslot
        @slot('title') @lang('translation.Detail') @endslot
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
                                    <form method="POST" class="form-horizontal custom-validation"
                                          action="{{ route('user.save', $data->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="fdvffff">

                                        <img class="rounded-circle header-profile-user"
                                             src="{{ isset($data->avatar) ? asset($data->avatar) : asset('/assets/images/users/avatar-1.jpg') }}"
                                             alt="">
                                        <div class="mb-3">
                                            <label for="avatar">Profile Picture</label>
                                            <div class="input-group">
                                                <input type="file" name="avatar" value="eeee" class="form-control">
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                            </div>

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name"
                                                   value="{{isset($data->name) ? $data->name  : ''}}"
                                                   class="form-control" value="" required placeholder="Name"/>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div>
                                                <input type="password" name="password"
                                                       value="{{isset($data->password) ? $data->password  : ''}}"
                                                       id="pass2" class="form-control" required placeholder="Password"/>
                                            </div>
                                            <div class="mt-2">
                                                <input type="password"
                                                       value="{{isset($data->password) ? $data->password  : ''}}"
                                                       class="form-control" required data-parsley-equalto="#pass2"
                                                       placeholder="Re-Type Password"/>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">E-Mail</label>
                                            <div>
                                                <input type="email" value="{{isset($data->email) ? $data->email  : ''}}"
                                                       class="form-control" required parsley-type="email"
                                                       placeholder="Enter a valid e-mail"/>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                Submit
                                            </button>
                                            <button type="reset" onclick="window.location.href='/users'"
                                                    class="btn btn-secondary waves-effect">
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
        </div>
    </div>
@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
