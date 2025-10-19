<?php

use Illuminate\Support\Facades\Route;

Route::get('/qrCode', function () {
    return view('qrCode');
});