@extends('layouts.master')

@section('title') @lang('translation.Payment') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Payment') @endslot
        @slot('title') @lang('translation.Reservations') @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('translation.Information')</h4>
                    <div class="row">
                        <div>Coming soon..</div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
@section('script')
    <!-- reservations -->
    <script src="{{ URL::asset('/assets/js/app/reservations.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initBooking();
        })();
    </script>
@endsection
