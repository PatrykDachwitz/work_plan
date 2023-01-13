@extends('layouts.app')

@section('content')
    <div class="calendar shadow">
        <div class="calendar-header m-0 p-0 row text-white">
            <div class="group-button-add-holidays">
                <picture>
                    <source>
                    <img>
                </picture>
                <button >Dodaj wolne</button>
            </div>
            <div class="searche-group-date">
                <input type="text" placeholder="Search" aria-label="Search">
                <button >Zapisz</button>
            </div>
            <div class="button-group-filter">
                <button class="button-group-filter-single">Urlop wypoczynkowy</button>
                <button class="button-group-filter-single">Urlop wypoczynkowy</button>
                <button class="button-group-filter-single">Urlop wypoczynkowy</button>
            </div>
        </div>
        <div class="days-body">
            @foreach($days ?? [] as $day)
                <div class="days-body-row">
                    <div class="days-body-head @if($day->relationDay->free_day) bg-warning @else bg-gray @endif ps-1 fs-4 py-2">
                        <span>{{ $day->relationDay->day_name }}</span> <span>{{ $day->relationDay->date }}</span>
                    </div>
                    @foreach($day->relationEvents ?? [] as $event)
                        <div class="days-body-status fs-5 ps-3 py-2">
                            {{ $event->date }} {{ $event->description }}
                        </div>
                    @endforeach

                </div>
            @endforeach
        </div>
    </div>
@endsection
