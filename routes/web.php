<?php

use Illuminate\Http\Request;
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

//AUTH:--------------------------------------------------------------------
Auth::routes();

//WELCOME:-----------------------------------------------------------------
Route::get('/', 'Views\WelcomeController@index');

//DASHBOARD:---------------------------------------------------------------
Route::get('/home', 'Views\DashBoardController@index')->middleware('cors'); 
Route::get('/dashboard', 'Views\DashBoardController@index')->middleware('cors');   

//CALENDAR:---------------------------------------------------------
Route::get('/master-calendar', 'Views\MasterCalendarController@index');
    
//CLIENTS:-----------------------------------------------------------------
Route::get('/clients', 'Views\ClientController@index'); 
Route::get('/clients/create', 'Views\ClientController@create'); 
Route::get('/clients/details/{id}', 'Views\ClientController@show');
Route::get('/clients/search/{name}' , 'Views\ClientController@search'); 
                                                      
//MEDICALS:----------------------------------------------------------------
Route::get('/medicals/create','Views\MedicalController@create');    
Route::get('/clients/medical/{id}', 'Views\MedicalController@show'); 

//COSULTATIONS:------------------------------------------------------------
Route::get('/clients/consultation/{id}', 'Views\ConsultationController@show');

//APPOINTMENTS:------------------------------------------------------------
Route::get('/clients/appointment/{id}', 'Views\AppointmentController@show');

//SERVICES:----------------------------------------------------------------
Route::get('/service-products', 'Views\ServiceController@products');
Route::get('/service-discounts', 'Views\ServiceController@discounts');
Route::get('/service-treatments', 'Views\ServiceController@treatments');

//LOCK-SCREENS:-------------------------------------------------------------
Route::get('/lock-screens/new-client', 'Views\LockScreenController@newClient');





















