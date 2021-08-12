<?php


use App\Http\Controllers\WebNotificationController;
use Illuminate\Support\Facades\Route;
use DeviceDetector\DeviceDetector;

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
//    $userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse
//
//    $dd = new DeviceDetector($userAgent);
//    $dd->parse();
//    dd($dd->getClient('name'));

    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware'=>'auth'],function () {
        Route::resource('reminders',\App\Http\Controllers\ReminderController::class);
        Route::get('/home', [WebNotificationController::class, 'index'])->name('home');
        Route::patch('/settings', [WebNotificationController::class, 'updateSettings'])->name('settings.update');
        Route::post('/store-token', [WebNotificationController::class, 'storeToken'])->name('store.token');
        Route::post('/send-web-notification', [WebNotificationController::class, 'sendWebNotification'])->name('send.web-notification');
});


