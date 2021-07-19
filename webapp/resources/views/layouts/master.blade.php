<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8"/>
    <title> @yield('title') | @lang('translation.TableVisit')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="@lang('translation.TableVisit')" name="description"/>
    <meta content="@lang('translation.TableVisit')" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    @include('layouts.head-css')
</head>

@section('body')
    <body data-sidebar="dark">
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    @show
    <!-- Begin page -->
    <div id="layout-wrapper">
    @include('layouts.topbar')

    @if(Auth::user() && Auth::user()->user_type_id == \App\Core\UserTypeEnum::Admin)
        @include('layouts.sidebar')
    @endif

    @if(Auth::user() && Auth::user()->user_type_id != \App\Core\UserTypeEnum::Admin)
        @include('layouts.sidebar-place')
    @endif
    <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    {{--@include('layouts.right-sidebar')--}}
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
    </body>

</html>
