<?php

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

Route::get('/home', 'HomeController@index')->name('home');

// работает по адресу /test
// добавляем middleware для тестирования
// Route::get('/test', function() {return "Goodbye";})->middleware('\App\Http\Middleware\CheckQueryParam');
// новое middleware для тестирования авторизации - доступ к этой странице будет ограничен без авторизации
Route::get('/test', function() {return "Goodbye";})->middleware('auth');

// ? означает необязательный параметр
//Route::get('/rooms/{roomType?}', 'ShowRoomsController');
// изменения под глубокое изучение маршрутов;
// необязательное "where->" добавляет гарантию того, что параметр будет только строкой, а не числом
// Route::get('/rooms/{name}/{roomType?}', 'ShowRoomsController')->where('name', '[A-Za-z]+');

Route::get('/rooms/{roomType?}', 'ShowRoomsController');


//Равнозначно - Route::resource('bookings', 'BookingController'),
// но во избежание ошибок
// дополнительно нужно указывать имена маршрутов типа ->name('bookings.create'),
// если такой маршрут используется во вью.
/*
Route::get('/bookings', 'BookingController@index');
Route::get('/bookings/create', 'BookingController@create');
Route::post('/bookings', 'BookingController@store');
Route::get('/bookings/{booking}', 'BookingController@show');
Route::get('/bookings/{booking}/edit', 'BookingController@edit');
Route::put('/bookings/{booking}', 'BookingController@update');
Route::delete('/bookings/{booking}', 'BookingController@destroy');
*/
Route::resource('bookings', 'BookingController');

Route::resource('room_types', 'RoomTypeController');

