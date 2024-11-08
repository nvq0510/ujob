@extends('layouts.admin.admin')

@section('title', '職場一覧')

@section('content')
<div class="container-fluid px-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">ダッシュボード</a></li>
            <li class="breadcrumb-item active" aria-current="page">職場一覧</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 mb-0">
            <i class="fas fa-building me-2"></i>職場一覧
        </h1>
        <a href="{{ route('admin.workplaces.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>新しい職場を追加
        </a>
    </div>

    <!-- Notification -->
    @include('components.alert')
    <!-- Workplace Table -->
    <div class="card border-0 shadow mb-4">
        <div class="card-header bg-gradient-primary py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-list me-1"></i>職場リスト
            </h6>
        </div>

        <div class="card-body">
            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.workplaces.index') }}" class="mb-4">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3">
                        <label for="workplace"><i class="fas fa-building"></i> 職場名</label>
                        <input type="text" name="workplace" id="workplace" class="form-control" placeholder="職場名を入力" value="{{ request('workplace') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i>検索
                        </button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('admin.workplaces.index') }}" class="btn btn-secondary w-100">
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
                            <th>職場名</th>
                            <th>郵便番号</th>
                            <th>住所</th>
                            <th>総部屋数</th>
                            <th>リネン</th>
                            <th>最寄りランドリー距離 (km)</th>
                            <th>アクション</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workplaces as $workplace)
                        <tr>
                            <td>{{ $workplace->id }}</td>
                            <td>{{ $workplace->workplace }}</td>
                            <td>{{ $workplace->zipcode }}</td>
                            <td>{{ $workplace->address }}</td>
                            <td>{{ $workplace->total_rooms ?? 'N/A' }}</td>
                            <td>{{ $workplace->linen ?? 'N/A' }}</td>
                            <td>{{ $workplace->nearest_laundromat_distance ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.workplaces.show', $workplace->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> 詳細
                                </a>
                                <form action="{{ route('admin.workplaces.destroy', $workplace->id) }}" method="POST" class="d-inline">
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
                {{ $workplaces->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
