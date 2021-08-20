@extends('layouts.master')

@section('title') @lang('translation.Logs') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Settings') @endslot
        @slot('title') @lang('translation.Logs') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title col-sm-4">
                            @lang('translation.Logs')
                        </h4>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <form autocomplete="off" method="POST" class="form-horizontal"
                                      action="{{route("logs.truncate")}}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger waves-effect waves-light">
                                        @lang('translation.Clear')
                                    </button>
                                </form>
                                {{--<a href="{{route("currency.detail", 0)}}"
                                   class="btn btn-primary waves-effect waves-light"><i
                                        class="mdi mdi-plus me-1"></i> @lang('translation.AddNew')
                                </a>--}}
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <table id="datatable"
                           class="table table-bordered dt-responsive nowrap w-100 align-middle">
                        <thead class="table-light">
                        <tr class="text-center">
                            <th>@lang('translation.Id')</th>
                            <th>@lang('translation.Code')</th>
                            <th>@lang('translation.Error')</th>
                            <th>@lang('translation.Date')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr class="text-center">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->error }}</td>
                                <td>{{ $item->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <!-- locations -->
    <script src="{{ URL::asset('/assets/js/app/settings.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initLogs();
        })();
    </script>
@endsection
