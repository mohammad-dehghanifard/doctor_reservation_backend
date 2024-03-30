<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DoctorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Category
Route::get("categories",[CategoryController::class,"fetch"]);
Route::post("create-category",[CategoryController::class,"create"]);
Route::put("update-category/{id}",[CategoryController::class,"update"]);
Route::delete("delete-category/{id}",[CategoryController::class,"delete"]);

// Doctor
Route::get("doctors",[DoctorController::class,"fetch"]);
Route::middleware('auth:sanctum')->post("reserve",[DoctorController::class,"reserve"]);
Route::post("create-doctor",[DoctorController::class,"create"]);
Route::put("update-doctor/{id}",[DoctorController::class,"update"]);
Route::delete("delete-doctor/{id}",[DoctorController::class,"delete"]);

// Auth
Route::post("register",[AuthController::class,"register"]);
Route::post("login",[AuthController::class,"login"]);
