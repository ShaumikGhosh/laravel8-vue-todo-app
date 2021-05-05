<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TodoController;




Route::post('/login', [UserController::class, 'authenticate']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/verify-user/{token}/{target}', [UserController::class, 'verifyUserMail']);



Route::group(['prefix' => 'user'], function () {
    
    Route::get('/authed-user', [UserController::class, 'getAuthenticatedUser']);
    Route::get('/logout', [UserController::class, 'logout']);

    Route::post('/create-todo', [TodoController::class, 'createTodo']);
    Route::get('/my-todos', [TodoController::class, 'myTodos']);
    Route::get('/my-todo/{id}', [TodoController::class, 'getMyTodo']);
    Route::post('/update-todo/{id}', [TodoController::class, 'updateTodo']);
    Route::get('/delete-todo/{id}', [TodoController::class, 'deleteTodo']);
    Route::post('/search-todo', [TodoController::class, 'searchForTodo']);

});
