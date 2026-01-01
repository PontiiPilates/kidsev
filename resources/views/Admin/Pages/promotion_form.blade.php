@extends('Admin.index')

@if ( url()->current() == route('admin.promotion.create') )
    @section('title', 'Добавление акции')
@else
    @section('title', 'Редактирование акции')
@endif

@section('content')

{{-- Message --}}
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">{{ session()->get('message') }}</div>
@endif
{{-- End Message --}}

{{-- Form --}}
@if ( url()->current() == route('admin.promotion.create') )
    <form class="row g-3" method="POST" action="{{ route('admin.promotion.create') }}">
@else
    <form class="row g-3" method="POST" action="{{ route('admin.promotion.edit', ['id' => $id]) }}">
@endif

        @csrf

        {{-- Promotion name --}}
        <div class="col-12">
            <input type="text" class="form-control" id="name" placeholder="Название акции" name="name" value="{{ $promotion->name ?? '' }}">
        </div>
        {{-- End Promotion name --}}

        {{-- Description --}}
        <div class="col-12">
            <textarea class="form-control" id="description" placeholder="Описание акции" name="description">{{ $promotion->description ?? '' }}</textarea>
        </div>
        {{-- End Description --}}

        {{-- Status --}}
        <div class="col-12">
            <div class="form-check">
                @if ( url()->current() == route('admin.promotion.create') )
                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                @else
                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1" @if( $promotion->status == 1 ) checked @endif>
                @endif
                <label class="form-check-label" for="status">Опубликовать / снять с публикации</label>
            </div>
        </div>
        {{-- End Status --}}

        <div class="col-12 mt-4">
            @if ( url()->current() == route('admin.promotion.create') )
                <button type="submit" class="btn btn-dark">Сохранить</button>
            @else
                <button type="submit" class="btn btn-dark">Сохранить</button>
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#shureModal">Удалить</button>
            @endif
        </div>

    </form>
    {{-- End Form --}}

    {{-- Modal --}}
    @if ( url()->current() != route('admin.promotion.create') )
    <div class="modal fade" id="shureModal" tabindex="-1" aria-labelledby="shureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shureModalLabel">Удаление акции</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">Вы удаляете акцию. Продолжить?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Закрыть</button>
                    <form method="POST" action="{{ route('admin.promotion.destroy', ['id' => $id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-dark">Да</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- End Modal --}}

@endsection