<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('/', ToDoController::class)->names('api.todo')->parameters([
    '' => 'toDo',
]);
Route::put('/{toDo}/complete', [ToDoController::class, "complete"])->name('api.todo.complete');
