@extends('layouts.master')

@section('title') @lang('translation.Log') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Settings') @endslot
        @slot('title') @lang('translation.Log') @endslot
    @endcomponent

@endsection
@section('script')
    <!-- locations -->
    <script src="{{ URL::asset('/assets/js/app/settings.js') }}"></script>
@endsection
