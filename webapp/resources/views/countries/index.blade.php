@extends('layouts.master')

@section('title') @lang('translation.Countries') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('title') @lang('translation.Countries') @endslot
    @endcomponent

@endsection
@section('script')
    <!-- locations -->
    <script src="{{ URL::asset('/assets/js/app/locations.js') }}"></script>
@endsection
