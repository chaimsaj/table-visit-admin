@extends('layouts.master')

@section('title') @lang('translation.TableTypes') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Tables') @endslot
        @slot('title') @lang('translation.TableTypes') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title col-sm-4">
                            @lang('translation.TableTypes')
                        </h4>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <a href="{{route("table-type.detail", 0)}}"
                                   class="btn btn-primary waves-effect waves-light"><i
                                        class="mdi mdi-plus me-1"></i>
                                    @lang('translation.AddNew')
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
                            <th>@lang('translation.Name')</th>
                            <th>@lang('translation.DisplayOrder')</th>
                            <th class="th45 no-sort">@lang('translation.Delete')</th>
                            <th class="th45 no-sort">@lang('translation.Edit')</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach ($data as $item)
                            <tr class="text-center">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->display_order }}</td>
                                <td>
                                    <a href="{{route("table-type.delete", $item->id)}}" class="text-danger sweet-warning"><i
                                            class="mdi mdi-delete font-size-18"></i></a>
                                </td>
                                <td>
                                    <a href="{{route("table-type.detail", $item->id)}}" class="text-success"><i
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
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <!-- tables -->
    <script src="{{ URL::asset('/assets/js/app/tables.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initTableTypes();
        })();
    </script>
@endsection
