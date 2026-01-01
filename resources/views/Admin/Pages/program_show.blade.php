@extends('Admin.index')

@section('title', $program->name)

@section('content')

{{-- Message --}}
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">{{ session()->get('message') }}</div>
@endif
{{-- End Message --}}

<p><b>{{ $program->name }}</b></p>
<p>{{ $program->description }}</p>

@foreach ($timetable as $item)
    <p>{{ $item->day }} - {{ Str::limit($item->time, 5, false) }}</p>
@endforeach

<p><i>{{ $program->price }}</i></p>

<a href="{{ route('admin.program.edit', ['id' => $program->id]) }}" class="btn btn-dark">Редактировать</a>


@endsection