@extends('Admin.index')

@section('title', 'Редактирование программы')

@section('content')

{{-- Message --}}
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">{{ session()->get('message') }}</div>
@endif
{{-- End Message --}}

    {{-- Form --}}
    <form class="row g-3" method="POST" action="{{ route('admin.about.edit') }}">

        @csrf

        {{-- Description --}}
        <div class="col-12">
            <textarea class="form-control" id="description" placeholder="Адреса и контакты" name="description">{{ $about->description ?? '' }}</textarea>
        </div>
        {{-- End Description --}}

        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-dark">Сохранить</button>
        </div>

    </form>
    {{-- End Form --}}

@endsection