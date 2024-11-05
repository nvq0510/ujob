@extends('layouts.admin.admin')

@section('title', 'ユーザー編集')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="h4 text-gray-800"><i class="fas fa-edit"></i> ユーザー編集 #{{ $user->id }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> 戻る
        </a>
    </div>

    <!-- Edit User Form -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form id="editUserForm" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">名前</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">電話番号</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="form-group">
                    <label for="address">住所</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}">
                </div>

                <div class="form-group">
                    <label for="role">役割</label>
                    <select name="role" id="role" class="form-control">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>ユーザー</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>管理者</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">ステータス</label>
                    <select name="status" id="status" class="form-control">
                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>アクティブ</option>
                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>非アクティブ</option>
                    </select>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-confirm">
                        <i class="fas fa-save"></i> 変更を保存
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 Script -->
<script>
    $(document).ready(function() {
        $('.btn-confirm').on('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: '変更を保存しますか？',
                text: "この操作は元に戻せません。",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'はい、保存します',
                cancelButtonText: 'キャンセル'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#editUserForm').submit();
                }
            });
        });
    });
</script>
@endsection
