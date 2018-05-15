<?php

use Illuminate\Http\Request;
use App\Repositories\ConsultationEventRespositoryInterface;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Clients:-----------------------------------------------------------------
Route::get('/clients', 'Api\ClientController@index');  //INDEX
Route::post('/clients', 'Api\ClientController@store');    //STORE
Route::patch('/clients/{id}', 'Api\ClientController@update'); //UPDATE
Route::delete('/clients/{id}', 'Api\ClientController@destroy');  //DESTROY
Route::post('/clients/{id}/image', 'Api\ClientController@update');  //UPDATE
Route::get('/clients/search/{name}',  'Api\ClientController@search');   //SEARCH


//Medical:-----------------------------------------------------------------
Route::post('/medicals', 'Api\Medical\MedicalController@store'); //STORE
Route::get('/medicals/{id}', 'Api\Medical\MedicalController@show');  //SHOW
Route::patch('/medicals/{id}', 'Api\Medical\MedicalController@update'); //UPDATE

//StressLevels:-----------------------------------------------------------------
Route::post('/stress-levels', 'Api\Medical\StressLevelController@store'); //STORE
Route::get('/stress-levels/{id}', 'Api\Medical\StressLevelController@show');  //SHOW
Route::delete('/stress-levels/{id}', 'Api\Medical\StressLevelController@destroy'); //UPDATE


//SkinProduct:-------------------------------------------------------------
Route::post('/skin-products', 'Api\Medical\SkinProductController@store'); // store
Route::get('/skin-products/{medical}', 'Api\Medical\SkinProductController@show'); //show
Route::delete('/skin-products/{id}', 'Api\Medical\SkinProductController@destroy'); // destroy


//Medication:--------------------------------------------------------------
Route::post('/medications', 'Api\Medical\MedicationController@store'); // store
Route::get('/medications/{medical}', 'Api\Medical\MedicationController@show'); //show
Route::delete('/medications/{id}', 'Api\Medical\MedicationController@destroy'); // destroy


//Allergie:---------------------------------------------------------------
Route::post('/allergies', 'Api\Medical\AllergieController@store'); // store
Route::get('/allergies/{medical}', 'Api\Medical\AllergieController@show'); //show
Route::delete('/allergies/{id}', 'Api\Medical\AllergieController@destroy'); // destroy


//Illness:-----------------------------------------------------------------
Route::post('/illnesses', 'Api\Medical\IllnessController@store'); // store
Route::get('/illnesses/{medical}', 'Api\Medical\IllnessController@show'); //show
Route::delete('/illnesses/{id}', 'Api\Medical\IllnessController@destroy'); // destroy


//Surgery:-----------------------------------------------------------------
Route::post('/surgeries', 'Api\Medical\SurgeryController@store'); // store
Route::get('/surgeries/{medical}', 'Api\Medical\SurgeryController@show'); //show
Route::delete('/surgeries/{id}', 'Api\Medical\SurgeryController@destroy'); // destroy


//Consultations:-----------------------------------------------------------
Route::get('/consultations/{id}', 'Api\ConsultationController@show');
Route::post('/consultations', 'Api\ConsultationController@store');
Route::patch('/consultations/{id}', 'Api\ConsultationController@update');

Route::get('/latest-consultation/{id}', 'Api\ConsultationController@latest');


//Invoices:----------------------------------------------------------------
Route::get('/invoices/{id}', 'Api\InvoiceController@show');
Route::post('/invoices', 'Api\InvoiceController@store');


//Products:----------------------------------------------------------------
Route::get('/products', 'Api\Products\ProductController@index');
Route::post('/products', 'Api\Products\ProductController@store');
Route::patch('/products/{id}', 'Api\Products\ProductController@update');
Route::delete('/products/{id}', 'Api\Products\ProductController@destroy');
Route::get('/products/search/{name}', 'Api\Products\ProductController@search');
//Discounts:---------------------------------------------------------------
Route::get('/discounts', 'Api\Products\DiscountController@index');
Route::get('/discounts', 'Api\Products\DiscountController@index');
Route::post('/discounts', 'Api\Products\DiscountController@store');
Route::patch('/discounts/{id}', 'Api\Products\DiscountController@update');
Route::delete('/discounts/{id}', 'Api\Products\DiscountController@destroy');
Route::get('/discounts/search/{name}', 'Api\Products\DiscountController@search');
//Treatments:--------------------------------------------------------------
Route::get('/treatments', 'Api\Products\TreatmentController@index');
Route::post('/treatments', 'Api\Products\TreatmentController@store');
Route::patch('/treatments/{id}', 'Api\Products\TreatmentController@update');
Route::delete('/treatments/{id}', 'Api\Products\TreatmentController@destroy');
Route::get('/treatments/search/{name}', 'Api\Products\TreatmentController@search');


//Purchase-Products:---------------------------------------------------------------
Route::get('/purchase-products/{id}', 'Api\Purchases\ProductController@show');
Route::get('/purchase-products', 'Api\Purchases\ProductController@index');
Route::post('/purchase-products', 'Api\Purchases\ProductController@store');

//Purchase-Treatments:---------------------------------------------------------------
Route::get('/purchase-treatments/{id}', 'Api\Purchases\TreatmentController@show');
Route::get('/purchase-treatments', 'Api\Purchases\TreatmentController@index');
Route::post('/purchase-treatments', 'Api\Purchases\TreatmentController@store');

//Purchase-Discounts:---------------------------------------------------------------
Route::get('/purchase-discounts/{id}', 'Api\Purchases\DiscountController@show');
Route::get('/purchase-discounts', 'Api\Purchases\DiscountController@index');
Route::post('/purchase-discounts', 'Api\Purchases\DiscountController@store');

//Calendar Consutlations:-----------------------------------------------------------
Route::get('/calendar-consultations', 'Api\Calendar\ConsultationEventController@index');
Route::post('/calendar-consultations', 'Api\Calendar\ConsultationEventController@store');
Route::put('/calendar-consultations/{id}', 'Api\Calendar\ConsultationEventController@putUpdate');
Route::patch('/calendar-consultations/{id}', 'Api\Calendar\ConsultationEventController@patchUpdate');
Route::delete('/calendar-consultations/{id}', 'Api\Calendar\ConsultationEventController@destroy');
//Calendar Consultations Reminder:--------------------------------------------------
Route::get('/reminder-consultations/{day}', 'Api\Calendar\ConsultationEventController@reminders');


//Calendar Customs:-----------------------------------------------------------------
Route::get('/calendar-customs', 'Api\Calendar\CustomEventController@index');
Route::post('/calendar-customs', 'Api\Calendar\CustomEventController@store');
Route::put('/calendar-customs/{id}', 'Api\Calendar\CustomEventController@putUpdate');
Route::patch('/calendar-customs/{id}', 'Api\Calendar\CustomEventController@patchUpdate');
Route::delete('/calendar-customs/{id}', 'Api\Calendar\CustomEventController@destroy');
//Calendar Custom Reminder:---------------------------------------------------------
Route::get('/reminder-customs/{day}', 'Api\Calendar\CustomEventController@reminders');


//Locked Screens:-------------------------------------------------------------------
Route::get('/lock-screen', 'Api\LockScreenController@lockScreen');
Route::post('/lock-screen', 'Api\LockScreenController@unlockScreen');


//Terms & Conditions:---------------------------------------------------------------
Route::get('/terms-and-conditions', 'Api\TermsAndConditionController@index');
Route::post('/terms-and-conditions', 'Api\TermsAndConditionController@store');


//External Api Requests:
Route::get('/external-api/quote', 'Api\ExternalApiController@quote');
          