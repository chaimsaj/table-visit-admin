@extends('layouts.master')

@section('title') @lang('translation.TableSpends') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Financial') @endslot
        @slot('title') @lang('translation.TableSpends') @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title col-sm-4">
                            @lang('translation.TableSpends')
                        </h4>
                        <div class="col-sm-8">

                        </div>
                    </div>
                    <hr/>
                    <div>Coming soon..</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- financial -->
    <script src="{{ URL::asset('/assets/js/app/financial.js') }}"></script>
    <script type="application/javascript">
        (function () {
            initTableSpends();
        })();
    </script>
@endsection
