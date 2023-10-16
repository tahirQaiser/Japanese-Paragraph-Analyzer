<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('/jisho-api/{keyword}', [\App\Http\Controllers\HomeController::class, 'jishoApi'])->name('jisho.api');
Route::post('/process-words', [\App\Http\Controllers\HomeController::class, 'processWords'])->name('process.words');
Route::resource('vocabularies', \App\Http\Controllers\VocabularyController::class);
Route::get('my-vocabulary', [\App\Http\Controllers\VocabularyController::class, 'myVocabulary'])->name('my.vocabulary');