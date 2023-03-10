@extends('layouts.app')

@section('content')


    <div class="d-flex justify-content-center profil">
        <form class="bg-gray rounded profil-form my-3 m-md-0 shadow-lg d-flex flex-column" action="{{ route('user.register') }}" method="POST">
            @csrf
            <nav class="bg-dark profil-nav d-flex align-items-center justify-content-between px-2">
                <div class="profil-group-input text-white fs-4 p-2">
                    <a href="{{ url()->previous() }}" title="@lang('profil.previous_page')" class="link-nodecoration">
                        <picture>
                            <source srcset="{{ asset('/icons/previous.webp') }}" type="image/webp">
                            <img src="{{ asset('/icons/previous.png') }}" loading="lazy" width="25" height="25" alt="@lang('profil.previous_page')" title="@lang('profil.previous_page')">
                        </picture>
                    </a>
                    <span class="ms-2">New user</span>
                </div>
                <div class="profil-group-input">
                    <button class="btn btn-sm">
                        <picture>
                            <source srcset="{{ asset('/icons/save.webp') }}" type="image/webp">
                            <img src="{{ asset('/icons/save.png') }}" loading="lazy" width="25" height="25" alt="@lang('profil.save')" title="@lang('profil.save')">
                        </picture>
                    </button>
                    <button class="btn btn-sm">
                        <picture>
                            <source srcset="{{ asset('/icons/save.webp') }}" type="image/webp">
                            <img src="{{ asset('/icons/save.png') }}" loading="lazy" width="25" height="25" alt="@lang('profil.save_exit')" title="@lang('profil.save_exit')">
                        </picture>
                    </button>
                </div>
            </nav>
            <div class="row p-5 g-3 m-0">
                <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">@lang('profil.first_name')</label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror " id="validationCustom01" name="first_name" placeholder="@lang('profil.first_name')" value="{{ old('first_name', "") }}" required>
                    @error('first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">@lang('profil.last_name')</label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror " id="validationCustom02" name="last_name" value="{{ old('last_name', "") }}" placeholder="@lang('profil.last_name')" required>
                    @error('last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">@lang('profil.email_company')</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" class="form-control @error('email_company') is-invalid @enderror" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="email_company" value="{{ old('email_company', "") }}" placeholder="@lang('profil.email_company')" required>
                        @error('email_company')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">@lang('profil.email_private')</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" class="form-control @error('email_private') is-invalid @enderror" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="email_private" value="{{ old('email_private', "") }}" placeholder="@lang('profil.email_private')" required>
                        @error('email_private')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">@lang('profil.number_phone')</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="number_phone" value="{{ old('number_phone', "") }}" placeholder="@lang('profil.number_phone')" required>
                        @error('number_phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom03" class="form-label">@lang('profil.group')</label>
                    <input type="text" class="form-control" value="{{ $user->group->name ?? "test" }}" id="validationCustom03" disabled>
                </div>
                <div class="col-md-2">
                    <label for="validationCustomUsername" class="form-label">@lang('profil.city')</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="city" value="{{ old('city', "") }}" placeholder="@lang('profil.city')" required>
                        @error('city')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="validationCustomUsername" class="form-label">@lang('profil.zip_code')</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="zip_code" value="{{ old('zip_code', "") }}" placeholder="@lang('profil.zip_code')" required>
                        @error('zip_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">@lang('profil.street')</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control @error('street') is-invalid @enderror" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="street" value="{{ old('street', "") }}" placeholder="@lang('profil.street')" required>
                        @error('street')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">@lang('profil.role')</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control @error('role_id') is-invalid @enderror" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="street" value="{{ old('role_id', '') }}" placeholder="@lang('profil.role')" required>
                        @error('role_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">@lang('profil.password')</label>
                    <div class="input-group has-validation">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="password" value="{{ old('password', '') }}" placeholder="@lang('profil.password')" required>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">@lang('profil.password_confirmation')</label>
                    <div class="input-group has-validation">
                        <input type="password" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="password_confirmation" value="{{ old('password_confirmation', '') }}" placeholder="@lang('profil.password_confirmation')" required>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
