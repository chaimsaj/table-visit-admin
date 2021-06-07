@extends('layouts.master')

@section('title') @lang('translation.Cities') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Locations') @endslot
        @slot('title') @lang('translation.Cities') @endslot
    @endcomponent

@endsection
@section('script')
    <!-- locations -->
    <script src="{{ URL::asset('/assets/js/app/locations.js') }}"></script>
    <script type="application/javascript">
        initCities();
    </script>
@endsection
