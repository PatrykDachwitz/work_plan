@extends('layouts.app')

@section('content')
    <form class="calendar shadow rounded" action="{{ route('register') }}" method="POST">
        @csrf
        <div class="calendar-header m-0 p-0 row text-white">
            <div class="group-button-add-holidays">
                <a href="{{ url()->previous() }}">Back</a>
                <span></span>
                <span></span>
            </div>

            <div class="button-group-filter">
                <button class="button-group-filter-single">Zapisz</button>
                <button class="button-group-filter-single">Zapisz i wyjdz</button>
                <button class="button-group-filter-single">Zapisz i nowy</button>
            </div>
        </div>
        <div class="status-body">
            <div class="m-md-5 d-flex">
                <picture>
                    <img src="https://avatars.githubusercontent.com/u/98681?v=4" class="rounded-circle me-5 border border-dark border-2" width="250" height="250">
                </picture>
                <div class="row g-3 ms-5 needs-validation">
                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">First name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror " id="validationCustom01" name="first_name" value="{{ old('first_name', '') }}" placeholder="First name" required>
                            @error('first_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom02" class="form-label">Last name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror " id="validationCustom02" name="last_name" value="{{ old('last_name', '') }}" placeholder="Last name" required>
                            @error('last_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustomUsername" class="form-label">Email company</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                <input type="text" class="form-control" id="validationCustomUsername @error('email_company') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="email_company" value="{{ old('email_company', '') }}" placeholder="Email company" required>
                                @error('email_company')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustomUsername" class="form-label">Email private</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                <input type="text" class="form-control" id="validationCustomUsername @error('email_private') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="email_private" value="{{ old('email_private', '') }}" placeholder="Email private" required>
                                @error('email_private')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustomUsername" class="form-label">Number phone</label>
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" id="validationCustomUsername @error('email') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="number_phone" value="{{ old('number_phone', '') }}" placeholder="Number phone" required>
                                @error('number_phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom03" class="form-label">Group</label>
                            <input type="text" class="form-control" value="{{ $user->group->name ?? "test" }}" id="validationCustom03" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="validationCustomUsername" class="form-label">City</label>
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" id="validationCustomUsername @error('city') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="city" value="{{ old('city', '') }}" placeholder="City" required>
                                @error('city')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="validationCustomUsername" class="form-label">Zip code</label>
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" id="validationCustomUsername @error('zip_code') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="zip_code" value="{{ old('zip_code', '') }}" placeholder="Zip code" required>
                                @error('zip_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustomUsername" class="form-label">Street</label>
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" id="validationCustomUsername @error('street') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="street" value="{{ old('street', '') }}" placeholder="Street" required>
                                @error('street')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustomUsername" class="form-label">Role</label>
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" id="validationCustomUsername @error('role_id') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="street" value="{{ old('role_id', '') }}" placeholder="Role" required>
                                @error('role_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustomUsername" class="form-label">Role</label>
                            <div class="input-group has-validation">
                                <input type="password" class="form-control" id="validationCustomUsername @error('password') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="password" value="{{ old('password', '') }}" placeholder="Password" required>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustomUsername" class="form-label">Password confirmation</label>
                            <div class="input-group has-validation">
                                <input type="password" class="form-control" id="validationCustomUsername @error('password_confirmation') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="password_confirmation" value="{{ old('password_confirmation', '') }}" placeholder="Password confirmation" required>
                                @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                </div>
            </div>

        </div>
    </form>
@endsection
