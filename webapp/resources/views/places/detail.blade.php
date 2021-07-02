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
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#features" role="tab">
                                        <span class="d-block d-sm-none"><i class="bx bx-grid-alt"></i></span>
                                        <span class="d-none d-sm-block">@lang('translation.Features')</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#music" role="tab">
                                        <span class="d-block d-sm-none"><i class="bx bx-music"></i></span>
                                        <span class="d-none d-sm-block">@lang('translation.Music')</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active p-2" id="data" role="tabpanel">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <form method="POST" class="form-horizontal custom-validation"
                                                  action="{{route("place.save", $data->id ?? 0)}}"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name"
                                                           value="{{$data->name ?? ''}}"
                                                           class="form-control" value="" required
                                                           placeholder="Name"/>
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

                                                <div class="mb-3">
                                                    <label class="form-label">City</label>
                                                    <div>
                                                        <select class="form-select" name="city_id">
                                                            <option value="0">@lang('translation.Select')</option>
                                                            @foreach($cities as $city)
                                                                <option
                                                                    value="{{ $city->id }}" {{ ($data && $data->city_id == $city->id) ? 'selected' : '' }}>
                                                                    {{ $city->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="image_path">@lang('translation.MainImage')</label>
                                                    <div class="input-group">
                                                        <input type="file" name="image_path" class="form-control">
                                                        <label class="input-group-text"
                                                               for="image_path">@lang('translation.Upload')</label>
                                                    </div>

                                                </div>

                                                <div class="mb-4">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       {{($data && $data->published == 1) ? 'checked' : ''}}
                                                                       id="published"
                                                                       name="published">
                                                                <label class="form-check-label" for="published">
                                                                    Published
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       id="show"
                                                                       {{($data && $data->show == 1) ? 'checked' : ''}}
                                                                       name="show">
                                                                <label class="form-check-label" for="show">
                                                                    Show
                                                                </label>
                                                            </div>
                                                        </div>
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
                                <div class="tab-pane p-2" id="details" role="tabpanel">
                                    <p class="mb-0">
                                        Coming soon..
                                    </p>
                                </div>
                                <div class="tab-pane p-2" id="images" role="tabpanel">
                                    <p class="mb-0">
                                        Coming soon..
                                    </p>
                                </div>
                                <div class="tab-pane p-2" id="features" role="tabpanel">
                                    <p class="mb-0">
                                        Coming soon..
                                    </p>
                                </div>
                                <div class="tab-pane p-2" id="music" role="tabpanel">
                                    <p class="mb-0">
                                        Coming soon..
                                    </p>
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
