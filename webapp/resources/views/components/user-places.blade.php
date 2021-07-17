<div class="row">
    <div class="col-xl-6">
        <form autocomplete="off" method="POST"
              class="form-horizontal custom-validation"
              action="{{route("user.save", $place->id ?? 0)}}">
            @csrf
            <div class="mb-4 mt-4">
                <label class="form-label">@lang('translation.Places')</label>
                <div>
                    <select id="place_id" class="form-select" name="place_id">
                        <option value="0">@lang('translation.Select')</option>
                        @if (isset($places))
                            @foreach($places as $place)
                                <option
                                    value="{{ $place->id }}" {{ ($data && $data->place_id == $place->id) ? 'selected' : '' }}>
                                    {{ $place->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="submit"
                        class="btn btn-info waves-effect waves-light">
                    @lang('translation.Add')
                </button>
                {{--<a href="{{route("users")}}"
                   class="btn btn-danger waves-effect">
                    @lang('translation.Cancel')
                </a>--}}
            </div>
        </form>
    </div>
</div>
