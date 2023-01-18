@extends('layouts.app')

@section('content')
    @isset($user)
    <form class="calendar shadow rounded" action="{{ route('user.update', [
    'id' => $user->id
        ]) }}" method="POST">
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
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror " id="validationCustom01" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                            @error('first_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom02" class="form-label">Last name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror " id="validationCustom02" name="last_name" value="{{ old('last_name', $user->last_name ?? "") }}" placeholder="Last name" required>
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
                                <input type="text" class="form-control" id="validationCustomUsername @error('email_company') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="email_company" value="{{ old('email_company', $user->email_company ?? "") }}" placeholder="Email company" required>
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
                                <input type="text" class="form-control" id="validationCustomUsername @error('email_private') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="email_private" value="{{ old('email_private', $user->email_private ?? "") }}" placeholder="Email private" required>
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
                                <input type="text" class="form-control" id="validationCustomUsername @error('email') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="number_phone" value="{{ old('number_phone', $user->number_phone ?? "") }}" placeholder="Number phone" required>
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
                                <input type="text" class="form-control" id="validationCustomUsername @error('city') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="city" value="{{ old('city', $user->city ?? "") }}" placeholder="City" required>
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
                                <input type="text" class="form-control" id="validationCustomUsername @error('zip_code') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="zip_code" value="{{ old('zip_code', $user->zip_code ?? "") }}" placeholder="Zip code" required>
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
                                <input type="text" class="form-control" id="validationCustomUsername @error('street') is-invalid @enderror " aria-describedby="inputGroupPrepend" name="street" value="{{ old('street', $user->street ?? "") }}" placeholder="Street" required>
                                @error('street')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom05" class="form-label">Token Api</label>
                            <input type="text" class="form-control" id="validationCustom05" value="{{ $user->token_api }}" disabled>
                        </div>
                </div>
            </div>
            <div class="status-body-status">
                <div class="days-body-status bg-dark fs-4 text-white ps-3 py-2">
                    Zdarzenia w ciągu dnia
                </div>
                <div class="d-md-flex d-none justify-content-evenly fs-5 mt-4">
                    <div style="min-height: 250px;min-width:250px;border: 20px solid #319330; border-radius:100%" class="d-flex justify-content-center align-items-center fs-3 mx-5" ><span>Urlop<br>150H</span></div>
                    <div style="min-height: 250px;min-width:250px;border: 20px solid #319330; border-radius:100%" class="d-flex justify-content-center align-items-center fs-3 mx-5" ><span>Urlop<br>150H</span></div>
                    <div style="min-height: 250px;min-width:250px;border: 20px solid #319330; border-radius:100%" class="d-flex justify-content-center align-items-center fs-3 mx-5" ><span>Urlop<br>150H</span></div>
                </div>
            </div>
        </div>
    </form>
    @endisset
@endsection
