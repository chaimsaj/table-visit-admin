@extends('layouts.master')

@section('title') @lang('translation.PlaceTypes') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Venues') @endslot
        @slot('title') @lang('translation.PlaceTypes') @endslot
    @endcomponent

@endsection
@section('script')
    <!-- locations -->
    <script src="{{ URL::asset('/assets/js/app/places.js') }}"></script>
@endsection
