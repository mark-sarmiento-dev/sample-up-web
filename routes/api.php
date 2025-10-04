<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Api\GroupObjectExpenditureController;
use App\Http\Controllers\Api\ObjectExpenditureController;
use App\Http\Controllers\Api\PaoRequestController;
use App\Http\Controllers\Api\OfficeCodeController;
use App\Http\Controllers\Api\AnnualBudgetController;
use App\Http\Controllers\Api\OfficeCodeBudgetController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    Route::apiResource('employees', EmployeeController::class);
});

Route::post('/createToken', [LoginController::class, 'createToken']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});
Route::get('/office-code-budgets/by-office-code/{officeCodeId}', [OfficeCodeBudgetController::class, 'getByOfficeCode']);

// Annual Budget
Route::middleware('auth:sanctum')->apiResource('annual-budgets', AnnualBudgetController::class);

// Annual Budget
Route::middleware('auth:sanctum')->group(function () {
    // Route for getting budgets by a specific office code ID.
    Route::get('/office-code-budgets/by-office-code/{officeCodeId}', [OfficeCodeBudgetController::class, 'getByOfficeCode']);

    // Standard resource routes for Office Code Budgets.
    Route::apiResource('office-code-budgets', OfficeCodeBudgetController::class);
});
// Office Codes
Route::middleware('auth:sanctum')->apiResource('office-codes', OfficeCodeController::class);

// Group Object Expenditures
Route::middleware('auth:sanctum')->apiResource('group-object-expenditures', GroupObjectExpenditureController::class);

// Object Expenditures
Route::middleware('auth:sanctum')->apiResource('object-expenditures', ObjectExpenditureController::class);

//PAO Request
Route::prefix('pao-requests')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [PaoRequestController::class, 'store']);
    Route::get('/', [PaoRequestController::class, 'index']);
    Route::get('/{id}', [PaoRequestController::class, 'show']);
    Route::match(['PUT', 'PATCH'], '/{id}', [PaoRequestController::class, 'update']);
    Route::delete('/{id}', [PaoRequestController::class, 'destroy']); // delete full request
    Route::delete('/{requestId}/objects/{objectId}', [PaoRequestController::class, 'destroyObject']); // delete single object
    Route::delete('/{requestId}/groups/{groupId}', [PaoRequestController::class, 'destroyGroup']);
});
