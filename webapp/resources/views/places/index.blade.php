@extends('layouts.master')

@section('title') @lang('translation.Places') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Venues') @endslot
        @slot('title') @lang('translation.Places') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title col-sm-4">
                            @lang('translation.Places')
                        </h4>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <a href="{{route("place.detail", 0)}}"
                                   class="btn btn-primary waves-effect waves-light"><i
                                        class="mdi mdi-plus me-1"></i> @lang('translation.AddNew')
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <table id="datatable"
                           class="table table-bordered dt-responsive nowrap w-100 align-middle">
                        <thead class="table-light">
                        <tr class="text-center">
                            <th>@lang('translation.Id')</th>
                            <th>@lang('translation.Image')</th>
                            <th>@lang('translation.Name')</th>
                            <th>@lang('translation.DisplayOrder')</th>
                            <th>@lang('translation.City')</th>
                            <th class="no-sort">@lang('translation.Delete')</th>
                            <th class="no-sort">@lang('translation.Edit')</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach ($data as $item)
                            <tr class="text-center">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->image_path }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->display_order }}</td>
                                <td>{{ $item->city_name }}</td>
                                <td>
                                    <a href="{{route("place.delete", $item->id)}}" class="text-danger"><i
                                            class="mdi mdi-delete font-size-18"></i></a>
                                </td>
                                <td>
                                    <a href="{{route("place.detail", $item->id)}}" class="text-success"><i
                                            class="mdi mdi-pencil font-size-18"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <!-- places -->
    <script src="{{ URL::asset('/assets/js/app/places.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initPlaces();
        })();
    </script>
@endsection
