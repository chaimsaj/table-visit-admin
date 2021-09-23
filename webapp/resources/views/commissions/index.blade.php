@extends('layouts.master')

@section('title') @lang('translation.Commissions') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Financial') @endslot
        @slot('title') @lang('translation.Commissions') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title col-sm-4">
                            @lang('translation.Commissions')
                        </h4>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <a href="{{route("commission.detail", 0)}}"
                                   class="btn btn-primary waves-effect waves-light"><i
                                        class="mdi mdi-plus me-1"></i> @lang('translation.AddNew')
                                </a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <hr/>
                    <table id="datatable"
                           class="table table-bordered dt-responsive nowrap w-100 align-middle">
                        <thead class="table-light">
                        <tr class="text-center">
                            <th>@lang('translation.Id')</th>
                            <th>@lang('translation.Percentage')</th>
                            <th>@lang('translation.FixedRate')</th>
                            <th>@lang('translation.MinRate')</th>
                            <th>@lang('translation.MaxRate')</th>
                            <th class="th45 no-sort">@lang('translation.Delete')</th>
                            <th class="th45 no-sort">@lang('translation.Edit')</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach ($data as $item)
                            <tr class="text-center">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->percentage }}</td>
                                <td>{{ $item->rate }}</td>
                                <td>{{ $item->min_rate }}</td>
                                <td>{{ $item->max_rate }}</td>
                                <td>
                                    <a href="{{route("commission.delete", $item->id)}}" class="text-danger sweet-warning"><i
                                            class="mdi mdi-delete font-size-18"></i></a>
                                </td>
                                <td>
                                    <a href="{{route("commission.detail", $item->id)}}" class="text-success"><i
                                            class="mdi mdi-pencil font-size-18"></i></a>
                                </td>
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
    <!-- financial -->
    <script src="{{ URL::asset('/assets/js/app/financial.js?') . config('app.version') }}"></script>
    <script type="application/javascript">
        (function () {
            initCommissions();
        })();
    </script>
@endsection
