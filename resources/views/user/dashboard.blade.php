@extends('layouts.user.user')

@section('title', 'ユーザーダッシュボード')

@section('content')
<div class="container-fluid">
    <!-- Welcome Card -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card bg-primary text-white shadow h-100 py-2 mb-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h3 font-weight-bold text-white text-uppercase mb-1">
                                こんにちは, {{ Auth::user()->name }}さん!
                            </div>
                            <div class="mb-0 text-white-50">
                                現在の役割: <span class="badge badge-light">ユーザー</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($work_date == \Carbon\Carbon::now()->format('Y-m-d'))
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow h-100">
                <div class="card-header bg-info py-3">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-list mr-2"></i>本日の業務
                    </h6>
                </div>
                <div class="card-body">
                    @if($tasks->isEmpty())
                        <div class="text-center py-3">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300 mb-2"></i>
                            <p class="text-gray-500 mb-0">本日の予定はありません</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach($tasks as $task)
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card border-left-{{ 
                                    $task->status == '未開始' ? 'secondary' : 
                                    ($task->status == '進行中' ? 'primary' : 
                                    ($task->status == '完了' ? 'success' : 'danger'))
                                }} shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    {{ $task->shift }}
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $task->workplace->workplace }}
                                                </div>
                                                <div class="text-sm text-gray-600 mt-2">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $task->start_time }} - {{ $task->end_time }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                @if($task->status == '未開始')
                                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                                @elseif($task->status == '進行中')
                                                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                                                @elseif($task->status == '完了')
                                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                                @else
                                                    <i class="fas fa-times-circle fa-2x text-danger"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <span class="badge badge-{{ 
                                                $task->status == '未開始' ? 'secondary' : 
                                                ($task->status == '進行中' ? 'primary' : 
                                                ($task->status == '完了' ? 'success' : 'danger'))
                                            }} mt-1">
                                                {{ $task->status }}
                                            </span>
                                        </div>
                                        <!-- Nút Xem Chi Tiết -->
                                        <div class="mt-3">
                                            <a href="{{ route('user.tasks.show', ['task' => $task->id]) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye mr-1"></i> Xem chi tiết
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif



    <!-- Task Schedule Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-calendar-alt mr-2"></i>
                {{ $work_date == \Carbon\Carbon::now()->format('Y-m-d') ? 'タスクの一覧' : $work_date  }}
            </h6>
        </div>
        <div class="card-body">
            <!-- Date Navigation Controls -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="date-navigation d-flex align-items-center justify-content-start">
                        <a href="{{ route('user.dashboard', ['work_date' => \Carbon\Carbon::parse($work_date)->subDay()->format('Y-m-d')]) }}" 
                           class="btn btn-outline-primary btn-circle mr-2">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        
                        <input type="date"
                            name="work_date"
                            id="work_date"
                            class="form-control form-control-lg text-center mx-2"
                            style="max-width: 200px;"
                            value="{{ $work_date }}"
                            onchange="window.location.href='{{ route('user.dashboard') }}?work_date='+this.value;">

                        <a href="{{ route('user.dashboard', ['work_date' => \Carbon\Carbon::parse($work_date)->addDay()->format('Y-m-d')]) }}" 
                           class="btn btn-outline-primary btn-circle ml-2">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex justify-content-lg-end justify-content-start mt-3 mt-lg-0">
                        <a href="{{ route('user.dashboard') }}" 
                           class="btn btn-primary">
                            <i class="fas fa-calendar-day mr-2"></i>今日
                        </a>
                    </div>
                </div>
            </div>

            <!-- Month Picker -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <form action="{{ route('user.dashboard') }}" method="GET" class="d-flex align-items-center">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-calendar mr-2"></i>月を選択
                                </span>
                            </div>
                            <input type="month" 
                                   name="work_month" 
                                   id="work_month" 
                                   class="form-control" 
                                   value="{{ $work_month }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search mr-2"></i>検索
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tasks Table -->
            @if($tasks->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-tasks fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500 mb-0">現在、割り当てられたタスクはありません。</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center"><i class="fas fa-calendar-day mr-2"></i>作業日</th>
                                <th class="text-center"><i class="fas fa-clock mr-2"></i>シフト</th>
                                <th class="text-center"><i class="fas fa-hourglass-start mr-2"></i>開始時間</th>
                                <th class="text-center"><i class="fas fa-hourglass-end mr-2"></i>終了時間</th>
                                <th class="text-center"><i class="fas fa-building mr-2"></i>職場</th>
                                <th class="text-center"><i class="fas fa-info-circle mr-2"></i>ステータス</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($task->work_date)->format('Y-m-d') }}
                                    </td>
                                    <td class="text-center">{{ $task->shift }}</td>
                                    <td class="text-center">{{ $task->start_time }}</td>
                                    <td class="text-center">{{ $task->end_time }}</td>
                                    <td class="text-center">{{ $task->workplace->workplace }}</td>
                                    <td class="text-center">
                                        @if($task->status == '未開始')
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-clock mr-1"></i>{{ $task->status }}
                                            </span>
                                        @elseif($task->status == '進行中')
                                            <span class="badge badge-primary">
                                                <i class="fas fa-spinner fa-spin mr-1"></i>{{ $task->status }}
                                            </span>
                                        @elseif($task->status == '完了')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check mr-1"></i>{{ $task->status }}
                                            </span>
                                        @elseif($task->status == 'キャンセル')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times mr-1"></i>{{ $task->status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Highlight current day's row
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const dateCell = row.querySelector('td:first-child');
            if (dateCell && dateCell.textContent.trim() === today) {
                row.classList.add('bg-light');
            }
        });
    });
</script>
@endpush
@endsection