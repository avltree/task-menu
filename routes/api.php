<?php

Route::post('/menus', 'MenuController@store');
Route::get('/menus/{id}', 'MenuController@show')->where('id', '\d+');
Route::put('/menus/{id}', 'MenuController@update')->where('id', '\d+');
Route::patch('/menus/{id}', 'MenuController@update')->where('id', '\d+');
Route::delete('/menus/{id}', 'MenuController@destroy')->where('id', '\d+');

Route::post('/menus/{id}/items', 'MenuItemController@store')->where('id', '\d+');
Route::get('/menus/{id}/items', 'MenuItemController@show')->where('id', '\d+');
Route::delete('/menus/{id}/items', 'MenuItemController@destroy')->where('id', '\d+');

Route::get('/menus/{menu}/layers/{layer}', 'MenuLayerController@show');
Route::delete('/menus/{menu}/layers/{layer}', 'MenuLayerController@destroy');

Route::get('/menus/{menu}/depth', 'MenuDepthControlles@show');

Route::post('/items', 'ItemController@store');
Route::get('/items/{id}', 'ItemController@show')->where('id', '\d+');
Route::put('/items/{item}', 'ItemController@update');
Route::patch('/items/{item}', 'ItemController@update');
Route::delete('/items/{item}', 'ItemController@destroy');

Route::post('/items/{item}/children', 'ItemChildrenController@store');
Route::get('/items/{item}/children', 'ItemChildrenController@show');
Route::delete('/items/{item}/children', 'ItemChildrenController@destroy');
