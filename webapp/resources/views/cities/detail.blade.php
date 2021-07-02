@extends('layouts.master')

@section('title') @lang('translation.City') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Locations') @endslot
        @slot('title') @lang('translation.City') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('translation.Information')</h4>
                    <div class="row">
                        <div class="col-xl-6">
                            <form method="POST" class="form-horizontal custom-validation"
                                  action="{{route("city.save", $data->id ?? 0)}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name"
                                           value="{{$data->name ?? ''}}"
                                           class="form-control" value="" required placeholder="Name"/>
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
                                    <label class="form-label">Country</label>
                                    <div>
                                        <select id="country_id" class="form-select" name="country_id">
                                            <option value="0">@lang('translation.Select')</option>
                                            @foreach($countries as $country)
                                                <option
                                                    value="{{ $country->id }}" {{ ($data && $data->country_id == $country->id) ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">State</label>
                                    <div>
                                        <select id="state_id" class="form-select" name="state_id">
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
                                                <input class="form-check-input" type="checkbox" id="show"
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
                                    <button type="submit" class="btn btn-success waves-effect waves-light">
                                        @lang('translation.Save')
                                    </button>
                                    <a href="{{route("cities")}}"
                                       class="btn btn-danger waves-effect">
                                        @lang('translation.Cancel')
                                    </a>
                                </div>


                            </form>

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="close"></button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
@section('script')
    <!-- locations -->
    <script src="{{ URL::asset('/assets/js/app/locations.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initCity();
        })();
    </script>
@endsection
