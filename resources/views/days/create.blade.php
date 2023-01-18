@extends('layouts.app')

@section('content')
    <div class="holidays">
        <div class="holidays-form shadow-sm">
            <div class="holidays-header fs-4 text-start ps-3 py-2">
                Add free day
            </div>
            <div class="holidays-body b-gray-light">
                <form class="d-flex flex-column my-3 mx-4" action="{{ route('day.store') }}" method="post">
                    @csrf
                    <input type="hidden"  name="user_id" value="1">
                    <label for="day_start" class="fs-5 my-1">Start
                        <input type="text" name="day_start" placeholder="12-12-2022" value="{{ old('day_start', "") }}">
                    </label>
                    <label for="day_end" class="fs-5 my-1">End
                        <input name="day_end" type="text" placeholder="12-12-2022" value="{{ old('day_end', "") }}">
                    </label>
                    <label for="status" class="fs-5 mt-1 mb-3">Type
                        <select name="status">
                            <option value="holidayLeave" selected>Holiday leave</option>
                            <option value="leaveOnRequest">Leave on request</option>
                            <option value="occasionalHolidays">Occasional holidays</option>
                            <option value="delegation">Delegation</option>
                        </select>
                    </label>
                    <input value="save" type="submit" class="btn btn-dark fs-5"/>
                </form>
            </div>
        </div>
    </div>

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
