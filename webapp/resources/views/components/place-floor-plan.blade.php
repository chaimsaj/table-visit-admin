<div class="row">
    <div class="col-xl-6">
        <form autocomplete="off" method="POST"
              class="form-horizontal"
              action="{{route("place.save_floor_plan", $data->id ?? 0)}}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($data))
                <img class="rounded mt-2"
                     src="{{$data->floor_plan_path_url ?? ''}}"
                     alt=""/>
                {{--<div class="text-muted">
                    {{$data->floor_plan_path ?? ''}}
                </div>--}}
                <hr/>
            @endif
            <div class="mb-4 mt-3">
                <label for="floor_plan_path">@lang('translation.FloorPlan')</label>
                <input type="file" name="floor_plan_path" class="form-control">
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="submit"
                        class="btn btn-dark waves-effect waves-light">
                    @lang('translation.Save')
                </button>
            </div>
        </form>
    </div>
</div>
