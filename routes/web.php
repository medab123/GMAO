<?php

use App\Http\Controllers\DemandeController;
use App\Http\Controllers\MachinController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SousAffectationController;
use App\Http\Controllers\TechnicienController;
use App\Http\Controllers\TypeIntervontionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {


    //Route::resource("machines",MachinController::class,["names"=>"machines"]);
    //Route::resource("typeIntervontions",MachinController::class,["names"=>"typeIntervontions"]);


    Route::view('about', 'about')->name('about');

    Route::resource('users', UserController::class , ["names"=>"users"]) ;

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update2');


    Route::get('/machines/refreshTable', [MachinController::class,"refreshTable"])->name("machines.refreshTable");
    Route::post('/machines/{id}', [MachinController::class,"update"])->name("machines.update2");
    Route::resource('machines', MachinController::class,["names"=>"machines"]);

    Route::get('/typeIntervontions/refreshTable', [TypeIntervontionController::class,"refreshTable"])->name("typeIntervontions.refreshTable");
    Route::post('/typeIntervontions/{id}', [TypeIntervontionController::class,"update"])->name("typeIntervontions.update2");
    Route::resource('typeIntervontions', TypeIntervontionController::class,["names"=>"typeIntervontions"]);

    Route::get('/demandes/refreshTable', [DemandeController::class,"refreshTable"])->name("demandes.refreshTable");
    Route::post('/demandes/{id}', [DemandeController::class,"update"])->name("demandes.update2");
    Route::resource('demandes', DemandeController::class,["names"=>"demandes"]);

    Route::get('/niveauIntervontions/refreshTable', [NiveauController::class,"refreshTable"])->name("niveauIntervontions.refreshTable");
    Route::post('/niveauIntervontions/{id}', [NiveauController::class,"update"])->name("niveauIntervontions.update2");
    Route::resource('niveauIntervontions', NiveauController::class,["names"=>"niveauIntervontions"]);

    Route::get('/technciens/refreshTable', [TechnicienController::class,"refreshTable"])->name("technciens.refreshTable");
    Route::post('/technciens/{id}', [TechnicienController::class,"update"])->name("technciens.update2");
    Route::resource('technciens', TechnicienController::class,["names"=>"technciens"]);

    
    

});
