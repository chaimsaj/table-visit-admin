@extends('layouts.master')

@section('title') @lang('translation.Countries') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Locations') @endslot
        @slot('title') @lang('translation.Country') @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Information</h4>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" class="form-horizontal custom-validation"
                                          action="{{route("country.save", $data->id ?? 0)}}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name"
                                                   value="{{$data->name ?? ''}}"
                                                   class="form-control" value="" required placeholder="Name"/>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Code</label>
                                            <div>
                                                <input name="iso_code" type="iso_code"
                                                       value="{{$data->iso_code ?? ''}}"
                                                       class="form-control" required
                                                       placeholder="Code"/>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Display order</label>
                                            <div>
                                                <input name="display_order" type="display_order"
                                                       value="{{$data->display_order ?? ''}}"
                                                       class="form-control" required
                                                       placeholder="Display order"/>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="submit" class="btn btn-success waves-effect waves-light">
                                                @lang('translation.Save')
                                            </button>
                                            <a href="{{route("countries")}}"
                                               class="btn btn-secondary waves-effect">
                                                @lang('translation.Cancel')
                                            </a>
                                        </div>


                                    </form>

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                            @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                            @endforeach
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="close"></button>
                                        </div>
                                    @endif

                                </div>
                            </div> <!-- end col -->
                        </div>


                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
@section('script')
    <!-- locations -->
    <script src="{{ URL::asset('/assets/js/app/locations.js') }}"></script>
@endsection
