@extends('layouts.admin.admin')

@section('title', '新しいタスクを作成')

@section('content')
<div class="container-fluid px-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">ダッシュボード</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.tasks.index') }}" class="text-decoration-none">タスク一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">新しいタスクを作成</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 mb-0">
            <i class="fas fa-tasks me-2"></i>新しいタスクを作成
        </h1>
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> タスク一覧に戻る
        </a>
    </div>

    <!-- Form for creating a new task -->
    <div class="card border-0 shadow mb-4">
        <div class="card-header bg-gradient-primary py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-info-circle me-1"></i>タスク情報
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tasks.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <!-- User Selection -->
                    <div class="form-group col-md-6">
                        <label for="user_id">ユーザー</label>
                        <div class="input-group">
                            <select class="form-control custom-select" id="user_id" name="user_id" required>
                                <option value="" disabled {{ !request('user_id') ? 'selected' : '' }}>ユーザーを選択</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', request('user_id')) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Workplace Selection -->
                    <div class="form-group col-md-6">
                        <label for="workplace_id">職場</label>
                        <div class="input-group">
                            <select class="form-control custom-select" id="workplace_id" name="workplace_id" required>
                                <option value="" selected disabled>職場を選択</option>
                                @foreach($workplaces as $workplace)
                                    <option value="{{ $workplace->id }}">{{ $workplace->workplace }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Work Date -->
                    <div class="form-group col-md-6">
                        <label for="work_date">作業日</label>
                        <input type="date" class="form-control" id="work_date" name="work_date" required>
                    </div>

                    <!-- Shift -->
                    <div class="form-group col-md-6">
                        <label for="shift">シフト</label>
                        <input type="text" class="form-control" id="shift" name="shift" placeholder="例: 9:30~18:30">
                    </div>
                </div>

                <div class="form-row">
                    <!-- Status -->
                    <div class="form-group col-md-6">
                        <label for="status">ステータス</label>
                        <select class="form-control custom-select" id="status" name="status" required>
                            <option value="未開始" selected>未開始</option>
                            <option value="進行中">進行中</option>
                            <option value="完了">完了</option>
                            <option value="キャンセル">キャンセル</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">説明</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label for="notes">メモ</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> タスクを作成
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
