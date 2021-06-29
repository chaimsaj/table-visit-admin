@extends('layouts.master')

@section('title') @lang('translation.PlaceTypes') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Venues') @endslot
        @slot('title') @lang('translation.PlaceType') @endslot
    @endcomponent

@endsection
@section('script')
    <!-- places -->
    <script src="{{ URL::asset('/assets/js/app/places.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initPlaceType();
        })();
    </script>
@endsection
