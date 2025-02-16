<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;


// Client
Route::group(['prefix' => 'client', 'as' => 'client.'], function () {

    Route::get('home', [HomeController::class, 'viewHome'])->name('viewHome');
});