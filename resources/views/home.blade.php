@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center">
        <div class="profil">
            <div class="profil-container-image">
                <img src="https://avatars.githubusercontent.com/u/98681?v=4" class="rounded-circle border border-dark border-2 shadow mb-4" width="350" height="350"/>
            </div>
            <div class="d-flex flex-column">
                <button class="btn btn-primary fs-4">Dziueń wolny</button>
                <button class="btn btn-success my-2 fs-4">Wejście</button>
                <button class="btn btn-danger fs-4">Wyjście</button>
            </div>
        </div>
    </div>
@endsection
