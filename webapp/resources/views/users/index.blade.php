@extends('layouts.master')

@section('title') @lang('translation.Users') @endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Users') @endslot
        @slot('title') @lang('translation.Users') @endslot
    @endcomponent

    <div class="row">

        {{--@foreach ($data as $user)
            <p>This is user {{ $user->id }}</p>
        @endforeach--}}

        {{-- {{ $data->name }}--}}


        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">List</h4>
                    <div class="row">
                        <div class="text-sm-end">
                            <button type="button" onclick="window.location.href='/users-create'"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                    class="mdi mdi-plus me-1"></i> Add New User
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <table id="datatable"
                               class="table table-bordered dt-responsive  nowrap align-middle table-edits">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Edit</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach ($data as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td><img class="rounded-circle header-profile-user"
                                             src="{{ isset($user->avatar) ? asset($user->avatar) : asset('/assets/images/users/avatar-1.jpg') }}"
                                             alt=""></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a href="users/{{ $user->id }}" class="btn  btn-sm edit" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="" class="btn  btn-sm deleted" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

    @endsection

    @section('script')
        <!-- Required datatable js -->
            <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
        <!--   <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
     <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>-->
            <!-- Datatable init js -->
            <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
