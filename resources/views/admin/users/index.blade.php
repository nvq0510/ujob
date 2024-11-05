@extends('layouts.admin.admin')

@section('title', 'ユーザー一覧')

@section('content')


<div class="container-fluid px-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">ダッシュボード</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザー一覧</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 mb-0">
            <i class="fas fa-users me-2"></i>ユーザー一覧
        </h1>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary" id="viewToggle">
                <i class="fas fa-table me-1"></i>表示切替
            </button>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-1"></i>新しいユーザーを追加
            </a>
        </div>
    </div>

    <!-- Notification -->
    @include('components.alert')

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label"><i class="fas fa-user"></i> ユーザー名</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="ユーザー名" value="{{ request('name') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label"><i class="fas fa-user-check"></i> ステータス</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">ステータスを選択</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>アクティブ</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>非アクティブ</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i>検索
                        </button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-sync-alt me-1"></i>リセット
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Grid View -->
    <div id="gridView">
        <div class="row">
            @foreach ($users as $user)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 user-card">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="avatar-circle mb-3">
                                <span class="avatar-initials">{{ substr($user->name, 0, 2) }}</span>
                            </div>
                            <h5 class="card-title mb-1">{{ $user->name }}</h5>
                            <p class="text-muted small mb-2">{{ $user->email }}</p>
                            <span class="status-badge {{ $user->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                {{ $user->status == 'active' ? 'アクティブ' : '非アクティブ' }}
                            </span>
                        </div>
                        
                        <div class="user-info mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-user-tag text-primary me-2"></i>
                                <span>{{ $user->role == 'admin' ? '管理者' : 'ユーザー' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <span>ID: {{ $user->id }}</span>
                            </div>
                        </div>

                        <div class="action-buttons text-center">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('このユーザーを削除してもよろしいですか？')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- List View (Hidden by default) -->
    <div id="listView" style="display: none;">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>メールアドレス</th>
                                <th>役割</th>
                                <th>ステータス</th>
                                <th>アクション</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role == 'admin' ? '管理者' : 'ユーザー' }}</td>
                                <td>
                                    <span class="status-badge {{ $user->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                        {{ $user->status == 'active' ? 'アクティブ' : '非アクティブ' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('このユーザーを削除してもよろしいですか？')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links('pagination::bootstrap-4') }}
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#viewToggle').on('click', function() {
            const $gridView = $('#gridView');
            const $listView = $('#listView');
            const $icon = $(this).find('i');

            if ($gridView.is(':visible')) {
                $gridView.addClass('hide').fadeOut(300, function() {
                    $listView.removeClass('hide').addClass('show').fadeIn(300);
                });
                $icon.removeClass('fa-table').addClass('fa-th');
            } else {
                $listView.addClass('hide').fadeOut(300, function() {
                    $gridView.removeClass('hide').addClass('show').fadeIn(300);
                });
                $icon.removeClass('fa-th').addClass('fa-table');
            }
        });
    });
</script>

@endsection


