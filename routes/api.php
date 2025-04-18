<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(TaskController::class)->group(function () {
    Route::post('/tasks', 'store')->name('tasks.new');
    Route::patch('/tasks/{task}', 'update')->name('tasks.update');
    Route::delete('/tasks/{task}', 'destroy')->name('tasks.delete');
    Route::patch('/tasks/{task}/done', 'markDone')->name('tasks.mark.done');
});