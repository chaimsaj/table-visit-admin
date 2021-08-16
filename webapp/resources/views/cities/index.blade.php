@extends('layouts.master')

@section('title') @lang('translation.Cities') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Locations') @endslot
        @slot('title') @lang('translation.Cities') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title col-sm-4">
                            @lang('translation.Cities')
                        </h4>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <a href="{{route("city.detail", 0)}}"
                                   class="btn btn-primary waves-effect waves-light"><i
                                        class="mdi mdi-plus me-1"></i> @lang('translation.AddNew')
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <table id="cities-datatable"
                           class="table table-bordered dt-responsive nowrap w-100 align-middle text-center">
                        <thead class="table-light">
                        <tr class="text-center">
                            <th class="no-sort">@lang('translation.Id')</th>
                            <th>@lang('translation.Name')</th>
                            <th>@lang('translation.Code')</th>
                            <th class="no-sort">@lang('translation.DisplayOrder')</th>
                            <th class="no-sort">@lang('translation.State')</th>
                            <th class="no-sort">@lang('translation.Country')</th>
                            <th class="th45 no-sort">@lang('translation.Delete')</th>
                            <th class="th45 no-sort">@lang('translation.Edit')</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <!-- locations -->
    <script src="{{ URL::asset('/assets/js/app/locations.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initCities();
        })();
    </script>
@endsection
