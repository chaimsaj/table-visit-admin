<div class="row">
    <div class="col-xl-12">
        <div class="table-responsive">
            <table class="table table-striped w-100 align-middle">
                <thead>
                <tr class="text-center">
                    <th>@lang('translation.Id')</th>
                    <th class="th45 no-sort">@lang('translation.Delete')</th>
                    <th class="th45 no-sort">@lang('translation.Edit')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($table_rates as $item)
                    <tr class="text-center">
                        <td>{{ $item->rel_id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->display_order }}</td>
                        <td>{{ $item->city_name }}</td>
                        <td>
                            <a href="{{route("table.delete_rate", $item->id)}}"
                               class="text-danger sweet-warning"><i
                                    class="mdi mdi-delete font-size-18"></i></a>
                        </td>
                        <td>
                            <a href="{{route("table.edit_rate", $item->id)}}" class="text-success"><i
                                    class="mdi mdi-pencil font-size-18"></i></a>
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
            <div class="mb-4">

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
