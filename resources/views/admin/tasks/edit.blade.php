@extends('layouts.admin.admin')

@section('title', 'タスクの編集')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="h4 text-gray-800"><i class="fas fa-edit"></i> タスクの編集 #{{ $task->id }}</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> 戻る
        </a>
    </div>

    <!-- Form for Editing Task Details and Images -->
    <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Task Details Section -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-info-circle"></i> タスク情報</h5>

                <div class="form-group">
                    <label for="user">ユーザー</label>
                    <select name="user_id" id="user" class="form-control">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $task->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="workplace">職場</label>
                    <select name="workplace_id" id="workplace" class="form-control">
                        @foreach ($workplaces as $workplace)
                            <option value="{{ $workplace->id }}" {{ $task->workplace_id == $workplace->id ? 'selected' : '' }}>
                                {{ $workplace->workplace }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="work_date">作業日</label>
                    <input type="date" name="work_date" id="work_date" class="form-control" value="{{ $task->work_date->format('Y-m-d') }}">
                </div>

                <div class="form-group">
                    <label for="shift">シフト</label>
                    <input type="text" name="shift" id="shift" class="form-control" value="{{ $task->shift }}">
                </div>

                <div class="form-group">
                    <label for="start_time">開始時間</label>
                    <input type="time" name="start_time" id="start_time" class="form-control" value="{{ $task->start_time }}">
                </div>

                <div class="form-group">
                    <label for="end_time">終了時間</label>
                    <input type="time" name="end_time" id="end_time" class="form-control" value="{{ $task->end_time }}">
                </div>

                <div class="form-group">
                    <label for="status">ステータス</label>
                    <select name="status" id="status" class="form-control">
                        <option value="未開始" {{ $task->status == '未開始' ? 'selected' : '' }}>未開始</option>
                        <option value="進行中" {{ $task->status == '進行中' ? 'selected' : '' }}>進行中</option>
                        <option value="完了" {{ $task->status == '完了' ? 'selected' : '' }}>完了</option>
                        <option value="キャンセル" {{ $task->status == 'キャンセル' ? 'selected' : '' }}>キャンセル</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">説明</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ $task->description ?? '説明なし' }}</textarea>
                </div>

                <div class="form-group">
                    <label for="notes">メモ</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3">{{ $task->notes ?? 'メモなし' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Image Upload and Preview Section -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-images"></i> タスクの画像</h5>

                <!-- Image Upload Field -->
                <div class="form-group">
                    <label for="images">新しい画像をアップロード</label>
                    <input type="file" name="images[]" id="images" class="form-control-file" multiple accept="image/*">
                </div>

                <!-- Preview Section for Newly Selected Images -->
                <div class="row mt-3" id="image-preview">
                    <!-- JavaScript will inject new image previews here -->
                </div>

                <!-- Existing Images Grid with Delete Option -->
                <div class="row mt-4">
                    @foreach ($task->images as $image)
                        <div class="col-6 col-md-3 col-lg-2 mb-3">
                            <div class="card shadow-sm position-relative">
                                <a href="{{ asset($image->path) }}" target="_blank">
                                    <img src="{{ asset($image->path) }}" class="card-img-top rounded" alt="Task Image" style="height: 100px; object-fit: cover;">
                                </a>
                                <!-- Checkbox for multi-selection -->
                                <div class="position-absolute" style="top: 5px; right: 5px;">
                                    <input type="checkbox" name="delete_image_ids[]" value="{{ $image->id }}" class="form-check-input">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Delete selected button -->
                @if ($task->images->isNotEmpty())
                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i> 選択した画像を削除
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit" class="btn btn-success">変更を保存</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        // Image preview logic for newly selected images
        $('#images').on('change', function(event) {
            let imagePreview = $('#image-preview');
            imagePreview.empty(); // Clear previous images

            const maxSize = 2 * 1024 * 1024; // 2MB
            let fileTooLarge = false;

            $.each(event.target.files, function(index, file) {
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ファイルサイズエラー',
                        text: `ファイル "${file.name}" は2MBを超えています。`
                    });
                    fileTooLarge = true;
                    return false; // Break the loop
                }

                let reader = new FileReader();
                reader.onload = function(e) {
                    let div = `
                        <div class="col-6 col-md-3 col-lg-2 mb-3">
                            <div class="card shadow-sm">
                                <img src="${e.target.result}" class="card-img-top rounded" alt="Task Image" style="height: 100px; object-fit: cover;">
                            </div>
                        </div>
                    `;
                    imagePreview.append(div);
                };
                reader.readAsDataURL(file);
            });

            if (fileTooLarge) {
                $(this).val(''); // Reset the file input
            }
        });


        $('.btn-success').on('click', function(event) {
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
                    $(this).closest('form').submit();
                }
            });
        });

        $('.btn-danger').on('click', function(event) {
            event.preventDefault(); 

            Swal.fire({
                title: '選択した画像を削除しますか？',
                text: "この操作は元に戻せません。",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'はい、削除します',
                cancelButtonText: 'キャンセル'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('form').submit();
                }
            });
        });
    });

</script>

@endsection

