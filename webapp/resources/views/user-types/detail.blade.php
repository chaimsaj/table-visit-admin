@extends('layouts.master')

@section('title') @lang('translation.UserTypes') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Users') @endslot
        @slot('title') @lang('translation.UserType') @endslot
    @endcomponent

@endsection
@section('script')
    <!-- locations -->
    <script src="{{ URL::asset('/assets/js/app/users.js') }}"></script>
@endsection
