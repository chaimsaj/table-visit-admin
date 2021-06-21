@extends('layouts.master')

@section('title') @lang('translation.Users') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Users') @endslot
        @slot('title') @lang('translation.Detail') @endslot
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
                                          action="{{route("user.save", $data->id ?? 0)}}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <img class="rounded-circle header-profile-user"
                                             src="{{ isset($data->avatar) ? asset($data->avatar) : asset('/assets/images/users/avatar-1.jpg') }}"
                                             alt="">
                                        <hr />
                                        {{--<div class="mb-3">
                                            <label for="avatar">Profile Picture</label>
                                            <div class="input-group">
                                                <input type="file" name="avatar" class="form-control">
                                                <label class="input-group-text" for="avatar">Upload</label>
                                            </div>

                                        </div>--}}
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name"
                                                   value="{{$data->name ?? ''}}"
                                                   class="form-control" value="" required placeholder="Name"/>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div>
                                                <input type="password" name="password"
                                                       id="password" class="form-control"
                                                       {{!isset($data->id) ? 'required' : ''}} placeholder="Password"/>
                                            </div>
                                            <div class="mt-2">
                                                <input type="password"
                                                       class="form-control"
                                                       {{!isset($data->id) ? 'required' : ''}} data-parsley-equalto="#password"
                                                       placeholder="Re-Type Password"/>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">E-Mail</label>
                                            <div>
                                                <input name="email" type="email"
                                                       value="{{$data->email ?? ''}}"
                                                       class="form-control" required parsley-type="email"
                                                       placeholder="Enter a valid e-mail"/>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">User Type</label>
                                            <div>
                                                <select class="form-select" name="user_type_id">
                                                    <option value="0">@lang('translation.Select')</option>
                                                    @foreach($user_types as $user_type)
                                                        <option value="{{ $user_type->key }}" {{ ($data && $data->user_type_id == $user_type->key) ? 'selected' : '' }}>
                                                            {{ $user_type->value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="submit" class="btn btn-success waves-effect waves-light">
                                                @lang('translation.Save')
                                            </button>
                                            <a href="{{route("users")}}"
                                               class="btn btn-danger waves-effect">
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

@endsection
