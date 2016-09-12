<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('login', function(Request $req) {

    if ($_POST['password'] == env('WEB_PASS')) {
        $req->session()->put('login', true);
        return redirect('order');
    } else {
        return redirect('/');
    }
});

Route::get('logout', function(Request $req) {
    $req->session()->forget('login');
    return redirect('/');
});

Route::get('changeEnv', function(Request $req) {
    $env = $req->input('env', 'dev');
    return response('OK')->cookie('env', $env);
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('order', 'OrderController@list');
    Route::get('orderLog', 'OrderController@log');
});

