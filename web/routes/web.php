<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomePageController@index' );
Route::get('/map', 'HomePageController@map' );
Route::get('/covid-ol-points', 'HomePageController@covidOlPoints' );
Route::get('/test', 'HomePageController@test' );


Route::get('/lastStatsBycountry', 'ReportsController@displayLastStatsByCountry' );
Route::get('/historyByCountry', 'ReportsController@getHistoryByCountry' );
Route::get('/graphByCountry', 'ReportsController@displayGraphByCountry' );

Route::get('/graphByCountryAPI', 'ReportsController@displayGraphByCountryAPI' );
Route::get('/graphByCountryAPIWrapper', 'ReportsController@displayGraphByCountryAPIWrapped' );

