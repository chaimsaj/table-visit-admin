@extends('layouts.master')

@section('title') @lang('translation.Places') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Venues') @endslot
        @slot('title') @lang('translation.Place') @endslot
    @endcomponent

@endsection
@section('script')
    <!-- locations -->
    <script src="{{ URL::asset('/assets/js/app/places.js') }}"></script>
@endsection
