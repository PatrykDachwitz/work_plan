@extends('layouts.app')

@section('content')
    @isset($day)
    <form class="calendar shadow">
        <div class="calendar-header m-0 p-0 row text-white">
            <div class="group-button-add-holidays">
                <a href="{{ url()->previous() }}">Back</a>
                <span>{{ $day->relationDay->date }}</span>
                <span>{{ $day->relationDay->day_name }}</span>
            </div>

            <div class="button-group-filter">
                <button class="button-group-filter-single">Zapisz</button>
                <button class="button-group-filter-single">Zapisz i wyjdz</button>
                <button class="button-group-filter-single">Zapisz i nowy</button>
            </div>
        </div>
        <div class="status-body">
            <div class="status-body-button d-flex justify-content-center mt-3 mb-4">
                <button class="btn btn-dark status-body-btn">Start pracy</button>
                <button class="btn btn-dark status-body-btn">Początek przerwy</button>
                <button class="btn btn-dark status-body-btn">Koneic przerwy</button>
                <button class="btn btn-dark status-body-btn">Wyjazd służbowy</button>
                <button class="btn btn-dark status-body-btn">Koniec pracy</button>
                <button class="btn btn-dark status-body-btn">Niestandardowe</button>
            </div>
            <div class="d-flex justify-content-center mb-4">
                <label for="description" class="fs-4">Opis
                    <input name="description" class="border border-2 border-dark rounded ps-2" placeholder="Opis" />
                </label>
            </div>
            <div class="status-body-status">
                <div class="days-body-status bg-dark fs-4 text-white ps-3 py-2">
                    Zdarzenia w ciągu dnia
                </div>
                @foreach($day->relationEvents ?? [] as $key => $event)
                    <div class="days-body-status @if($key == 0 | $key % 2 == 0) bg-gray @endif fs-5 ps-3 py-2">
                        {{ $event->date }} {{ $event->description }}
                    </div>
                @endforeach
            </div>
        </div>
    </form>
    @endisset
@endsection
