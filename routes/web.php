<?php

use App\Jobs\ProcessPodcast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
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
Auth::routes(['verify' => true]);
Route::get('/{id}', function ($id) {
    ProcessPodcast::dispatch($id)->delay(now()->addSeconds(1));
    // $response = Http::get('http://localhost/insert/6');
    return "done$id";
})->where('id', '[0-9]+');
Route::get('/insert/{id}', function ($id) {
    sleep(3);
    Redis::set('id', $id);
});

Route::get('/test', function () {
    return Redis::get('id');
})->where('test', '[A-Za-z]+');

Route::get('/home', 'HomeController@index')->name('home');
