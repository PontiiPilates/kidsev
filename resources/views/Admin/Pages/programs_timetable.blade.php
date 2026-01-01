@extends('Admin.index')

@section('title', 'Расписание программ')

@section('content')

<div class="row gap-3">
    <div class="border rounded p-3 col">
        {{-- Timetable --}}
        <pre class="m-0">{!! $compilation_string !!}</pre>
        {{-- End Timetable --}}
    </div>

    <div class="border rounded p-3 col">
        {{-- Timetable --}}
        <pre class="m-0">{!! $compilation_programs !!}</pre>
        {{-- End Timetable --}}
    </div>
</div>

@endsection