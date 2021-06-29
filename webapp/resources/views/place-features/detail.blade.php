@extends('layouts.master')

@section('title') @lang('translation.PlaceFeature') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Venues') @endslot
        @slot('title') @lang('translation.PlaceFeature') @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('translation.Information')</h4>
                    <div class="row">
                        <div class="col-xl-12">
                            <div>Coming soon..</div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
@section('script')
    <!-- places -->
    <script src="{{ URL::asset('/assets/js/app/places.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initPlaceFeature();
        })();
    </script>
@endsection
