<div class="row">
    <div class="col-xl-8">
        <form autocomplete="off" method="POST"
              class="form-horizontal custom-validation"
              action="{{route("table.save_details", $data->id ?? 0)}}">
            @csrf
            <div class="mb-4 mt-3">
                <label class="form-label">@lang('translation.TableDescription')</label>
                <div>
                    <textarea required class="form-control" rows="4" id="table_detail"
                              name="table_detail">{{$table_detail->detail ?? ''}}</textarea>
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
