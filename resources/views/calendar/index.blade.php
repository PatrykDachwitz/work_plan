@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-center calendar">
        <div class="rounded calendar-body my-3 m-md-0 shadow-lg d-flex flex-column">
            <nav class="bg-dark d-flex align-items-center justify-content-between px-2">
                <div class="profil-group-input text-white fs-4 p-2">
                    <a href="{{ url()->previous() }}" title="@lang('profil.previous_page')" class="link-nodecoration">
                        <picture>
                            <source srcset="{{ asset('/icons/previous.webp') }}" type="image/webp">
                            <img src="{{ asset('/icons/previous.png') }}" loading="lazy" width="25" height="25" alt="@lang('profil.previous_page')" title="@lang('profil.previous_page')">
                        </picture>
                    </a>
                    <span class="ms-2"></span>
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
            <div class="row p-5 g-3 m-0 d-flex justify-content-evenly align-items-">
                @foreach($days ?? [] as $day)
                    <div class="col-6 col-md-2 rounded-2 d-flex bg-gray shadow flex-nowrap m-0 p-0 overflow-hidden justify-content-between g-1">
                        <div class="bg-dark text-white fs-5 py-2 px-3 d-flex justify-content-center align-items-center">
                            <span class="text-center">
                                2<br />sty
                            </span>
                        </div>
                        <div class="d-flex flex-column justify-content-center ps-3">
                            <span class="fs-5">
                                {{ $day->day_name }}
                            </span>
                            @if(!$day->free_day)
                                @isset($day->relationStatus[0])
                                    @if($day->relationStatus[0]->status === "workDay")
                                        <span class="fs-5">
                                            {{ $day->relationStatus[0]->hour_start ?? __('global.none') }} - {{ $day->relationStatus[0]->hour_end ?? __('global.none') }}
                                        </span>
                                    @else
                                        <span class="fs-5">
                                            {{ __("global.{$day->relationStatus[0]->status}") }}
                                        </span>
                                    @endif
                                @else
                                    <span class="fs-5">
                                        @lang('global.none') - @lang('global.none')
                                    </span>
                                @endisset
                            @endif

                        </div>
                        <div class="bg-dark text-white fs-5 py-2 px-3 d-flex justify-content-center align-items-center">
                            <span class="text-center">
                                2<br />sty
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
