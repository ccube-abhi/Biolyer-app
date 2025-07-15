<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use Illuminate\Support\Facades\Redis;

Route::get('/redis-test', function () {
    Redis::set('name', 'Abhishek');

    return Redis::get('name'); // Should return "Abhishek"
});
