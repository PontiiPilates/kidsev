@extends('Admin.index')

@section('title', 'Мероприятия')

@section('content')

{{-- Message --}}
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">{{ session()->get('message') }}</div>
@endif
{{-- End Message --}}

<div class="d-flex gap-3">

    {{-- Add event --}}
    <div class="card text-bg-light text-center interaction-shadow mb-4 col">
        <div class="card-body"><i class="bi bi-plus-circle me-3"></i>Добавить мероприятие</div>
        <a href="{{ route('admin.event.create') }}" class="stretched-link"></a>
    </div>
    {{-- End Add event --}}

    {{-- Add program --}}
    <div class="card text-bg-light text-center interaction-shadow mb-4 col">
        <div class="card-body"><i class="bi bi-eye me-3"></i>Просмотр расписания</div>
        <a href="{{ route('admin.timetable.events.show') }}" class="stretched-link"></a>
    </div>
    {{-- End Add program --}}

</div>

{{-- List events --}}
@foreach($events as $event)
<div class="card interaction-shadow mb-2">
    <div class="card-body @if( $event->status == 0 ) bg-secondary text-white rounded @endif">{{ $event->name }}</div>
    <a href="{{ route('admin.event.show', ['id' => $event->id]) }}" class="stretched-link"></a>
</div>
@endforeach
{{-- End List events --}}

@endsection