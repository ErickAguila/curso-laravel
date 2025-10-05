<?php
use App\Http\Controllers\BackendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QueierisController;
use App\Http\Controllers\AuthController;

use App\Http\Middleware\CheckValueInHeader;
use App\Http\Middleware\LogRequest;
use App\Http\Middleware\UppercaseName;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    return 'El backend funciona correctamente'; 
});

Route::get('/backend', [BackendController::class, 'getAll'])
    ->middleware('checkvalue');
Route::get('/backend/{id?}', [BackendController::class, 'get']);
Route::post('/backend', [BackendController::class, 'create']);
Route::put('/backend/{id}', [BackendController::class, 'update']);
Route::delete('/backend/{id}', [BackendController::class, 'delete']);

Route::get('/query', [QueierisController::class, 'get']);
Route::get('/query/{id}', [QueierisController::class, 'getById']);
Route::get('/query/method/names', [QueierisController::class, 'getNames']);
Route::get('/query/method/search/{name}/{price}', [QueierisController::class, 'searchName']);
Route::post('/query/method/advancedSearch', [QueierisController::class, 'advancedSearch']);
Route::get('/query/method/join', [QueierisController::class, 'join']);
Route::get('/query/method/groupby', [QueierisController::class, 'groupBy']);

Route::apiResource('/product', ProductController::class)
    ->middleware(['jwt.auth',LogRequest::class]);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/who', [AuthController::class, 'who']);
    Route::post('/logout', [AuthController::class, 'logout']);
});