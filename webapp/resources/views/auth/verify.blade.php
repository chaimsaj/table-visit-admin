@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.VerifyPassword')
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
                                            <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="" height="18"
                                                class="auth-logo-dark">
                                            <img src="{{ URL::asset('/assets/images/logo-light.png') }}" alt="" height="18"
                                                class="auth-logo-light">
                                        </a>
                                    </div>
                                    <div class="my-auto">

                                        <div>
                                            <h5 class="text-primary">@lang('translation.VerifyPassword')</h5>
                                            <p class="text-muted">Re-Password now</p>
                                        </div>

                                        <div class="mt-4">
                                            <form autocomplete="off" class="form-horizontal" method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="username">email</label>
                                                    <input name="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        @if (old('email'))
                                                    value="{{ old('email') }}" @endif id="email"
                                                    placeholder="Enter email" autocomplete="email" autofocus>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="text-end">
                                                    <button class="btn btn-primary w-md waves-effect waves-light"
                                                        type="submit">Reset</button>
                                                </div>
                                            </form>
                                            <div class="mt-5 text-center">
                                                <p>Remember It ? <a href="{{ url('login') }}"
                                                        class="font-weight-medium text-primary"> Sign In here</a> </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0"><script>
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
        <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>
    @endsection
