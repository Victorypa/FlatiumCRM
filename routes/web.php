<?php
// Route::get('{path}', function () {
//     return view('welcome');
// })->where( 'path', '([A-z\d-\/_.]+)?' );

Route::get('/', function () {
    return view('welcome');
});
