@extends('layouts.user.user')

@section('title', 'タスク詳細')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="h4 text-gray-800"><i class="fas fa-tasks"></i> タスク詳細</h1>
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> 戻る
        </a>
    </div>

    <!-- Task Details Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">タスク #{{ $task->id }}</h6>
            <div>
                @if($task->status == '未開始')
                    <button class="btn btn-success btn-sm" id="startTaskBtn"><i class="fas fa-play"></i> 開始</button>
                @elseif($task->status == '進行中')
                    <button class="btn btn-danger btn-sm" id="endTaskBtn"><i class="fas fa-stop"></i> 終了</button>
                @endif
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm table-borderless">
                <tr>
                    <th>作業日</th>
                    <td>{{ \Carbon\Carbon::parse($task->work_date)->format('Y-m-d') }}</td>
                </tr>
                <tr>
                    <th>開始時間</th>
                    <td>{{ $task->start_time ?? '-' }}</td>
                </tr>
                <tr>
                    <th>終了時間</th>
                    <td>{{ $task->end_time ?? '-' }}</td>
                </tr>
                <tr>
                    <th>職場</th>
                    <td>{{ $task->workplace->workplace }}</td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td>{{ $task->workplace->address }}</td>
                </tr>
                <tr>
                    <th>シフト</th>
                    <td>{{ $task->shift }}</td>
                </tr>
                <tr>
                    <th>ステータス</th>
                    <td>
                        <span class="badge badge-{{ 
                            $task->status == '未開始' ? 'secondary' : 
                            ($task->status == '進行中' ? 'primary' : 
                            ($task->status == '完了' ? 'success' : 'danger'))
                        }}">
                            {{ $task->status }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>説明</th>
                    <td>{{ $task->description ?? '説明なし' }}</td>
                </tr>
                <tr>
                    <th>メモ</th>
                    <td>{{ $task->notes ?? 'メモなし' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Image Management Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-images"></i> タスクの画像</h6>
        </div>
        <div class="card-body">
            <form id="uploadForm" action="{{ route('user.tasks.uploadImages', $task->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="images">画像をアップロード</label>
                    <input type="file" name="images[]" id="images" class="form-control-file" multiple accept="image/*">
                </div>
                <button type="button" id="uploadImagesBtn" class="btn btn-primary btn-sm"><i class="fas fa-upload"></i> アップロード</button>
            </form>


            <!-- Existing Images -->
            <div class="row mt-4">
                @foreach ($task->images as $image)
                    <div class="col-6 col-md-3 col-lg-2 mb-3">
                        <div class="card shadow-sm position-relative">
                            <a href="{{ asset('storage/' . $image->path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top rounded" alt="Task Image" style="height: 100px; object-fit: cover;">
                            </a>
                            <form action="{{ route('user.tasks.deleteImage', ['task' => $task->id, 'image' => $image->id]) }}" method="POST" class="delete-image-form position-absolute" style="top: 5px; right: 5px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function showConfirmationModal(message, callback) {
            $('#confirmModalBody').text(message); 
            $('#confirmModal').modal('show'); 

            $('#confirmActionBtn').off('click').on('click', function() {
                callback();
                $('#confirmModal').modal('hide');
            });
        }

        $('#startTaskBtn').click(function() {
            showConfirmationModal('タスクを開始してもよろしいですか？', function() {
                updateTaskStatus('進行中');
            });
        });

        $('#endTaskBtn').click(function() {
            showConfirmationModal('タスクを終了してもよろしいですか？', function() {
                updateTaskStatus('完了');
            }); 
        });

        $('#uploadImagesBtn').click(function() {
            $('#uploadForm').submit(); 
        });

        $('form.delete-image-form').on('submit', function(e) {
            e.preventDefault(); 
            let form = $(this);

            showConfirmationModal('この画像を削除してもよろしいですか？', function() {
                form.off('submit').submit(); 
            });
        });

        function updateTaskStatus(status) {
            $.ajax({
                url: '{{ route("user.tasks.updateStatus", $task->id) }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    location.reload(); 
                },
                error: function() {
                    alert('エラーが発生しました。再試行してください。');
                }
            });
        }
    });

</script>

@endsection
