@extends('layouts.master')

@section('title') @lang('translation.Table') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.TablesAndRates') @endslot
        @slot('title') @lang('translation.Table') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('translation.Information')</h4>
                    <div class="row">
                        <div>Coming soon..</div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
@section('script')
    <!-- tables -->
    <script src="{{ URL::asset('/assets/js/app/tables.js') }}"></script>
@endsection
