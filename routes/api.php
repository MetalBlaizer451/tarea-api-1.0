<?php

use App\Http\Controllers\TareaController;

Route::get('/tareas', [TareaController::class, 'index']);
Route::post('/tareas', [TareaController::class, 'store']);
Route::delete('/tareas/{tarea}', [TareaController::class, 'destroy']);
Route::put('/tareas/{tarea}', [TareaController::class, 'update']);
