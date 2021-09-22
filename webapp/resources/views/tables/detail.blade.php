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
                                    <li class="nav-item">
                                        <a class="nav-link @if($tab=="rates") active @endif" data-bs-toggle="tab"
                                           href="#rates" role="tab">
                                            <span class="d-block d-sm-none"><i class="bx bx-news"></i></span>
                                            <span class="d-none d-sm-block">@lang('translation.Rates')</span>
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
                                                  action="{{route("table.save", $data->id ?? 0)}}">
                                                @csrf
                                                <div class="mb-3 mt-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name"
                                                           value="{{$data->name ?? ''}}"
                                                           class="form-control" value="" required placeholder="Name"/>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Minimum spend</label>
                                                    <div>
                                                        <input name="minimum_spend"
                                                               required
                                                               data-parsley-type="number"
                                                               value="{{$data->minimum_spend ?? ''}}"
                                                               class="form-control"
                                                               placeholder="Minimum spend"/>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Guests count</label>
                                                    <div>
                                                        <input name="guests_count"
                                                               required
                                                               data-parsley-type="number"
                                                               value="{{$data->guests_count ?? ''}}"
                                                               class="form-control"
                                                               placeholder="Guests count"/>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Table Number</label>
                                                    <div>
                                                        <input name="table_number"
                                                               value="{{$data->table_number ?? '0'}}"
                                                               class="form-control"
                                                               data-parsley-type="number"
                                                               required
                                                               placeholder="Table Number"/>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Display order</label>
                                                    <div>
                                                        <input name="display_order"
                                                               value="{{$data->display_order ?? '1'}}"
                                                               class="form-control"
                                                               data-parsley-type="number"
                                                               required
                                                               placeholder="Display order"/>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Table type</label>
                                                    <div>
                                                        <select id="table_type_id" class="form-select select2"
                                                                name="table_type_id">
                                                            <option value="0">@lang('translation.Select')</option>
                                                            @foreach($table_types as $table_type)
                                                                <option
                                                                    value="{{ $table_type->id }}" {{ ($data && $data->table_type_id == $table_type->id) ? 'selected' : '' }}>
                                                                    {{ $table_type->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Place</label>
                                                    <div>
                                                        <select id="place_id" class="form-select select2"
                                                                name="place_id">
                                                            <option value="0">@lang('translation.Select')</option>
                                                            @foreach($places as $place)
                                                                <option
                                                                    value="{{ $place->id }}" {{ ($data && $data->place_id == $place->id) ? 'selected' : '' }}>
                                                                    {{ $place->name }}
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
                                                                <input class="form-check-input" type="checkbox"
                                                                       id="show"
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
                                                    <button type="submit"
                                                            class="btn btn-success waves-effect waves-light">
                                                        @lang('translation.Save')
                                                    </button>
                                                    <a href="{{route("tables")}}"
                                                       class="btn btn-danger waves-effect">
                                                        @lang('translation.Cancel')
                                                    </a>
                                                </div>


                                            </form>

                                            @if ($errors->any())
                                                <div class="alert alert-danger alert-dismissible fade show mt-3"
                                                     role="alert">
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
                                @if($data && $data->id != 0)
                                    <div class="tab-pane p-2 @if($tab=="details") active @endif" id="details"
                                         role="tabpanel">
                                        <p class="mb-0">
                                            @component('components.table-details', ["table_detail" => $table_detail ?? null, "data" => $data ?? null])
                                            @endcomponent
                                        </p>
                                    </div>
                                    <div class="tab-pane p-2 @if($tab=="rates") active @endif" id="rates"
                                         role="tabpanel">
                                        <p class="mb-0">
                                            @component('components.table-rates', ["table_rates" => $table_rates ?? [], "data" => $data ?? null])
                                            @endcomponent
                                        </p>
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
    <!-- tables -->
    <script src="{{ URL::asset('/assets/js/app/tables.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initTable();
        })();
    </script>
@endsection
