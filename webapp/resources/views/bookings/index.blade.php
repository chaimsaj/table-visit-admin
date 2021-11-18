@extends('layouts.master')

@section('title') @lang('translation.Bookings') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Reservations') @endslot
        @slot('title') @lang('translation.Bookings') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title col-sm-4">
                            @lang('translation.Bookings')
                        </h4>
                    </div>
                    <hr/>
                    <table id="bookings-datatable"
                           class="table table-bordered dt-responsive nowrap w-100 align-middle text-center">
                        <thead class="table-light">
                        <tr class="text-center">
                            <th>@lang('translation.Code')</th>
                            <th>@lang('translation.ConfirmationCode')</th>
                            <th>@lang('translation.Customer')</th>
                            <th>@lang('translation.Place')</th>
                            <th>@lang('translation.BookDate')</th>
                            <th>@lang('translation.Guests')</th>
                            <th>@lang('translation.TableAmount')</th>
                            <th class="no-sort">@lang('translation.SpendsAmount')</th>
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
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <!-- reservations -->
    <script src="{{ URL::asset('/assets/js/app/reservations.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initBookings();
        })();
    </script>
@endsection
