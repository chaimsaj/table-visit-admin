@extends('layouts.master')

@section('title') @lang('translation.Bottle') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.BottlesAndDrinks') @endslot
        @slot('title') @lang('translation.Bottle') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('translation.Information')</h4>
                    <div class="row">
                        <div class="col-xl-6">
                            <form autocomplete="off" method="POST" class="form-horizontal custom-validation"
                                  action="{{route("service.save", $data->id ?? 0)}}">
                                @csrf
                                <hr/>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name"
                                           value="{{$data->name ?? ''}}"
                                           class="form-control" value="" required placeholder="Name"/>
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
                                    <label class="form-label">Drink type</label>
                                    <div>
                                        <select id="service_type_id" class="form-select select2" name="service_type_id">
                                            <option value="0">@lang('translation.Select')</option>
                                            @foreach($service_types as $service_type)
                                                <option
                                                    value="{{ $service_type->id }}" {{ ($data && $data->service_type_id == $service_type->id) ? 'selected' : '' }}>
                                                    {{ $service_type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @if($is_admin)
                                    <div class="mb-3">
                                        <label class="form-label">Tenant</label>
                                        <div>
                                            <select class="form-select" name="tenant_id">
                                                <option value="0">@lang('translation.Select')</option>
                                                @foreach($tenants as $tenant)
                                                    <option
                                                        value="{{ $tenant->id }}" {{ ($data && $data->tenant_id == $tenant->id) ? 'selected' : '' }}>
                                                        {{ $tenant->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

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
                                    <a href="{{route("services")}}"
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
    <script src="{{ URL::asset('/assets/js/app/services.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initService();
        })();
    </script>
@endsection
