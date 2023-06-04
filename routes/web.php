<?php

use App\Http\Controllers\AnswersController;
use App\Http\Controllers\QuestionsController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('questions', QuestionsController ::class)->except('show');
Route::get('/questions/{slug}', [App\Http\Controllers\QuestionsController::class, 'show'])->name('questions.show');
Route::resource('questions.answers', AnswersController::class)->except('create', 'show');
Route::put('/questions/{question}/answers/{answer}/mark-as-best', [App\Http\Controllers\AnswersController::class,'markAsBest'])->name('questions.answers.markAsBest');
Route::post('/questions/{question}/mark-as-fav',[App\Http\Controllers\FavoritesController::class, 'store'])->name('questions.mark-as-fav');
Route::delete('/questions/{question}/mark-as-unfav',[App\Http\Controllers\FavoritesController::class, 'destroy'])->name('questions.mark-as-unfav');

