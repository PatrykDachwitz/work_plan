@extends('layouts.app')

@section('content')
    <div class="employee shadow">
        <div class="employee-header m-0 p-0 row text-white">
            Zespół
        </div>
        <div class="employee-body">
            <div class="m-0 p-0 row">
                @foreach ($users ?? [] as $user)
                    <div class="employee-body-card d-flex flex-column p-4 justify-content-between col-6 col-lg-4 col-xxl-2 shadow-sm text-center fs-6">
                        <picture>
                            <img src="https://avatars.githubusercontent.com/u/98681?v=4" class="rounded-circle border border-2 border-dark" width="150" height="150">
                        </picture>
                        <div class="fs-4">
                            <span>{{ $user->first_name }}</span>
                            <span>{{ $user->last_name }}</span>
                        </div>
                        <a class="text-dark" href="mailto: {{ $user->email_company }}">Mail: {{ $user->email_company }}</a>
                        <a class="text-dark" href="tel: {{ $user->number_phone }}">Tel: {{ $user->number_phone }}</a>
                        @if($superAdmin & $user->id !== $profil->id)
                            <a class="btn btn-dark fs-6" href="{{ route('user.edit', ['id' => $user->id]) }}">Edytuj</a>
                        @elseif($user->id === $profil->id)
                            <a class="btn btn-dark fs-6" href="{{ route('user.show') }}">Edytuj</a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
