<?php

Route::post('/menus', 'MenuController@store');
Route::get('/menus/{id}', 'MenuController@show')->where('id', '\d+');
Route::put('/menus/{id}', 'MenuController@update')->where('id', '\d+');
Route::patch('/menus/{id}', 'MenuController@update')->where('id', '\d+');
Route::delete('/menus/{id}', 'MenuController@destroy')->where('id', '\d+');

Route::post('/menus/{id}/items', 'MenuItemController@store')->where('id', '\d+');
Route::get('/menus/{id}/items', 'MenuItemController@show')->where('id', '\d+');
Route::delete('/menus/{id}/items', 'MenuItemController@destroy')->where('id', '\d+');

Route::get('/menus/{id}/layers/{layer}', 'MenuLayerController@show')->where([
    'id' => '\d+',
    'layer' => '^[1-9]\d*$' // Layer 0 is invalid
]);
Route::delete('/menus/{id}/layers/{layer}', 'MenuLayerController@destroy')->where([
    'id' => '\d+',
    'layer' => '^[1-9]\d*$' // Layer 0 is invalid
]);

Route::get('/menus/{id}/depth', 'MenuDepthController@show')->where('id', '\d+');

Route::post('/items', 'ItemController@store');
Route::get('/items/{id}', 'ItemController@show')->where('id', '\d+');
Route::put('/items/{id}', 'ItemController@update')->where('id', '\d+');
Route::patch('/items/{id}', 'ItemController@update')->where('id', '\d+');
Route::delete('/items/{id}', 'ItemController@destroy')->where('id', '\d+');

Route::post('/items/{id}/children', 'ItemChildrenController@store')->where('id', '\d+');
Route::get('/items/{id}/children', 'ItemChildrenController@show')->where('id', '\d+');
Route::delete('/items/{item}/children', 'ItemChildrenController@destroy');
