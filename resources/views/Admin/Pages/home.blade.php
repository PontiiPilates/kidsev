@extends('Admin.index')

@section('title', 'Главная')

@section('content')

<div class="container row">

    {{-- User count --}}
    <div class="col-4">
        <div class="border rounded p-3">
            <p>Количество пользователей:</p>
            <p>{{ $data['people_started'] }}</p>
        </div>
    </div>
    {{-- End User count --}}

    {{-- Users reads --}}
    <div class="col-4">
        <div class="border rounded p-3 overflow-auto" style="height: calc( 100vh - (56px + 48px)*2 )">
            <p>Пользователи пишут:</p>
                @foreach ( $data['messages'] as $v)
                <div class="card mb-2">
                    <div class="card-body">
                        <span><b>От:</b> {{ $v['from_id'] }}</span><br>
                        <span><b>Сообщение:</b> {{ $v['text'] }}</span><br>
                        <small class="text-muted">{{ $v['created_at'] }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{-- End Users reads --}}
        
        {{-- Users activity --}}
        <div class="col-4">
            <div class="border rounded p-3 overflow-auto" style="height: calc( 100vh - (56px + 48px)*2 )">
            <p>Активность запросов:</p>
            <ul>
                @foreach ( $data['activity'] as $k => $v)
                <div class="card mb-2">
                    <div class="card-body">
                        <span><b>{{ $k }}</b> {{ $v }}</span>
                    </div>
                </div>
                @endforeach
            </ul>
        </div>
    </div>
    {{-- End Users activity --}}

</div>

@endsection