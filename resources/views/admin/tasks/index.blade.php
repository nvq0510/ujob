@extends('layouts.admin.admin')

@section('title', 'タスクリスト')

@section('content')
<div class="container-fluid px-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">ダッシュボード</a></li>
            <li class="breadcrumb-item active" aria-current="page">タスクリスト</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 mb-0">
            <i class="fas fa-tasks me-2"></i>タスクリスト
        </h1>
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> 新しいタスクを追加
        </a>
    </div>

    <!-- Task Table -->
    <div class="card border-0 shadow mb-4">
        <div class="card-header bg-gradient-primary py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-list me-1"></i>タスク
            </h6>
        </div>

        <div class="card-body">
            <!-- Filter Form -->
            <form action="{{ route('admin.tasks.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <!-- User Filter -->
                    <div class="col-md-3 mb-3">
                        <label for="user_id" class="form-label">ユーザー</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">すべてのユーザー</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Workplace Filter -->
                    <div class="col-md-3 mb-3">
                        <label for="workplace_id" class="form-label">職場</label>
                        <select name="workplace_id" id="workplace_id" class="form-select">
                            <option value="">すべての職場</option>
                            @foreach($workplaces as $workplace)
                                <option value="{{ $workplace->id }}" {{ request('workplace_id') == $workplace->id ? 'selected' : '' }}>
                                    {{ $workplace->workplace }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">ステータス</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">すべてのステータス</option>
                            <option value="未開始" {{ request('status') == '未開始' ? 'selected' : '' }}>未開始</option>
                            <option value="進行中" {{ request('status') == '進行中' ? 'selected' : '' }}>進行中</option>
                            <option value="完了" {{ request('status') == '完了' ? 'selected' : '' }}>完了</option>
                            <option value="キャンセル" {{ request('status') == 'キャンセル' ? 'selected' : '' }}>キャンセル</option>
                        </select>
                    </div>

                    <!-- Filter and Reset Buttons -->
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>検索
                        </button>
                        <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-sync-alt me-1"></i>リセット
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>ユーザー</th>
                            <th>職場</th>
                            <th>作業日</th>
                            <th>シフト</th>
                            <th>ステータス</th>
                            <th>アクション</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->user->name }}</td>
                            <td>{{ $task->workplace->workplace }}</td>
                            <td>{{ \Carbon\Carbon::parse($task->work_date)->format('Y-m-d') }}</td>
                            <td>{{ $task->shift }}</td>
                            <td>
                                <span class="status-badge {{ $user->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                        {{ $user->status == 'active' ? 'アクティブ' : '非アクティブ' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.tasks.show', $task->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> 表示
                                </a>
                                <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('削除しますか？')">
                                        <i class="fas fa-trash-alt"></i> 削除
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $tasks->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
