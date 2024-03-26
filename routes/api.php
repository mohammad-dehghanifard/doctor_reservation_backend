<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("create-category",[CategoryController::class,"create"]);
Route::put("update-category/{id}",[CategoryController::class,"update"]);
Route::delete("delete-category/{id}",[CategoryController::class,"delete"]);
