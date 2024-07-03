<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AxiosApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('AxiosApi/v1')->name('Axios.')->group(function () {
    Route::post('getInventoryItem',[AxiosApiController::class,'getInventoryItem'])->name('getInventoryItem');
});


