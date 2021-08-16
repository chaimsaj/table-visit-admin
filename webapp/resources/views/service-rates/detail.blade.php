@extends('layouts.master')

@section('title') @lang('translation.BottleRate') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.BottlesAndDrinks') @endslot
        @slot('title') @lang('translation.BottleRate') @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('translation.Information')</h4>
                    <div class="row">
                        <div class="col-xl-6">
                            <form autocomplete="off" method="POST" class="form-horizontal custom-validation"
                                  action="{{route("service-rate.save", $data->id ?? 0)}}">
                                @csrf
                                <hr/>
                                <div class="mb-3">
                                    <label class="form-label">Bottle</label>
                                    <div>
                                        <select id="service_id" name="service_id" class="form-select select2">
                                            @foreach($services as $service)
                                                <option
                                                    value="{{ $service->id }}" {{ ($data && $data->service_id == $service->id) ? 'selected' : '' }}>
                                                    {{ $service->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Place</label>
                                    <div>
                                        <select id="place_id" name="place_id" class="form-select select2">
                                            @foreach($places as $place)
                                                <option
                                                    value="{{ $place->id }}" {{ ($data && $data->place_id == $place->id) ? 'selected' : '' }}>
                                                    {{ $place->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Rate</label>
                                    <div>
                                        <input name="rate"
                                               id="rate"
                                               value="{{$data->rate ?? ''}}"
                                               class="form-control"
                                               required
                                               data-parsley-type="number"
                                               placeholder="Rate"/>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Valid from</label>
                                            <div class="input-group" id="cnt_valid_from">
                                                <input type="text" class="form-control" placeholder="mm-dd-yyyy"
                                                       name="valid_from" id="valid_from"
                                                       data-date-orientation="top"
                                                       data-date-autoclose="true"
                                                       data-date-format="mm-dd-yyyy"
                                                       data-date-container='#cnt_valid_from'
                                                       data-provide="datepicker"
                                                       value="{{$data->valid_from_data ?? ''}}">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Valid to</label>
                                            <div class="input-group" id="cnt_valid_to">
                                                <input type="text" class="form-control" placeholder="mm-dd-yyyy"
                                                       name="valid_to" id="valid_to"
                                                       data-date-orientation="top"
                                                       data-date-autoclose="true"
                                                       data-date-format="mm-dd-yyyy" data-date-container='#cnt_valid_to'
                                                       data-provide="datepicker"
                                                       value="{{$data->valid_to_data ?? ''}}">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       {{(!$data || $data->published == 1) ? 'checked' : ''}}
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
                                                       {{(!$data || $data->show == 1) ? 'checked' : ''}}
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
                                    <a href="{{route("service-rates")}}"
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
    <!-- services -->
    <script src="{{ URL::asset('/assets/js/app/services.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initServiceRate();
        })();
    </script>
@endsection
