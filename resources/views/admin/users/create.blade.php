@extends('layouts.admin.admin')

@section('title', '新しいユーザーを追加')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="h4 text-gray-800"><i class="fas fa-user-plus"></i> 新しいユーザーを追加</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> 戻る
        </a>
    </div>
    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- Create User Form -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">名前</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">電話番号</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                    <label for="address">住所</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                </div>

                <div class="form-group">
                    <label for="role">役割</label>
                    <select name="role" id="role" class="form-control">
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>ユーザー</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>管理者</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">ステータス</label>
                    <select name="status" id="status" class="form-control">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>アクティブ</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>非アクティブ</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">パスワード確認</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> 作成
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection