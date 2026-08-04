<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    return response()->file(public_path('site.html'));
});
