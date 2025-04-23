<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\SigninController;
use App\Http\Controllers\Signin\PasswordController;
use App\Http\Controllers\Signin\ResetController;

// ログイン関連
Route::get('/', [SigninController::class, 'index'])->name('signin');
Route::post('/', [SigninController::class, 'signin']);
Route::get('/signout', [SigninController::class, 'signout'])->name('signout');

// パスワードリセット関連
Route::get('/signin/password', [PasswordController::class, 'index'])->name('signin.password');
Route::post('/signin/password', [PasswordController::class, 'store']);
Route::get('/signin/password/complete', [PasswordController::class, 'complete'])->name('signin.password.complete');
Route::post('signin/reset', [ResetController::class, 'store'])->name('signin.reset');
Route::get('signin/reset/complete', [ResetController::class, 'complete'])->name('signin.reset.complete');
Route::get('signin/reset/{token}', [ResetController::class, 'verify'])->name('signin.reset.verify');

// 会員管理関連
Route::get('members', [MemberController::class, 'index'])->name('members');
Route::get('members/new', [MemberController::class, 'create'])->name('members.create');
Route::post('members', [MemberController::class, 'store'])->name('members.store');
Route::get('members/search_ajax', [MemberController::class, 'search_ajax'])->name('members.search_ajax');
Route::post('members/bulk_update',[MemberController::class, 'bulk_update'])->name('members.bulk_update');
Route::get('members/{member_id}/edit', [MemberController::class, 'edit'])->name('members.edit')->where('member_id', '[0-9]+');
Route::post('members/{member_id}', [MemberController::class, 'update'])->name('members.update')->where('member_id', '[0-9]+');
Route::get('members/bulk', [MemberController::class, 'bulk'])->name('members.bulk');
Route::get('members/bulk_download', [MemberController::class, 'bulk_download'])->name('members.bulk_download');
Route::get('members/bulk_template_download', [MemberController::class, 'bulk_template_download'])->name('members.bulk_template_download');
Route::post('members/bulk_upload', [MemberController::class, 'bulk_upload'])->name('members.bulk_upload');
