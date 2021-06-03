@extends('layouts.master')

@section('title') @lang('translation.Languages') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Localization') @endslot
        @slot('title') @lang('translation.Languages') @endslot
    @endcomponent

@endsection
@section('script')
    <!-- locations -->
    <script src="{{ URL::asset('/assets/js/app/localization.js') }}"></script>
@endsection
