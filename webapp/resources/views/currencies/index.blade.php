@extends('layouts.master')

@section('title') @lang('translation.Currencies') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Localization') @endslot
        @slot('title') @lang('translation.Currencies') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title col-sm-4">
                            @lang('translation.Currencies')
                        </h4>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <a href="{{route("currency.detail", 0)}}"
                                   class="btn btn-primary waves-effect waves-light"><i
                                        class="mdi mdi-plus me-1"></i> Add new
                                </a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <hr/>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- locations -->
    <script src="{{ URL::asset('/assets/js/app/localization.js') }}"></script>
@endsection
