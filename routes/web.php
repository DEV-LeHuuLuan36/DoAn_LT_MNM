<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Campus Lost & Found HUIT
|--------------------------------------------------------------------------
*/

// --- 1. ROUTE CÔNG KHAI (PUBLIC) ---
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// --- 2. ROUTE KHÁCH CHƯA ĐĂNG NHẬP (GUEST) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// --- 3. ROUTE NGƯỜI DÙNG ĐÃ ĐĂNG NHẬP (AUTH) ---
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Quản lý thông tin cá nhân (Profile)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/my-items', [ProfileController::class, 'myItems'])->name('profile.my-items');
    Route::get('/my-claims', [ProfileController::class, 'myClaims'])->name('profile.my-claims');

    // Đăng bài & Quản lý bài đăng cá nhân (đặt /items/create trước /items/{item})
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

    // Yêu cầu nhận lại đồ thất lạc (Claims)
    Route::post('/items/{item}/claims', [ClaimController::class, 'store'])->name('claims.store');
    Route::delete('/claims/{claim}', [ClaimController::class, 'destroy'])->name('claims.destroy');

    // Bình luận (Comments)
    Route::post('/items/{item}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Chi tiết bài đăng (Đặt sau /items/create để không bị xung đột wildcard)
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

// --- 4. ROUTE DÀNH CHO QUẢN TRỊ VIÊN (ADMIN) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Tổng quan bảng điều khiển
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Quản lý Danh mục
    Route::resource('categories', CategoryController::class)->except('show');

    // Quản lý Địa điểm
    Route::resource('locations', LocationController::class)->except('show');

    // Quản lý Bài đăng
    Route::get('/items', [AdminController::class, 'items'])->name('items.index');
    Route::patch('/items/{item}/status', [AdminController::class, 'updateItemStatus'])->name('items.status');
    Route::delete('/items/{item}', [AdminController::class, 'destroyItem'])->name('items.destroy');

    // Xử lý yêu cầu nhận đồ (Claims)
    Route::get('/claims', [AdminController::class, 'claims'])->name('claims.index');
    Route::patch('/claims/{claim}', [AdminController::class, 'handleClaim'])->name('claims.handle');

    // Quản lý Người dùng
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});
