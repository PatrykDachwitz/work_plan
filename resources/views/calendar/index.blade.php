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

                <div class="profil-group-input text-white fs-4 p-2">
                    <input type="search" class="fs-6 p-2" placeholder="12-12-2022">
                    <button class="btn btn-">
                        <picture>
                            <source srcset="{{ asset('/icons/search.png') }}" type="image/webp">
                            <img src="{{ asset('/icons/search.png') }}" width="25" height="25" title="@lang('global.search_input')">
                        </picture>
                    </button>
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
            <div class="d-flex g-3 row p-5 m-0">
                @foreach($days ?? [] as $day)
                    <div class="col-12 col-sm-6 col-xxl-3">
                          <div class="rounded-2 d-flex bg-gray shadow flex-nowrap m-0 p-0 overflow-hidden justify-content-between">
                            <div class="bg-dark text-white fs-5 py-2 px-3 d-flex justify-content-center align-items-center">
                                <span class="text-center">
                                    {{ $day->day }}<br />{{ $day->month }}
                                </span>
                            </div>
                            <div class="calendar-hour d-flex flex-column justify-content-center ps-5 @if($day->free_day) bg-warning @endif">
                                <span class="fs-5">
                                    {{ $day->day_name }}
                                </span>
                                    @if(!$day->free_day)
                                        @isset($day->relationStatus[0])
                                            @if($day->relationStatus[0]->status === "workDay")
                                                <span>
                                                    {{ $day->relationStatus[0]->hour_start ?? __('global.none') }} - {{ $day->relationStatus[0]->hour_end ?? __('global.none') }}
                                                </span>
                                            @else
                                                <span>
                                                    {{ __("global.{$day->relationStatus[0]->status}") }}
                                                </span>
                                            @endif
                                        @else
                                            <span>
                                                @lang('global.none') - @lang('global.none')
                                            </span>
                                        @endisset
                                    @endif
                            </div>
                            @isset($day->relationStatus[0])
                                @switch($day->relationStatus[0]->accepted)
                                    @case(1)
                                          <div class="text-white bg-success fs-5 py-2 px-3 d-flex justify-content-center align-items-center">
                                              <picture>
                                                  <source srcset="{{ asset('/icons/accepted.webp') }}" type="image/webp">
                                                  <img src="{{ asset('/icons/accepted.png') }}" width="30" height="30" title="@lang('global.accepted_status')">
                                              </picture>
                                          </div>
                                        @break
                                    @case(0)
                                        <div class="text-white bg-warning fs-5 py-2 px-3 d-flex justify-content-center align-items-center">
                                              <picture>
                                                  <source srcset="{{ asset('/icons/clock.webp') }}" type="image/webp">
                                                  <img src="{{ asset('/icons/clock.png') }}" width="30" height="30" title="@lang('global.wait_status')">
                                              </picture>
                                        </div>
                                        @break
                                @endswitch
                            @endif
                          </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
