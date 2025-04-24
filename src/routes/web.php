<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ChatController;

Route::get('/', [ItemController::class, 'index'])->name('items.index');

Route::get('/item/{itemId}',[ItemController::class, 'show'])->name('items.show');
Route::post('/item/{itemId}/like', [LikeController::class, 'toggle'])->name('likes.toggle');

Route::middleware(['auth'])->group(function () {
    Route::get('/purchase/{itemId}', [OrderController::class, 'create'])->name('purchase.create');
    Route::get('/purchase/address/{itemId}', [OrderController::class, 'editAddress'])->name('address.edit');
    Route::post('/purchase/address/{itemId}', [OrderController::class, 'updateAddress'])->name('address.update');
    Route::post('/order/store/{itemId}', [OrderController::class, 'store'])->name('order.store');
    Route::get('/success', [OrderController::class, 'success'])->name('checkout.success');
    Route::get('/cancel', [OrderController::class, 'cancel'])->name('checkout.cancel');
    Route::get('/chat/{orderId}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{orderId}', [ChatController::class, 'store'])->name('chat.store');
    Route::put('/chat/{chat}', [ChatController::class, 'update'])->name('chat.update');
    Route::delete('/chat/{chat}', [ChatController::class, 'destroy'])->name('chat.destroy');
    Route::get('/sell', [ItemController::class, 'create'])->name('items.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('items.store');
    Route::get('/mypage', [UserController::class, 'index'])->name('profile.index');
    Route::get('/mypage/profile', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/mypage/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/comments/{itemId}', [CommentController::class, 'store'])->name('comments.store');
});