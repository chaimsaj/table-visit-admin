<div class="row">
    <div class="col-xl-12">
        <div class="table-responsive">
            <table class="table table-striped w-100 align-middle">
                <thead>
                <tr class="text-center">
                    <th class="th10p">@lang('translation.Id')</th>
                    <th>@lang('translation.Feature')</th>
                    <th class="th45">@lang('translation.Delete')</th>
                    <th class="th45">@lang('translation.View')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($place_features as $item)
                    <tr class="text-center">
                        <td>{{ $item->rel_id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <a href="{{route("place.delete_feature_to_place", $item->rel_id)}}"
                               class="text-danger sweet-warning"><i
                                    class="mdi mdi-delete font-size-18"></i></a>
                        </td>
                        <td>
                            <a href="{{route("place-feature.detail", $item->id)}}" target="_blank"
                               class="text-secondary"><i
                                    class="mdi mdi-arrow-top-right font-size-18"></i></a>
                        </td>
                    </tr>
                @endforeach
                @if(count($place_features) == 0)
                    <tr class="text-center">
                        <td colspan="4">
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
              class="form-horizontal"
              action="{{route("place.save_feature_to_place", $data->id ?? 0)}}">
            @csrf
            <div class="mb-4">
                <label class="form-label">@lang('translation.AddFeatures')</label>
                <div>
                    <select id="place_feature_id" class="form-select select2" name="place_feature_id">
                        <option value="0">@lang('translation.Select')</option>
                        @if (isset($features))
                            @foreach($features as $feature)
                                <option value="{{ $feature->id }}">
                                    {{ $feature->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
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
