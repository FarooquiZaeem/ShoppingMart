<?php

Route::get('/{url}', function() {
    return view('vue_app');
})->where('url', '.*');
