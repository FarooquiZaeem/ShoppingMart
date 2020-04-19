<?php

Route::post('login', 'LoginController@login');
Route::post('admin/register', 'AdminController@register');
Route::post('customer/register', 'CustomerController@register');

Route::middleware('auth:api')->group(function() {
    Route::get('products', 'ProductController@productList');
    Route::get('logout', 'LoginController@logout');
    Route::middleware('is.admin')->group(function() {
        Route::post('products', 'ProductController@storeProduct');
        Route::post('products/{id}/update', 'ProductController@updateProduct');
        Route::get('products/{id}/delete', 'ProductController@deleteProduct');
        Route::get('products/{id}/disable', 'ProductController@toggleDisable');
    });
});
