<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('column', \App\Http\Controllers\ColumnController::class);
Route::apiResource('task', \App\Http\Controllers\TaskController::class);

Route::patch('column/{column}/move', [\App\Http\Controllers\ColumnController::class, 'move']);
Route::patch('task/{task}/move', [\App\Http\Controllers\TaskController::class, 'move']);
Route::patch('column/{column}/tasks/reorder', [\App\Http\Controllers\ColumnController::class, 'reorderTasks']);
