@extends('layouts.master')

@section('title') @lang('translation.Services') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.TableServices') @endslot
        @slot('title') @lang('translation.Services') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title col-sm-4">
                            @lang('translation.Services')
                        </h4>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <a href="{{route("service.detail", 0)}}"
                                   class="btn btn-primary waves-effect waves-light"><i
                                        class="mdi mdi-plus me-1"></i>
                                    @lang('translation.AddNew')
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
    <!-- table-services -->
    <script src="{{ URL::asset('/assets/js/app/table-services.js') }}"></script>
@endsection
