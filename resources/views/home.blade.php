@extends('layouts.app')

@section('content')
    <div class="calendar shadow">
        <div class="calendar-header m-0 p-0 row text-white">
            <div class="group-button-add-holidays">
                <a href="{{ url()->previous() }}">Back</a>
            </div>

            <div class="button-group-filter">
                <button class="button-group-filter-single">Zapisz</button>
                <button class="button-group-filter-single">Zapisz i wyjdz</button>
                <button class="button-group-filter-single">Zapisz i nowy</button>
            </div>
        </div>
        <div class="calendar-body">
            <div class="calendar-body-row m-0 p-0 row">
                @foreach ($days ?? [] as $day)
                    <a href="{{ route('day.show', [
                    'day' => $day->id
                    ]) }}" class="calendar-body-column day-body col-2 border border-1 shadow-sm @if($day->free_day) bg-warning @endif">
                        <div>
                            <span class="fs-5">{{ $day->day_name }}</span>
                            <span class="fs-6">{{ $day->date }}</span>
                        </div>
                        <span class="fs-4">Urlop wypoczynkowy</span>
                        <span class="pb-2 fs-6">7:12 - 15:00</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
