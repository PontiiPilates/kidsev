@extends('Admin.index')

@if ( url()->current() == route('admin.program.create') )
@section('title', 'Добавление программы')
@else
@section('title', 'Редактирование программы')
@endif

@section('content')

{{-- Message --}}
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">{{ session()->get('message') }}</div>
@endif
{{-- End Message --}}

{{-- Form --}}
@if ( url()->current() == route('admin.program.create') )
    <form class="row g-3" method="POST" action="{{ route('admin.program.create') }}">
@else
    <form class="row g-3" method="POST" action="{{ route('admin.program.edit', ['id' => $id]) }}">
@endif

        @csrf

        {{-- Program name --}}
        <div class="col-12">
            <input type="text" class="form-control" id="name" placeholder="Название программы" name="name" value="{{ $program->name ?? '' }}">
        </div>
        {{-- End Program name --}}

        {{-- Description --}}
        <div class="col-12">
            <textarea class="form-control" id="description" placeholder="Описание программы" name="description">{{ $program->description ?? '' }}</textarea>
        </div>
        {{-- End Description --}}

        {{-- Price description --}}
        <div class="col-12">
            <textarea class="form-control" id="price" placeholder="Абонемент 8 занятий - 3 600 руб." name="price">{{ $program->price ?? '' }}</textarea>
        </div>
        {{-- End Price description --}}


        {{-- Date & time --}}
        <div class="col-12 timetable">
            @if( isset($timetable) )
                @foreach ($timetable as $item)
                    <div class="row row-timetable-container mb-3">
                        <div class="col-6">
                            <select type="day" class="form-select" id="day" name="day[]">
                                <option value="Пн" @if($item->day == 'Пн') selected @endif>Пн</option>
                                <option value="Вт" @if($item->day == 'Вт') selected @endif>Вт</option>
                                <option value="Ср" @if($item->day == 'Ср') selected @endif>Ср</option>
                                <option value="Чт" @if($item->day == 'Чт') selected @endif>Чт</option>
                                <option value="Пт" @if($item->day == 'Пт') selected @endif>Пт</option>
                                <option value="Сб" @if($item->day == 'Сб') selected @endif>Сб</option>
                                <option value="Вс" @if($item->day == 'Вс') selected @endif>Вс</option>
                            </select>
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
                        <select type="day" class="form-select" id="day" name="day[]">
                            <option value="Пн" selected>Пн</option>
                            <option value="Вт">Вт</option>
                            <option value="Ср">Ср</option>
                            <option value="Чт">Чт</option>
                            <option value="Пт">Пт</option>
                            <option value="Сб">Сб</option>
                            <option value="Вс">Вс</option>
                        </select>
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
                @if ( url()->current() == route('admin.program.create') )
                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                @else
                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" @if( $program->status == 1 ) checked @endif>
                @endif
                <label class="form-check-label" for="status">Опубликовать / снять с публикации</label>
            </div>
        </div>
        {{-- End Status --}}

        <div class="col-12 mt-4">
            @if ( url()->current() == route('admin.program.create') )
                <button type="submit" class="btn btn-dark">Сохранить</button>
            @else
                <button type="submit" class="btn btn-dark">Сохранить</button>
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#shureModal">Удалить</button>
            @endif
        </div>

    </form>
    {{-- End Form --}}

    {{-- Modal --}}
    @if ( url()->current() != route('admin.program.create') )
    <div class="modal fade" id="shureModal" tabindex="-1" aria-labelledby="shureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shureModalLabel">Удаление программы</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">Вы удаляете программу. Продолжить?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Закрыть</button>
                    <form method="POST" action="{{ route('admin.program.destroy', ['id' => $id]) }}">
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
            let fields = '<div class="row row-timetable-container mb-3"><div class="col-6"><select type="day" class="form-select" id="day" name="day[]"><option value="Пн" selected>Пн</option><option value="Вт">Вт</option><option value="Ср">Ср</option><option value="Чт">Чт</option><option value="Пт">Пт</option><option value="Сб">Сб</option><option value="Вс">Вс</option></select></div><div class="col-6"><input type="time" class="form-control" id="time" name="time[]"></div><button type="button" class="btn btn-link remove"><i class="bi bi-x-circle"></i></button></div>';
            $(fields).fadeIn('slow').appendTo('.timetable');
        });
        
        $('html').on('click','.remove', function () {
            $(this).parent().fadeOut('slow').remove();
        });
        
    });
</script>
{{-- End Add / delete timetable --}}

@endsection