@extends('admin.index')

@section('title', $promotion->name)

@section('content')

{{-- Message --}}
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">{{ session()->get('message') }}</div>
@endif
{{-- End Message --}}

<p><b>{{ $promotion->name }}</b></p>
<p>{{ $promotion->description }}</p>

<a href="{{ route('admin.promotion.edit', ['id' => $promotion->id]) }}" class="btn btn-dark">Редактировать</a>

@endsection