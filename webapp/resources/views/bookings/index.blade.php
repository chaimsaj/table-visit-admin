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
                        <div class="col-sm-8">

                        </div>
                    </div>
                    <hr/>
                    <div>Coming soon..</div>
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
