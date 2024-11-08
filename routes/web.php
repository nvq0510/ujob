<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WorkplaceController;
use App\Http\Controllers\Admin\TaskImageController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserTaskController;
use Illuminate\Support\Facades\Hash;



Route::get('/', function () {
    return view('home');
})->name('home');

// Login and Register routes only for guests
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Forgot Password routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// Logout route, only for authenticated users
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('role:admin');
    
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard')->middleware('role:user');
});


// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard management (API for AJAX)
    Route::prefix('dashboard')->group(function () {
        Route::post('filter', [DashboardController::class, 'filterByDate'])->name('dashboard.filter');
        Route::get('task-status-data', [DashboardController::class, 'getTaskStatusData'])->name('dashboard.taskStatusData');
    });

    // Task related routes
    Route::prefix('tasks')->name('tasks.')->group(function () {
        // Calendar data endpoint
        Route::get('calendar-data', [TaskController::class, 'getCalendarData'])->name('calendar-data');

        // Task image management routes
        Route::prefix('{task}/images')->name('images.')->group(function () {
            Route::get('/', [TaskImageController::class, 'index'])->name('index');
            Route::get('/create', [TaskImageController::class, 'create'])->name('create');
            Route::post('/', [TaskImageController::class, 'store'])->name('store');
            Route::delete('/{image}', [TaskImageController::class, 'destroy'])->name('destroy');
            Route::delete('/bulk-destroy', [TaskImageController::class, 'bulkDestroy'])->name('bulkDestroy');
        });
    });

    // Resource routes for tasks, users, workplaces
    Route::resource('tasks', TaskController::class);
    Route::resource('users', UserController::class);
    Route::resource('workplaces', WorkplaceController::class);

    // Custom routes for rooms
    Route::get('workplaces/{workplace}/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::resource('rooms', RoomController::class)->except(['index', 'create']);
});





Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/tasks', [UserTaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{task}', [UserTaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/upload-images', [UserTaskController::class, 'uploadImages'])->name('tasks.uploadImages');
    Route::delete('/tasks/{task}/images/{image}', [UserTaskController::class, 'deleteImage'])->name('tasks.deleteImage');
    Route::post('/tasks/{task}/update-status', [UserTaskController::class, 'updateStatus'])->name('tasks.updateStatus');
});




