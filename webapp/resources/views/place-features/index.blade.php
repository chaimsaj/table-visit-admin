@extends('layouts.master')

@section('title') @lang('translation.PlaceFeatures') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Venues') @endslot
        @slot('title') @lang('translation.PlaceFeatures') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title col-sm-4">
                            @lang('translation.PlaceFeatures')
                        </h4>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <a href="{{route("place-feature.detail", 0)}}"
                                   class="btn btn-primary waves-effect waves-light"><i
                                        class="mdi mdi-plus me-1"></i> Add new
                                </a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <hr/>
                    <div>Coming soon..</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <!-- places -->
    <script src="{{ URL::asset('/assets/js/app/places.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initPlaceFeatures();
        })();
    </script>
@endsection
