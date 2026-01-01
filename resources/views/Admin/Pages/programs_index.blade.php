@extends('Admin.index')

@section('title', 'Программы')

@section('content')

{{-- Message --}}
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">{{ session()->get('message') }}</div>
@endif
{{-- End Message --}}

<div class="d-flex gap-3">

    {{-- Add program --}}
    <div class="card text-bg-light text-center interaction-shadow mb-4 col">
        <div class="card-body"><i class="bi bi-plus-circle me-3"></i>Добавить программу</div>
        <a href="{{ route('admin.program.create') }}" class="stretched-link"></a>
    </div>
    {{-- End Add program --}}

    {{-- Add program --}}
    <div class="card text-bg-light text-center interaction-shadow mb-4 col">
        <div class="card-body"><i class="bi bi-eye me-3"></i>Просмотр расписания</div>
        <a href="{{ route('admin.timetable.programs.show') }}" class="stretched-link"></a>
    </div>
    {{-- End Add program --}}

</div>

{{-- List programs --}}
@foreach($programs as $program)
<div class="card interaction-shadow mb-2">
    <div class="card-body @if( $program->status == 0 ) bg-secondary text-white rounded @endif">{{ $program->name }}</div>
    <a href="{{ route('admin.program.show', ['id' => $program->id]) }}" class="stretched-link"></a>
</div>
@endforeach
{{-- End List programs --}}

@endsection