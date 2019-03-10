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
Route::get('getTopic','TweetsController@getTopic');
Route::post('display','TweetsController@display');
Route::get('index/{sentiment}/{topic}','TweetsController@index');
Route::get('live','TweetsController@live');


//==============<Requirements>=======================
// Use Symfony Process.
// composer require symfony/process



// pip install emoji
// pip install googletrans
// pip install py_translator
//import nltk
//nltk.download()
// pip install selenium
// download chrome driver: https://sites.google.com/a/chromium.org/chromedriver/downloads
// I ran into a similar issue where chromedriver was slow in some machines and it turned out to be a proxy issue. Disabling "Automatically detect settings" under Chrome://settings >Change proxy settings> LAN Settings> made webdriver execute commands faster in chrome for me.

//====================================

//===============<charts>===========================
// composer require consoletvs/charts:5.*
//link:  https://laravelcode.com/post/laravel-5-chart-example-using-charts-package

//===============</charts>===========================
