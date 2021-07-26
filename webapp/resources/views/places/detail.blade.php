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
                        <div class="col-xl-12 mt-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if($tab=="data") active @endif" data-bs-toggle="tab"
                                       href="#data" role="tab">
                                        <span class="d-block d-sm-none"><i class="bx bx-data"></i></span>
                                        <span class="d-none d-sm-block">@lang('translation.Data')</span>
                                    </a>
                                </li>
                                @if($data && $data->id != 0)
                                    <li class="nav-item">
                                        <a class="nav-link @if($tab=="details") active @endif" data-bs-toggle="tab"
                                           href="#details" role="tab">
                                            <span class="d-block d-sm-none"><i class="bx bx-news"></i></span>
                                            <span class="d-none d-sm-block">@lang('translation.Detail')</span>
                                        </a>
                                    </li>
                                    {{--<li class="nav-item">
                                        <a class="nav-link @if($tab=="images") active @endif" data-bs-toggle="tab"
                                           href="#images" role="tab">
                                            <span class="d-block d-sm-none"><i class="bx bx-paperclip"></i></span>
                                            <span class="d-none d-sm-block">@lang('translation.Images')</span>
                                        </a>
                                    </li>--}}
                                    <li class="nav-item">
                                        <a class="nav-link @if($tab=="floor-plan") active @endif" data-bs-toggle="tab"
                                           href="#floor-plan" role="tab">
                                            <span class="d-block d-sm-none"><i class="bx bx-paperclip"></i></span>
                                            <span class="d-none d-sm-block">@lang('translation.FloorPlan')</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($tab=="food-menu") active @endif" data-bs-toggle="tab"
                                           href="#food-menu" role="tab">
                                            <span class="d-block d-sm-none"><i class="bx bx-paperclip"></i></span>
                                            <span class="d-none d-sm-block">@lang('translation.FoodMenu')</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($tab=="features") active @endif" data-bs-toggle="tab"
                                           href="#features" role="tab">
                                            <span class="d-block d-sm-none"><i class="bx bx-grid-alt"></i></span>
                                            <span class="d-none d-sm-block">@lang('translation.Features')</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($tab=="music") active @endif" data-bs-toggle="tab"
                                           href="#music" role="tab">
                                            <span class="d-block d-sm-none"><i class="bx bx-music"></i></span>
                                            <span class="d-none d-sm-block">@lang('translation.Music')</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane p-2 @if($tab=="data") active @endif" id="data" role="tabpanel">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <form autocomplete="off" method="POST"
                                                  class="form-horizontal custom-validation"
                                                  action="{{route("place.save", $data->id ?? 0)}}"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                @if(isset($data))
                                                    <img class="rounded mt-2"
                                                         src="{{\App\Helpers\MediaHelper::getImageUrl($data->image_path)}}"
                                                         alt=""/>
                                                    <hr/>
                                                @endif
                                                <div class="mb-3 mt-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name"
                                                           value="{{$data->name ?? ''}}"
                                                           class="form-control" value="" required
                                                           placeholder="Name"/>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" name="address"
                                                           value="{{$data->address ?? ''}}"
                                                           class="form-control" value="" required
                                                           placeholder="Address"/>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Display order</label>
                                                    <div>
                                                        <input name="display_order" type="display_order"
                                                               value="{{$data->display_order ?? ''}}"
                                                               class="form-control" required
                                                               placeholder="Display order"/>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">State</label>
                                                    <div>
                                                        <select class="form-select" id="state_id" name="state_id">
                                                            <option value="0">@lang('translation.Select')</option>
                                                            @foreach($states as $state)
                                                                <option
                                                                    value="{{ $state->id }}" {{ ($data && $data->state_id == $state->id) ? 'selected' : '' }}>
                                                                    {{ $state->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">City</label>
                                                    <div>
                                                        <select class="form-select" id="city_id" name="city_id">
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
                                                    <input type="file" name="image_path" class="form-control">
                                                    {{--<div class="input-group">

                                                        <label class="input-group-text"
                                                               for="image_path">@lang('translation.Upload')</label>
                                                    </div>--}}
                                                </div>

                                                <div class="mb-4">
                                                    <div class="row">
                                                        <div class="col-3">
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
                                                        <div class="col-3">
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
                                                        <div class="col-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       id="accept_reservations"
                                                                       {{($data && $data->accept_reservations == 1) ? 'checked' : ''}}
                                                                       name="accept_reservations">
                                                                <label class="form-check-label"
                                                                       for="accept_reservations">
                                                                    Reservations
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       id="open"
                                                                       {{($data && $data->open == 1) ? 'checked' : ''}}
                                                                       name="open">
                                                                <label class="form-check-label" for="open">
                                                                    Open
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
                                @if($data && $data->id != 0)
                                    <div class="tab-pane p-2 @if($tab=="details") active @endif" id="details"
                                         role="tabpanel">
                                        <p class="mb-0">
                                            @component('components.place-details', ["place_detail" => $place_detail ?? null, "data" => $data ?? null])
                                            @endcomponent
                                        </p>
                                    </div>
                                    {{--<div class="tab-pane p-2 @if($tab=="images") active @endif" id="images" role="tabpanel">
                                        <p class="mb-0">
                                            @component('components.place-images', ["place_id" => $data->id ?? 0])
                                            @endcomponent
                                        </p>
                                    </div>--}}
                                    <div class="tab-pane p-2 @if($tab=="floor-plan") active @endif" id="floor-plan"
                                         role="tabpanel">
                                        @component('components.place-floor-plan', ["data" => $data ?? null])
                                        @endcomponent
                                    </div>
                                    <div class="tab-pane p-2 @if($tab=="food-menu") active @endif" id="food-menu"
                                         role="tabpanel">
                                        @component('components.place-food-menu', ["data" => $data ?? null])
                                        @endcomponent
                                    </div>
                                    <div class="tab-pane p-2 @if($tab=="features") active @endif" id="features"
                                         role="tabpanel">
                                        @component('components.place-features', ["features" => $features, "data" => $data ?? null, "place_features" => $place_features])
                                        @endcomponent
                                    </div>
                                    <div class="tab-pane p-2 @if($tab=="music") active @endif" id="music"
                                         role="tabpanel">
                                        @component('components.place-music', ["music" => $music, "data" => $data ?? null, "place_music" => $place_music])
                                        @endcomponent
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
@section('script')
    <!--tinymce js-->
    <script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <!-- places -->
    <script src="{{ URL::asset('/assets/js/app/places.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initPlace();
        })();
    </script>
@endsection
