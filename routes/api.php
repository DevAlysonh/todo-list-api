<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('jwt')->group(function () {
    Route::get('/whoami', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

Route::middleware('jwt')->controller(TaskController::class)->group(function () {
    Route::get('/tasks', 'index')->name('tasks.all');
    Route::post('/tasks', 'store')->name('tasks.new');
    Route::patch('/tasks/{task}', 'update')->name('tasks.update');
    Route::delete('/tasks/{task}', 'destroy')->name('tasks.delete');
    Route::patch('/tasks/{task}/done', 'markDone')->name('tasks.mark.done');
});