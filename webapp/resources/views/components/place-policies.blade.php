<div class="row">
    <div class="col-xl-8">
        <form autocomplete="off" method="POST"
              class="form-horizontal"
              action="{{route("place.save_policies", $data->id ?? 0)}}">
            @csrf
            <div class="mb-3 mt-3">
                <label class="form-label">@lang('translation.PlaceReservationPolicy')</label>
                <div>
                    <textarea id="place_reservation_policy"
                              name="place_reservation_policy">{{$place_reservation_policy->detail ?? ''}}</textarea>
                </div>
            </div>
            <div class="mb-4 mt-3">
                <label class="form-label">@lang('translation.PlaceCancellationPolicy')</label>
                <div>
                    <textarea id="place_cancellation_policy"
                              name="place_cancellation_policy">{{$place_cancellation_policy->detail ?? ''}}</textarea>
                </div>
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
