<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    print_R(phpinfo());
    die;
    return view('welcome');
});
