@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.LockScreen')
@endsection

@section('css')

@endsection

@section('body')

    <body class="auth-body-bg">
    @endsection

    @section('content')

        <div>
            <div class="container-fluid p-0">
                <div class="row g-0">

                    <div class="col-xl-9">
                        <div class="auth-full-bg pt-lg-5 p-4">
                            <div class="w-100">
                                <div class="bg-overlay"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-3">
                        <div class="auth-full-page-content p-md-5 p-4">
                            <div class="w-100">

                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5">
                                        <a href="index" class="d-block auth-logo">
                                            <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt=""
                                                 height="18"
                                                 class="auth-logo-dark">
                                            <img src="{{ URL::asset('/assets/images/logo-light.png') }}" alt=""
                                                 height="18"
                                                 class="auth-logo-light">
                                        </a>
                                    </div>
                                    <div class="my-auto">

                                        <div>
                                            <h5 class="text-primary">Lock screen</h5>
                                            <p class="text-muted">Enter your password to unlock the screen!</p>
                                        </div>

                                        <div class="mt-4">
                                            <form class="form-horizontal" action="{{ route('login') }}">

                                                {{--<div class="user-thumb text-center mb-4">
                                                    <img src="assets/images/users/avatar-1.jpg"
                                                         class="rounded-circle img-thumbnail avatar-md" alt="thumbnail">
                                                    <h5 class="font-size-15 mt-3">Maria Laird</h5>
                                                </div>--}}


                                                <div class="mb-3">
                                                    <label for="userpassword">Password</label>
                                                    <input type="password" class="form-control" id="userpassword"
                                                           placeholder="Enter password">
                                                </div>

                                                <div class="text-end">
                                                    <button class="btn btn-primary w-md waves-effect waves-light"
                                                            type="submit">Unlock
                                                    </button>
                                                </div>

                                            </form>
                                            <div class="mt-5 text-center">
                                                <p>Not you ? return <a href="{{ route('login') }}"
                                                                       class="fw-medium text-primary">
                                                        Sign In </a></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">
                                            <script>
                                                document.write(new Date().getFullYear())

                                            </script>
                                            @lang('translation.TableVisit') &trade;
                                        </p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </div>

@endsection
@section('script')

@endsection
