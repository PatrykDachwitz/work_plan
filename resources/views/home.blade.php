@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center">
        <div class="profil">
            <div class="profil-container-image">
                <img src="https://avatars.githubusercontent.com/u/98681?v=4" class="rounded-circle border border-dark border-2 shadow mb-4" width="350" height="350"/>
            </div>
            <div class="d-flex flex-column">
                <input type="hidden" name="user_id" value="{{ $profil->id }}"/>
                <input type="hidden" name="time" value="{{ date('H:i') }}"/>
                <input type="hidden" name="date" value="{{ $dayActualy->date ?? null }}"/>
                <input type="hidden" name="status_id" value="{{ $status->id ?? null }}"/>
                <button class="btn btn-primary fs-4 btn-register-day" >Dziueń wolny</button>
                <button class="btn btn-success my-2 fs-4 btn-register-day" data-type="startWork" data-description="startWork" >Wejście</button>
                <button class="btn btn-danger fs-4 btn-register-day" data-type="exitWork" data-description="exitWork">Wyjście</button>
            </div>
        </div>
    </div>
@endsection
