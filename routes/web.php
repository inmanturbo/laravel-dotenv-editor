<?php

/**
 * Created by PhpStorm.
 * User: Fabian
 * Date: 19.07.16
 * Time: 06:04
 */
if (config('dotenveditor.activated')) {
    Route::group(
        config('dotenveditor.route'),
        function () {
            Route::get('/', 'EnvController@overview')->name('index');
            Route::post('/add', 'EnvController@add')->name('add');
            Route::post('/update', 'EnvController@update')->name('update');
            Route::get('/createbackup', 'EnvController@createBackup')->name('createbackup');
            Route::get('/deletebackup/{timestamp}', 'EnvController@deleteBackup')->name('deletebackup');
            Route::get('/restore/{backuptimestamp}', 'EnvController@restore')->name('restore');
            Route::post('/delete', 'EnvController@delete')->name('delete');
            Route::get('/download/{filename?}', 'EnvController@download')->name('download');
            Route::post('/upload', 'EnvController@upload')->name('upload');
            Route::get('/getdetails/{timestamp?}', 'EnvController@getDetails')->name('getdetails');
        }
    );
}

if (config('setupeditor.activated')) {
    Route::group(
        config('setupeditor.route'),
        function () {
            Route::get('/', 'SetupController@overview')->name('index');
            Route::post('/add', 'SetupController@add')->name('add');
            Route::post('/update', 'SetupController@update')->name('update');
            Route::get('/createbackup', 'SetupController@createBackup')->name('createbackup');
            Route::get('/deletebackup/{timestamp}', 'SetupController@deleteBackup')->name('deletebackup');
            Route::get('/restore/{backuptimestamp}', 'SetupController@restore')->name('restore');
            Route::post('/delete', 'SetupController@delete')->name('delete');
            Route::get('/download/{filename?}', 'SetupController@download')->name('download');
            Route::post('/upload', 'SetupController@upload')->name('upload');
            Route::get('/getdetails/{timestamp?}', 'SetupController@getDetails')->name('getdetails');
        }
    );
}
