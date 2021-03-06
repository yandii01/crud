<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});


Route::resource('/karyawan', 'KaryawanController');
Route::get('/karyawan/getkota/{nama_provinsi}', 'KaryawanController@getKota');
Route::get('/karyawan/getkecamatan/{nama_city}', 'KaryawanController@getDistrict');
Route::get('karyawan/word-export/{id}', 'KaryawanController@wordExport');
