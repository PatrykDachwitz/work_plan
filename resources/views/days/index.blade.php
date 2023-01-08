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
            <div class="days-body-row">
                <div class="days-body-head bg-warning ps-1 fs-4 py-2">
                    <span>Poniedziałek</span> <span>12.02.2021</span>
                </div>
                <div class="days-body-status fs-5 ps-3 py-2">
                    7:00 - 15:00 Urlop wypoczynkowy
                </div>
            </div>
            <div class="days-body-row">
                <div class="days-body-head bg-secondary text-white ps-1 fs-4 py-2">
                    <span>Poniedziałek</span> <span>12.02.2021</span>
                </div>
                <div class="days-body-status fs-5 ps-3 py-2">
                    <span>7:00</span> Rozpoczecie pracy
                </div>
                <hr class="m-0 p-0">
                <div class="days-body-status fs-5 ps-3 py-2">
                    <span>15:00</span> Zakończenie pracy
                </div>
            </div>
        </div>
    </div>
@endsection
