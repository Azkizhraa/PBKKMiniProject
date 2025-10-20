<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return redirect()->route('menu-items.index');
});

Route::resource('menu-items', MenuItemController::class);
Route::resource('orders', OrderController::class)->except(['show', 'edit', 'destroy']);
