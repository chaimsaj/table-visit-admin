@extends('layouts.master')

@section('title') @lang('translation.Cities') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Locations') @endslot
        @slot('title') @lang('translation.Cities') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title col-sm-4">
                            @lang('translation.Cities')
                        </h4>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <a href="{{route("city.detail", 0)}}"
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
    <script src="{{ URL::asset('/assets/js/app/locations.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initCities();
        })();
    </script>
@endsection
