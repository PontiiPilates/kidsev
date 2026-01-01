@extends('Admin.index')

@section('title', 'Акции')

@section('content')

{{-- Message --}}
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">{{ session()->get('message') }}</div>
@endif
{{-- End Message --}}

<div class="d-flex gap-3">

    {{-- Add promotion --}}
    <div class="card text-bg-light text-center interaction-shadow mb-4 col">
        <div class="card-body"><i class="bi bi-plus-circle me-3"></i>Добавить акцию</div>
        <a href="{{ route('admin.promotion.create') }}" class="stretched-link"></a>
    </div>
    {{-- End Add promotion --}}

    {{-- Show promotions --}}
    <div class="card text-bg-light text-center interaction-shadow mb-4 col">
        <div class="card-body"><i class="bi bi-eye me-3"></i>Просмотр акций</div>
        <a href="{{ route('admin.promotions.show') }}" class="stretched-link"></a>
    </div>
    {{-- End Show promotions --}}

</div>

{{-- List promotions --}}
@foreach($promotions as $promotion)
<div class="card interaction-shadow mb-2">
    <div class="card-body @if( $promotion->status == 0 ) bg-secondary text-white rounded @endif">{{ $promotion->name }}</div>
    <a href="{{ route('admin.promotion.show', ['id' => $promotion->id]) }}" class="stretched-link"></a>
</div>
@endforeach
{{-- End List promotions --}}

@endsection