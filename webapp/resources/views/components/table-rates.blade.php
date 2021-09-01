<div class="row">
    <div class="col-xl-12">
        <div class="table-responsive">
            <table class="table table-striped w-100 align-middle">
                <thead>
                <tr class="text-center">
                    <th>@lang('translation.Id')</th>
                    <th>@lang('translation.Rate')</th>
                    <th>@lang('translation.Tax')</th>
                    <th>@lang('translation.TotalRate')</th>
                    <th>@lang('translation.ValidFrom')</th>
                    <th>@lang('translation.ValidTo')</th>
                    <th class="th45 no-sort">@lang('translation.Delete')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($table_rates as $item)
                    <tr class="text-center">
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->rate }}</td>
                        <td>{{ $item->tax }}</td>
                        <td>{{ $item->total_rate }}</td>
                        <td>{{ $item->valid_from_data }}</td>
                        <td>{{ $item->valid_to_data }}</td>
                        <td>
                            <a href="{{route("table.delete_rate", $item->id)}}"
                               class="text-danger sweet-warning"><i
                                    class="mdi mdi-delete font-size-18"></i></a>
                        </td>
                    </tr>
                @endforeach
                @if(count($table_rates) == 0)
                    <tr class="text-center">
                        <td colspan="6">
                            @lang('translation.NoData')
                        </td>
                    </tr>
                </tbody>
                @endif
            </table>
        </div>
        <hr/>
    </div>

    <div class="col-xl-6">
        <form autocomplete="off" method="POST"
              class="form-horizontal custom-validation"
              action="{{route("table.save_rate", $data->id ?? 0)}}">
            @csrf
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
                <label class="form-label">Tax</label>
                <div>
                    <input name="tax"
                           id="tax"
                           value="{{$data->tax ?? ''}}"
                           class="form-control"
                           required
                           data-parsley-type="number"
                           placeholder="Tax"/>
                </div>
            </div>

            <div class="mb-4">
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
            <div class="d-flex flex-wrap gap-2">
                <button type="submit"
                        class="btn btn-dark waves-effect waves-light">
                    @lang('translation.Add')
                </button>
            </div>
        </form>
    </div>
</div>
