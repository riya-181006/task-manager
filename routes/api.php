<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\APITasksController;

Route::post('/task', [APITasksController::class, 'create']);
Route::get('/tasks', [APITasksController::class, 'index']);
Route::get('/task/{id}', [APITasksController::class, 'getTaskById']);
Route::put('/task/{id}', [APITasksController::class, 'update']);
Route::post('/task/done/{id}', [APITasksController::class, 'markAsDone']);
Route::delete('/task/{id}', [APITasksController::class, 'delete']);