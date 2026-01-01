@extends('Admin.index')

@section('title', 'Расписание программ')

@section('content')

<div class="border rounded p-3 ">
{{-- Timetable --}}
<pre>
{{ $compilation_string }}
</pre>
{{-- End Timetable --}}
</div>

@endsection