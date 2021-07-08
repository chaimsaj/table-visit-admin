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
                            <form autocomplete="off" method="POST" class="form-horizontal custom-validation"
                                  action="{{route("user.save", $data->id ?? 0)}}"
                                  enctype="multipart/form-data">
                                @csrf
                                @if(isset($data))
                                    <img class="rounded avatar-md mt-2"
                                         src="{{\App\Helpers\MediaHelper::getImageUrl($data->avatar, \App\Core\MediaSizeEnum::medium)}}"
                                         alt=""/>
                                @endif
                                <hr/>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name"
                                           value="{{$data->name ?? ''}}"
                                           class="form-control" value="" required placeholder="Name"/>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name"
                                           value="{{$data->last_name ?? ''}}"
                                           class="form-control" value="" required placeholder="Last Name"/>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="password" name="password"
                                                       id="password" class="form-control"
                                                       {{!isset($data->id) ? 'required' : ''}} placeholder="Password"/>
                                            </div>
                                            <div class="col-6">
                                                <input type="password"
                                                       class="form-control"
                                                       {{!isset($data->id) ? 'required' : ''}} data-parsley-equalto="#password"
                                                       placeholder="Re-Type Password"/>
                                            </div>
                                        </div>
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
                                    <label for="avatar">@lang('translation.ProfilePicture')</label>
                                    <div class="input-group">
                                        <input type="file" name="avatar" class="form-control">
                                        <label class="input-group-text" for="avatar">@lang('translation.Upload')</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">User Type</label>
                                    <div>
                                        <select class="form-select" name="user_type_id">
                                            <option value="0">@lang('translation.Select')</option>
                                            @foreach($user_types as $user_type)
                                                <option
                                                    value="{{ $user_type->key }}" {{ ($data && $data->user_type_id == $user_type->key) ? 'selected' : '' }}>
                                                    {{ $user_type->value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       {{($data && $data->published == 1) ? 'checked' : ''}}
                                                       id="published"
                                                       name="published">
                                                <label class="form-check-label" for="published">
                                                    Published
                                                </label>
                                            </div>
                                        </div>
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


                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection

@section('script')

@endsection
