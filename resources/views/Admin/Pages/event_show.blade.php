@extends('Admin.index')

@section('title', $event->name)

@section('content')

{{-- Message --}}
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">{{ session()->get('message') }}</div>
@endif
{{-- End Message --}}

<p><b>{{ $event->name }}</b></p>
<p>{{ $event->description }}</p>

@foreach ($timetable as $item)

    @php
        $months = [
            '01' => 'января',
            '02' => 'февраля',
            '03' => 'марта',
            '04' => 'апреля',
            '05' => 'мая',
            '06' => 'июня',
            '07' => 'июля',
            '08' => 'августа',
            '09' => 'сентября',
            '10' => 'октября',
            '11' => 'ноября',
            '12' => 'декабря',
        ];
        $date = explode('-', $item->date);
        $date = $date[2] . ' ' . $months[$date[1]];
    @endphp

    <p>{{ $date }} - {{ Str::limit($item->time, 5, false) }}</p>
@endforeach

<p><i>{{ $event->price }}</i></p>

<a href="{{ route('admin.event.edit', ['id' => $event->id]) }}" class="btn btn-dark">Редактировать</a>

@endsection