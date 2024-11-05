@extends('layouts.admin.admin')

@section('title', 'タスクの詳細')

@section('content')
<div class="container-fluid px-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">ダッシュボード</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.tasks.index') }}" class="text-decoration-none">タスク一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">タスクの詳細</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 text-gray-800 mb-0">
            <i class="fas fa-tasks me-2"></i>タスクの詳細 #{{ $task->id }}
        </h1>
        <div>
            <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>編集
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>戻る
            </a>
        </div>
    </div>

    <!-- Notification -->
    @include('components.alert')

    <!-- Task Details Section -->
    <div class="card border-0 shadow-sm rounded mb-4">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="m-0"><i class="fas fa-info-circle me-1"></i>タスク情報</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <p><strong>ID:</strong> {{ $task->id }}</p>
                    <p><strong>ユーザー:</strong> {{ $task->user->name }}</p>
                    <p><strong>職場:</strong> {{ $task->workplace->workplace }}</p>
                    <p><strong>住所:</strong> {{ $task->workplace->address }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>作業日:</strong> {{ $task->work_date->format('Y-m-d') }}</p>
                    <p><strong>シフト:</strong> {{ $task->shift ?? '未設定' }}</p>
                    <p><strong>開始時間:</strong> {{ $task->start_time ?? '未設定' }}</p>
                    <p><strong>終了時間:</strong> {{ $task->end_time ?? '未設定' }}</p>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <p>
                        <strong>状態:</strong>
                        <span class="task-status status-{{ strtolower($task->status) }}">
                            {{ $task->status }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>説明:</strong> {{ $task->description ?? '説明なし' }}</p>
                    <p><strong>メモ:</strong> {{ $task->notes ?? 'メモなし' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Images Section -->
    <div class="card border-0 shadow-sm rounded mb-4">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="m-0"><i class="fas fa-images me-1"></i>タスクの画像</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse ($images as $image)
                    <div class="col-6 col-md-3 col-lg-2 mb-3">
                        <div class="card shadow-sm border-0">
                            <a href="{{ asset($image->path) }}" target="_blank">
                                <img src="{{ asset($image->path) }}" class="card-img-top rounded" alt="Task Image" style="height: 100px; object-fit: cover;">
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">画像は見つかりませんでした。</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
