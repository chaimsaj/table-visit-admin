<div class="row">
    <div class="col-xl-6">
        <form autocomplete="off" method="POST"
              class="form-horizontal"
              action="{{route("place.save_food_menu", $data->id ?? 0)}}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($data))
                <img class="rounded mt-2"
                     src="{{\App\Helpers\MediaHelper::getImageUrl($data->food_menu_path, \App\Core\MediaSizeEnum::large)}}"
                     alt=""/>
                <div class="text-muted">
                    {{$data->food_menu_path ?? ''}}
                </div>
                <hr/>
            @endif
            <div class="mb-4 mt-3">
                <label for="food_menu_path">@lang('translation.FoodMenu')</label>
                <input type="file" name="food_menu_path" class="form-control">
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
