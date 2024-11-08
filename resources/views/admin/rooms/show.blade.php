@extends('layouts.admin.admin')

@section('title', '部屋の詳細')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 text-gray-800"><i class="fas fa-door-open"></i> 部屋の詳細 - {{ $room->room_number }}</h1>
        <div>
            <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> 編集
            </a>
            <a href="{{ route('admin.workplaces.show', $room->workplace_id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> 戻る
            </a>
        </div>
    </div>

    <!-- Room Details -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-info-circle"></i> 部屋情報</h5>
            <p><strong>職場:</strong> <a href="{{ route('admin.workplaces.show', $room->workplace_id) }}">{{ $room->workplace->workplace }}</a></p>
            <p><strong>部屋番号:</strong> {{ $room->room_number }}</p>
            <p><strong>状態:</strong> 
                <span class="status-badge status-{{ strtolower($room->status) }}">
                    {{ $room->status }}
                </span>
            </p>
            <p><strong>備考:</strong> {{ $room->notes ?? 'なし' }}</p>
        </div>
    </div>

    <!-- Room Status History -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">状態の履歴</h6>
        </div>
        <div class="card-body">
            @if($room->statuses->isEmpty())
                <p class="text-muted">この部屋には状態の履歴がありません。</p>
            @else
                <ul class="list-group">
                    @foreach($room->statuses as $status)
                        <li class="list-group-item">
                            <strong>状態:</strong> 
                            <span class="status-badge status-{{ strtolower($status->status) }}">
                                {{ $status->status }}
                            </span><br>
                            <strong>更新日時:</strong> {{ $status->updated_at->format('Y-m-d H:i') }}<br>
                            <strong>備考:</strong> {{ $status->notes ?? 'なし' }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
