@extends('layouts.admin.admin')

@section('title', 'ユーザー詳細')

@section('content')


<div class="container-fluid px-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">ダッシュボード</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">ユーザー一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザー詳細 #{{ $user->id }}</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 mb-0">
            <i class="fas fa-user-circle me-2"></i>{{ $user->name }}さんの詳細
        </h1>
        <div class="d-flex gap-">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning text-dark mx-1">
                <i class="fas fa-edit me-1"></i>編集
            </a>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" 
                  onsubmit="return confirm('このユーザーを削除してもよろしいですか？\nこの操作は取り消せません。')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mx-1">
                    <i class="fas fa-trash-alt me-1"></i>削除
                </button>
            </form>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mx-1">
                <i class="fas fa-arrow-left me-1"></i>戻る
            </a>
        </div>
    </div>

    <div class="row">
        <!-- User Information Card -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header bg-gradient-primary py-3 d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-info-circle me-1"></i>基本情報
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-light p-4 mx-auto mb-3" style="width: 100px; height: 100px;">
                            <i class="fas fa-user fa-3x text-primary"></i>
                        </div>
                        <h5 class="mb-0">{{ $user->name }}</h5>
                        <p class="text-muted">{{ $user->email }}</p>
                        <span class="status-badge {{ $user->status == 'active' ? 'status-active' : 'status-inactive' }}">
                            {{ $user->status == 'active' ? 'アクティブ' : '非アクティブ' }}
                        </span>
                    </div>
                    
                    <div class="border-top pt-3">
                        <div class="row mb-2">
                            <div class="col-5 text-muted">役割</div>
                            <div class="col-7 fw-medium">{{ $user->role == 'admin' ? '管理者' : 'ユーザー' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">電話番号</div>
                            <div class="col-7">{{ $user->phone ?? '未設定' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">住所</div>
                            <div class="col-7">{{ $user->address ?? '未設定' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">作成日</div>
                            <div class="col-7">{{ $user->created_at->format('Y年m月d日') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5 text-muted">更新日</div>
                            <div class="col-7">{{ $user->updated_at->format('Y年m月d日') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Card -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header bg-gradient-primary py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-tasks me-1"></i>分担タスク一覧
                    </h6>
                    <a href="{{ route('admin.tasks.create', ['user_id' => $user->id]) }}" 
                        class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i>新規タスク
                    </a>
                </div>
                <div class="card-body">
                    @if($tasks->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted mb-0">現在、割り当てられているタスクはありません。</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="text-nowrap">#</th>
                                        <th scope="col" class="text-nowrap">作業日</th>
                                        <th scope="col" class="text-nowrap">シフト</th>
                                        <th scope="col" class="text-nowrap">職場</th>
                                        <th scope="col" class="text-nowrap">ステータス</th>
                                        <th scope="col" class="text-nowrap">アクション</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($task->work_date)->format('Y-m-d') }}</td>
                                            <td>{{ $task->shift }}</td>
                                            <td>{{ $task->workplace->workplace }}</td>
                                            <td>
                                                <span class="task-status status-{{ strtolower($task->status) }}">
                                                    {{ $task->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.tasks.show', $task->id) }}" 
                                                class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $tasks->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
