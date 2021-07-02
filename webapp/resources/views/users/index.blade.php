@extends('layouts.master')

@section('title') @lang('translation.Users') @endsection

@section('css')
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Users') @endslot
        @slot('title') @lang('translation.Users') @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title col-sm-4">
                            @lang('translation.Users')
                        </h4>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <a href="{{route("user.detail", 0)}}"
                                   class="btn btn-primary waves-effect waves-light"><i
                                        class="mdi mdi-plus me-1"></i> @lang('translation.AddNew')
                                </a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <hr/>
                    <div class="row">
                        <table id="datatable"
                               class="table table-bordered dt-responsive nowrap w-100 align-middle">
                            <thead class="table-light">
                            <tr class="text-center">
                                <th>@lang('translation.Id')</th>
                                <th class="no-sort">@lang('translation.Avatar')</th>
                                <th>@lang('translation.Name')</th>
                                <th>@lang('translation.Email')</th>
                                <th class="no-sort">@lang('translation.Delete')</th>
                                <th class="no-sort">@lang('translation.Edit')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $item)
                                <tr class="text-center">
                                    <td>{{ $item->id }}</td>
                                    <td><img class="rounded avatar-sm"
                                             src="{{ isset($item->avatar) ? asset($item->avatar) : asset('/assets/images/users/avatar-1.jpg') }}"
                                             alt=""></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        <a href="{{route("user.delete", $item->id)}}" class="text-danger"><i
                                                class="mdi mdi-delete font-size-18"></i></a>
                                    </td>
                                    <td>
                                        {{--<div class="d-flex gap-3">
                                        </div>--}}
                                        <a href="{{route("user.detail", $item->id)}}" class="text-success"><i
                                                class="mdi mdi-pencil font-size-18"></i></a>
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
            <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
