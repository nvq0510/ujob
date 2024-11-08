@extends('layouts.admin.admin')

@section('title', '職場の詳細')

@section('content')
<div class="container-fluid px-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">ダッシュボード</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.workplaces.index') }}" class="text-decoration-none">職場一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">職場の詳細</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 text-gray-800 mb-0">
            <i class="fas fa-building me-2"></i>職場の詳細: {{ $workplace->workplace }}
        </h1>
        <div>
            <a href="{{ route('admin.workplaces.edit', $workplace->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i> 編集
            </a>
            <a href="{{ route('admin.workplaces.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> 戻る
            </a>
        </div>
    </div>

    <!-- Notification -->
    @include('components.alert')

    <!-- Workplace Details Section -->
    <div class="card border-0 shadow-sm rounded mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="m-0"><i class="fas fa-info-circle me-1"></i>職場情報</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <p><strong>郵便番号:</strong> {{ $workplace->zipcode }}</p>
                    <p><strong>住所:</strong> {{ $workplace->address }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>リネン:</strong> {{ $workplace->linen ?? 'N/A' }}</p>
                    <p><strong>最寄りランドリー距離:</strong> {{ $workplace->laundry_distance ?? 'N/A' }} km</p>
                    <p><strong>総部屋数:</strong> {{ $workplace->rooms->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Room List Section -->
    <div class="card border-0 shadow-sm rounded mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="m-0"><i class="fas fa-door-open me-1"></i>部屋一覧</h5>
            <a href="{{ route('admin.rooms.create', ['workplace' => $workplace->id]) }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> 新しい部屋を追加
            </a>
        </div>
        <div class="card-body">
            @if($workplace->rooms->isEmpty())
                <p class="text-muted">この職場には部屋が登録されていません。</p>
            @else
                <div class="row">
                    @foreach($workplace->rooms as $room)
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">部屋番号: {{ $room->room_number }}</h5>
                                    <p><strong>状態:</strong>
                                        <span class="badge bg-{{ strtolower($room->status) }} status-{{ strtolower($room->status) }}">
                                            {{ $room->status }}
                                        </span>
                                    </p>
                                    <p><strong>備考:</strong> {{ $room->notes ?? 'なし' }}</p>

                                    <!-- State History -->
                                    <h6 class="mt-3">状態の履歴:</h6>
                                    <div class="accordion" id="roomStatusHistory{{ $room->id }}">
                                        @foreach($room->statuses as $status)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                                                        <span class="badge bg-{{ strtolower($status->status) }} status-{{ strtolower($status->status) }} me-2">
                                                            {{ $status->status }}
                                                        </span> - {{ $status->updated_at->format('Y-m-d H:i') }}
                                                    </button>
                                                </h2>
                                                <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#roomStatusHistory{{ $room->id }}">
                                                    <div class="accordion-body">
                                                        <strong>備考:</strong> {{ $status->notes ?? 'なし' }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-auto d-flex justify-content-between">
                                        <a href="{{ route('admin.rooms.show', $room->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> 詳細
                                        </a>
                                        <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> 編集
                                        </a>
                                        <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm confirmable-action">
                                                <i class="fas fa-trash-alt"></i> 削除
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.confirmable-action').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');

                Swal.fire({
                    title: '本当にこの操作を実行しますか？',
                    text: 'この操作は元に戻せません。',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'はい、削除します',
                    cancelButtonText: 'キャンセル'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection