<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return response()->json(["message" => "Hi there!"]);
});

Route::group(["prefix" => "v1", "as" => "v1.", "middleware" => ["log"]], function () {
    Route::post("/auth/register", [AuthController::class, "register"])->name("auth.register");
    Route::post("/auth/login", [AuthController::class, "login"])->name("auth.login");

    Route::group(["middleware" => "auth:sanctum"], function () {
        Route::post("vendors/register", [VendorController::class, "store"])->name("vendor.register");
        Route::apiResource("products", ProductController::class);
    });
});
