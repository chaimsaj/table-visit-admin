@extends('layouts.master')

@section('title') @lang('translation.TableSpends') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Financial') @endslot
        @slot('title') @lang('translation.TableSpends') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{--<h4 class="card-title col-sm-4">
                        @lang('translation.TableSpends')
                    </h4>--}}

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3">
                                    <div class="row">
                                        <label class="col-md-4 col-form-label text-end">Date from</label>
                                        <div class="col-md-8">
                                            <div class="input-group" id="cnt_date_from">
                                                <input type="text" class="form-control" placeholder="mm-dd-yyyy"
                                                       name="date_from" id="date_from"
                                                       data-date-orientation="bottom"
                                                       data-date-autoclose="true"
                                                       data-date-format="mm-dd-yyyy"
                                                       data-date-container='#cnt_date_from'
                                                       data-provide="datepicker"
                                                       value="">
                                                <span class="input-group-text"><i
                                                        class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row">
                                        <label class="col-md-4 col-form-label text-end">Date to</label>
                                        <div class="col-md-8">
                                            <div class="input-group" id="cnt_date_to">
                                                <input type="text" class="form-control" placeholder="mm-dd-yyyy"
                                                       name="date_to" id="date_to"
                                                       data-date-orientation="bottom"
                                                       data-date-autoclose="true"
                                                       data-date-format="mm-dd-yyyy"
                                                       data-date-container='#cnt_date_to'
                                                       data-provide="datepicker"
                                                       value="">
                                                <span class="input-group-text"><i
                                                        class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <label class="col-md-4 col-form-label text-end">Place</label>
                                        <div class="col-md-8">
                                            <select class="form-select select2" id="place_id" name="place_id">
                                                <option value="0">@lang('translation.Select')</option>
                                                @foreach($places as $place)
                                                    <option value="{{ $place->id }}" }}>
                                                        {{ $place->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button"
                                                id="btnSearch"
                                                class="btn btn-outline-dark waves-effect waves-light">
                                            @lang('translation.Search')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <table id="table-spends-datatable"
                           class="table table-bordered dt-responsive nowrap w-100 align-middle text-center">
                        <thead class="table-light">
                        <tr class="text-center">
                            <th class="no-sort">@lang('translation.Id')</th>
                            <th>@lang('translation.Code')</th>
                            <th>@lang('translation.ConfirmationCode')</th>
                            <th>@lang('translation.BookDate')</th>
                            <th>@lang('translation.TableAmount')</th>
                            <th>@lang('translation.SpendsAmount')</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <!-- financial -->
    <script src="{{ URL::asset('/assets/js/app/financial.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initTableSpends();
        })();
    </script>
@endsection
