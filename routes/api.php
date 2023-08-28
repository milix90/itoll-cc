<?php

use App\Constants\Endpoints;
use Illuminate\Support\Facades\Route;

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::group([
    'prefix' => Endpoints::API_V1['endpoint'],
    'as' => Endpoints::API_V1['name'],
], static function () {
    Route::group([
        'prefix' => Endpoints::ORDER['endpoint'],
        'as' => Endpoints::ORDER['name'],
        // 'middleware' => ['client.evaluate'],
    ], static function () {
        Route::post('submit', [Endpoints::ORDER['class'], 'submit'])->name('submit');
        Route::get('available', [Endpoints::ORDER['class'], 'available'])->name('available');
        Route::get('inquire/{uuid}', [Endpoints::ORDER['class'], 'inquire'])->name('inquire');
        Route::patch('approve/{uuid}', [Endpoints::ORDER['class'], 'approve'])->name('approve');
        Route::patch('revoke/{uuid}', [Endpoints::ORDER['class'], 'revoke'])->name('revoke');
        Route::patch('receive/{uuid}', [Endpoints::ORDER['class'], 'receive'])->name('receive');
        Route::patch('deliver/{uuid}', [Endpoints::ORDER['class'], 'deliver'])->name('deliver');
        Route::patch('reject/{uuid}', [Endpoints::ORDER['class'], 'reject'])->name('reject');
        Route::patch('reclaim/{uuid}', [Endpoints::ORDER['class'], 'reclaim'])->name('reclaim');
    });
});
