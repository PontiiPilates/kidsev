@extends('Admin.index')

@section('title', 'Адреса и контакты')

@section('content')

{{-- Message --}}
@if(session()->has('message'))
<div class="alert alert-success" role="alert">{{ session()->get('message') }}</div>
@endif
{{-- End Message --}}

<div class="border rounded p-3 mb-3">
{{-- Timetable --}}
<pre>
{{ $about->description ?? 'Адреса и контакты'}} 
</pre>
{{-- End Timetable --}}
</div>

<a href="{{ route('admin.about.edit') }}" class="btn btn-dark">Редактировать</a>

@endsection