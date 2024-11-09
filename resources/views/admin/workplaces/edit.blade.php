@extends('layouts.admin.admin')

@section('title', '職場の編集')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="h4 text-gray-800"><i class="fas fa-edit"></i> 職場の編集 #{{ $workplace->id }}</h1>
        <div>
            <a href="{{ route('admin.workplaces.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> 戻る
            </a>
        </div>
    </div>

    <!-- Form for Editing Workplace -->
    <form action="{{ route('admin.workplaces.update', $workplace->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-info-circle"></i> 職場情報</h5>

                <div class="form-group">
                    <label for="workplace">職場名</label>
                    <input type="text" name="workplace" id="workplace" class="form-control" value="{{ old('workplace', $workplace->workplace) }}" required>
                </div>

                <div class="form-group">
                    <label for="zipcode">郵便番号</label>
                    <input type="text" name="zipcode" id="zipcode" class="form-control" value="{{ old('zipcode', $workplace->zipcode) }}" maxlength="7" required>
                </div>

                <div class="form-group">
                    <label for="address">住所</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $workplace->address) }}" required>
                </div>

                <div class="form-group">
                    <label for="total_rooms">総部屋数</label>
                    <input type="number" name="total_rooms" id="total_rooms" class="form-control" value="{{ old('total_rooms', $workplace->total_rooms) }}" min="0">
                </div>

                <div class="form-group">
                    <label for="linen">リネン</label>
                    <input type="text" name="linen" id="linen" class="form-control" value="{{ old('linen', $workplace->linen) }}">
                </div>

                <div class="form-group">
                    <label for="laundry_distance">最寄りランドリー情報（住所と徒歩時間）</label>
                    <textarea name="laundry_distance" id="laundry_distance" class="form-control" rows="3">{{ old('laundry_distance', $workplace->laundry_distance) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-right mb-4">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> 変更を保存</button>
        </div>
    </form>
</div>

<script src="{{ asset('js/zipcodeHandler.js') }}"></script>

@endsection
