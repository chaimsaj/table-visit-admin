@extends('layouts.master')

@section('title') @lang('translation.Booking') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Booking') @endslot
        @slot('title') @lang('translation.Reservations') @endslot
    @endcomponent

    <div class="row">
        <div class="col-4">
            <div class="card">
                {{--<h5 class="card-header bg-transparent border-bottom">Booking</h5>--}}
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('translation.Booking')</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                            <tr>
                                <th scope="row">@lang('translation.Code')</th>
                                <td>{{$data->code ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('translation.ConfirmationCode')</th>
                                <td>{{$data->confirmation_code ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('translation.Customer')</th>
                                <td>{{$data->customer ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('translation.Place')</th>
                                <td>{{$data->place ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('translation.BookDate')</th>
                                <td>{{$data->book_date ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('translation.GuestsCount')</th>
                                <td>{{$data->guests_count ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('translation.TableAmount')</th>
                                <td>{{$data->total_amount ?? ''}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    @if ($data->special_comment)
                        <div class="m-2 mt-3">
                            <h6>@lang('translation.SpecialComment')</h6>
                            <p>{{$data->special_comment ?? ''}}</p>
                        </div>
                    @endif
                    @if (!$data->closed_by_user_id && !$data->canceled_at)
                        <div class="mt-4 pt-2">
                            <a href="{{route("booking.close", $data->id)}}"
                               class="btn btn-dark float-end waves-effect waves-light sweet-warning">Close Booking</a>

                            <a href="{{route("booking.cancel", $data->id)}}"
                               class="btn btn-danger float-end waves-effect waves-light mr-15 sweet-warning">Cancel Booking</a>
                        </div>
                    @endif
                    {{--<div class="row">
                        <div class="col-6">
                            <div class="text-center mt-4 pt-2">
                                <a href="javascript: void(0);"
                                   class="btn btn-danger waves-effect waves-light">Cancel</a>
                            </div>
                        </div>
                        <div class="col-6">

                        </div>
                    </div>--}}
                </div>
                {{--<div class="card-footer bg-transparent border-top text-muted">
                    2 days ago
                </div>--}}
            </div>

            {{--<div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('translation.Information')</h4>
                    <div class="row">

                    </div>
                </div>
            </div>--}}
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('translation.Table')</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                            <tr>
                                <th scope="row">@lang('translation.ReservedTable')</th>
                                <td>{{$data->table_name ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('translation.TableNumber')</th>
                                <td>{{$data->table_number ?? '-'}}</td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('translation.AssignedTo')</th>
                                <td>{{$data->staff ?? ''}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('translation.TableSpends')</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap table-hover mb-0">
                            <thead>
                            <tr>
                                <th class="th45" scope="col">#</th>
                                <th scope="col">@lang('translation.BottleService')</th>
                                <th class="th45" scope="col">@lang('translation.TotalRate')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data->table_spends as $item)
                                <tr>
                                    <th scope="row">{{ $item->service_number }}</th>
                                    <td>{{ $item->service_name }}</td>
                                    <td class="text-center">${{ $item->total_amount }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr class="table-light">
                                <th></th>
                                <th></th>
                                <th class="text-center" scope="row">${{$data->table_spends_total ?? '0'}}</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- reservations -->
    <script src="{{ URL::asset('/assets/js/app/reservations.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initBooking();
        })();
    </script>
@endsection
