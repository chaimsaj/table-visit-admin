@extends('layouts.master')

@section('title') @lang('translation.Service') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.TableServices') @endslot
        @slot('title') @lang('translation.Service') @endslot
    @endcomponent

@endsection
@section('script')
    <!-- table-services -->
    <script src="{{ URL::asset('/assets/js/app/table-services.js') }}"></script>
@endsection
