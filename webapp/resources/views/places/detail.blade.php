@extends('layouts.master')

@section('title') @lang('translation.Places') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Venues') @endslot
        @slot('title') @lang('translation.Place') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('translation.Information')</h4>
                    <div class="row">
                        <div class="col-xl-12">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#data" role="tab">
                                        <span class="d-block d-sm-none"><i class="bx bx-data"></i></span>
                                        <span class="d-none d-sm-block">@lang('translation.Data')</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#details" role="tab">
                                        <span class="d-block d-sm-none"><i class="bx bx-news"></i></span>
                                        <span class="d-none d-sm-block">@lang('translation.Details')</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#images" role="tab">
                                        <span class="d-block d-sm-none"><i class="bx bx-paperclip"></i></span>
                                        <span class="d-none d-sm-block">@lang('translation.Images')</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active p-2" id="data" role="tabpanel">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <form method="POST" class="form-horizontal custom-validation"
                                                  action="{{route("place.save", $data->id ?? 0)}}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name"
                                                           value="{{$data->name ?? ''}}"
                                                           class="form-control" value="" required
                                                           placeholder="Name"/>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Code</label>
                                                    <div>
                                                        <input name="iso_code" type="iso_code"
                                                               value="{{$data->iso_code ?? ''}}"
                                                               class="form-control" required
                                                               placeholder="Code"/>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Display order</label>
                                                    <div>
                                                        <input name="display_order" type="display_order"
                                                               value="{{$data->display_order ?? ''}}"
                                                               class="form-control" required
                                                               placeholder="Display order"/>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-wrap gap-2">
                                                    <button type="submit"
                                                            class="btn btn-success waves-effect waves-light">
                                                        @lang('translation.Save')
                                                    </button>
                                                    <a href="{{route("places")}}"
                                                       class="btn btn-danger waves-effect">
                                                        @lang('translation.Cancel')
                                                    </a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="details" role="tabpanel">

                                </div>
                                <div class="tab-pane" id="images" role="tabpanel">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
@section('script')
    <!-- places -->
    <script src="{{ URL::asset('/assets/js/app/places.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initPlace();
        })();
    </script>
@endsection
