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
                        <div class="col-xl-6">
                            <form autocomplete="off" method="POST" class="form-horizontal custom-validation"
                                  action="{{route("table.save", $data->id ?? 0)}}">
                                @csrf
                                <hr/>
                                <div class="mb-3">
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
                                    <label class="form-label">Display order</label>
                                    <div>
                                        <input name="display_order"
                                               value="{{$data->display_order ?? ''}}"
                                               class="form-control"
                                               data-parsley-type="number"
                                               required
                                               placeholder="Display order"/>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Table type</label>
                                    <div>
                                        <select id="table_type_id" class="form-select" name="table_type_id">
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
                                        <select id="place_id" class="form-select" name="place_id">
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
                                    <a href="{{route("tables")}}"
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
    <!-- tables -->
    <script src="{{ URL::asset('/assets/js/app/tables.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initTable();
        })();
    </script>
@endsection
