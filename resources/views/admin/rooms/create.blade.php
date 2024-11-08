@extends('layouts.admin.admin')

@section('title', '新しい部屋を追加')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4">新しい部屋を追加 - {{ $workplace->workplace }}</h1>

    <form action="{{ route('admin.rooms.store') }}" method="POST">
        @csrf
        <input type="hidden" name="workplace_id" value="{{ $workplace->id }}">

        <div class="form-group">
            <label for="room_number">部屋番号</label>
            <input type="text" name="room_number" id="room_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="status">状態</label>
            <select name="status" id="status" class="form-control">
                @foreach($statusTypes as $status)
                    <option value="{{ $status->status }}">{{ $status->status }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="notes">備考</label>
            <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">部屋を追加</button>
    </form>
</div>
@endsection
