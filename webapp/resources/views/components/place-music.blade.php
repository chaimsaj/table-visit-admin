<div class="row">
    <div class="col-xl-12">
        <div class="table-responsive">
            <table class="table table-striped w-100 align-middle">
                <thead>
                <tr class="text-center">
                    <th class="th10p">@lang('translation.Id')</th>
                    <th>@lang('translation.Music')</th>
                    <th class="th45">@lang('translation.Delete')</th>
                    <th class="th45">@lang('translation.View')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($place_music as $item)
                    <tr class="text-center">
                        <td>{{ $item->rel_id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <a href="{{route("place.delete_music_to_place", $item->rel_id)}}"
                               class="text-danger sweet-warning"><i
                                    class="mdi mdi-delete font-size-18"></i></a>
                        </td>
                        <td>
                            <a href="{{route("place-music.detail", $item->id)}}" target="_blank"
                               class="text-secondary"><i
                                    class="mdi mdi-arrow-top-right font-size-18"></i></a>
                        </td>
                    </tr>
                @endforeach
                @if(count($place_music) == 0)
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
              action="{{route("place.save_music_to_place", $data->id ?? 0)}}">
            @csrf
            <div class="mb-4">
                <label class="form-label">@lang('translation.AddMusic')</label>
                <div>
                    <select id="place_music_id" class="form-select" name="place_music_id">
                        <option value="0">@lang('translation.Select')</option>
                        @if (isset($music))
                            @foreach($music as $music_item)
                                <option value="{{ $music_item->id }}">
                                    {{ $music_item->name }}
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
