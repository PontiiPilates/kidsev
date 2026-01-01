@extends('Admin.index')

@if ( url()->current() == route('admin.event.create') )
@section('title', 'Добавление мероприятия')
@else
@section('title', 'Редактирование мероприятия')
@endif

@section('content')

{{-- Message --}}
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">{{ session()->get('message') }}</div>
@endif
{{-- End Message --}}

{{-- Form --}}
@if ( url()->current() == route('admin.event.create') )
    <form class="row g-3" method="POST" action="{{ route('admin.event.create') }}">
@else
    <form class="row g-3" method="POST" action="{{ route('admin.event.edit', ['id' => $id]) }}">
@endif

        @csrf

        {{-- Event name --}}
        <div class="col-12">
            <input type="text" class="form-control" id="name" placeholder="Название мероприятия" name="name" value="{{ $event->name ?? '' }}">
        </div>
        {{-- End Event name --}}

        {{-- Description --}}
        <div class="col-12">
            <textarea class="form-control" id="description" placeholder="Описание мероприятия" name="description">{{ $event->description ?? '' }}</textarea>
        </div>
        {{-- End Description --}}

        {{-- Price description --}}
        <div class="col-12">
            <textarea class="form-control" id="price" placeholder="Стоимость посещения - 800 руб." name="price">{{ $event->price ?? '' }}</textarea>
        </div>
        {{-- End Price description --}}


        {{-- Date & time --}}
        <div class="col-12 timetable">
            @if( isset($timetable) )
                @foreach ($timetable as $item)
                    <div class="row row-timetable-container mb-3">
                        <div class="col-6">
                            <input type="date" class="form-control" id="date" name="date[]" value="{{ $item->date ?? date('Y-m-d') }}">
                        </div>
                        <div class="col-6">
                            <input type="time" class="form-control" id="time" name="time[]" value="{{ Str::limit($item->time, 5, false) }}">
                        </div>
                        <button type="button" class="btn btn-link remove"><i class="bi bi-x-circle"></i></button>
                    </div>
                @endforeach
            @else
                <div class="row row-timetable-container mb-3">
                    <div class="col-6">
                        <input type="date" class="form-control" id="date" name="date[]" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-6">
                        <input type="time" class="form-control" id="time" name="time[]">
                    </div>
                    <button type="button" class="btn btn-link remove"><i class="bi bi-x-circle"></i></button>
                </div>
            @endif
        </div>
        {{-- End Date & time --}}

        {{-- Add timetable button --}}
        <div class="col-12 mt-0">
            <button type="button" class="btn btn-link add text-start p-0">Добавить расписание</button>
        </div>
        {{-- End Add timetable button --}}

        {{-- Status --}}
        <div class="col-12">
            <div class="form-check">
                @if ( url()->current() == route('admin.event.create') )
                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                @else
                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" @if( $event->status == 1 ) checked @endif>
                @endif
                <label class="form-check-label" for="status">Опубликовать / снять с публикации</label>
            </div>
        </div>
        {{-- End Status --}}

        <div class="col-12 mt-4">
            @if ( url()->current() == route('admin.event.create') )
                <button type="submit" class="btn btn-dark">Сохранить</button>
            @else
                <button type="submit" class="btn btn-dark">Сохранить</button>
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#shureModal">Удалить</button>
            @endif
        </div>

    </form>
    {{-- End Form --}}

    {{-- Modal --}}
    @if ( url()->current() != route('admin.event.create') )
    <div class="modal fade" id="shureModal" tabindex="-1" aria-labelledby="shureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shureModalLabel">Удаление мероприятия</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">Вы удаляете мероприятие. Продолжить?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Закрыть</button>
                    <form method="POST" action="{{ route('admin.event.destroy', ['id' => $id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-dark">Да</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- End Modal --}}



{{-- Styles --}}
<style>
    .row-timetable-container {
        position: relative;
    }

    .remove {
        position: absolute;
        bottom: 0;
        right: -38px;
        width: 38px;
    }
</style>
{{-- End Styles --}}

{{-- Add / delete timetable --}}
<script>
    $(document).ready(function () {
        
        $('html').on('click','.add',function () {
            let fields = '<div class="row row-timetable-container mb-3"><div class="col-6"><input type="date" class="form-control" id="date" name="date[]" value="{{ date("Y-m-d") }}"></div><div class="col-6"><input type="time" class="form-control" id="time" name="time[]"></div><button type="button" class="btn btn-link remove"><i class="bi bi-x-circle"></i></button></div>';
            $(fields).fadeIn('slow').appendTo('.timetable');
        });
        
        $('html').on('click','.remove', function () {
            $(this).parent().fadeOut('slow').remove();
        });
        
    });
</script>
{{-- End Add / delete timetable --}}

@endsection