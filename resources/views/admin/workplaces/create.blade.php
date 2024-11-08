@extends('layouts.admin.admin')

@section('title', '新しい職場を作成')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">新しい職場を作成</h1>
        <a href="{{ route('admin.workplaces.index') }}" class="btn btn-secondary">職場一覧に戻る</a>
    </div>
    
    @include('components.alert')
    <!-- Form for creating a new workplace -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">職場情報</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.workplaces.store') }}" method="POST">
                @csrf

                <!-- Workplace Name -->
                <div class="form-group">
                    <label for="workplace">職場名</label>
                    <input type="text" name="workplace" id="workplace" class="form-control" required>
                </div>

                <!-- Zip Code -->
                <div class="form-group">
                    <label for="zipcode">郵便番号</label>
                    <input type="text" name="zipcode" id="zipcode" class="form-control" required>
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="address">住所</label>
                    <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                </div>

                <!-- Total Rooms -->
                <div class="form-group">
                    <label for="total_rooms">総部屋数</label>
                    <input type="number" name="total_rooms" id="total_rooms" class="form-control" min="0">
                </div>

                <!-- Linen -->
                <div class="form-group">
                    <label for="linen">リネン</label>
                    <input type="text" name="linen" id="linen" class="form-control">
                </div>

                <!-- Nearest Laundromat Distance -->
                <div class="form-group">
                    <label for="laundry_distance">最寄りランドリー情報（住所と徒歩時間）</label>
                    <textarea name="laundry_distance" id="laundry_distance" class="form-control" rows="3"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">職場を作成</button>
            </form>
        </div>
    </div>
</div>
@endsection
