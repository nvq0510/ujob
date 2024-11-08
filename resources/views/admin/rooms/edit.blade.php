@extends('layouts.admin.admin')

@section('title', '部屋の編集')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4">部屋の編集 - {{ $room->workplace->workplace }} / 部屋番号: {{ $room->room_number }}</h1>

    <!-- Notification -->
    @include('components.alert')
    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="room_number">部屋番号</label>
            <input type="text" name="room_number" id="room_number" class="form-control" value="{{ old('room_number', $room->room_number) }}" required>
        </div>

        <div class="form-group">
            <label for="status">状態</label>
            <select name="status" id="status" class="form-control">
                @foreach($statusTypes as $status)
                    <option value="{{ $status->status }}" {{ $room->status == $status->status ? 'selected' : '' }}>
                        {{ $status->status }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="notes">備考</label>
            <textarea name="notes" id="notes" class="form-control" rows="2">{{ old('notes', $room->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">変更を保存</button>
        <a href="{{ route('admin.rooms.show', $room->id) }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection
