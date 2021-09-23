@extends('layouts.master')

@section('title') @lang('translation.Fee') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Financial') @endslot
        @slot('title') @lang('translation.Fee') @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('translation.Information')</h4>
                    <div class="row">
                        <div class="col-xl-6">
                            <form autocomplete="off" method="POST" class="form-horizontal custom-validation"
                                  action="{{route("fee.save", $data->id ?? 0)}}">
                                @csrf
                                <hr/>
                                <div class="mb-3">
                                    <label class="form-label">Percentage</label>
                                    <input name="percentage"
                                           data-parsley-type="number"
                                           value="{{$data->percentage ?? ''}}"
                                           class="form-control" placeholder="Percentage"/>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Fixed rate</label>
                                    <div>
                                        <input name="rate"
                                               data-parsley-type="number"
                                               value="{{$data->rate ?? ''}}"
                                               class="form-control"
                                               placeholder="Fixed rate"/>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Min rate</label>
                                            <div>
                                                <input name="min_rate"
                                                       data-parsley-type="number"
                                                       value="{{$data->min_rate ?? ''}}"
                                                       class="form-control"
                                                       placeholder="Min rate"/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Max rate</label>
                                            <div>
                                                <input name="max_rate"
                                                       data-parsley-type="number"
                                                       value="{{$data->max_rate ?? ''}}"
                                                       class="form-control"
                                                       placeholder="Max rate"/>
                                            </div>
                                        </div>
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
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">
                                        @lang('translation.Save')
                                    </button>
                                    <a href="{{route("fees")}}"
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
    <!-- financial -->
    <script src="{{ URL::asset('/assets/js/app/financial.js?') . config('app.version') }}"></script>
    <script type="application/javascript">
        (function () {
            initFee();
        })();
    </script>
@endsection
