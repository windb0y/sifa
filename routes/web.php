<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    //return $router->app->version();
    return ('/api/documentation');
});

$router->get('cekdatas', 'DataController@index');
$router->post('cekdatas/store', 'DataController@store');
$router->get('cekdatas/insert', 'DataController@insert');

$router->get('ruangan', 'RuanganController@index');
$router->get('ruangan/{id}', 'RuanganController@show');
$router->post('ruangan', 'RuanganController@store');
$router->put('ruangan/{id}', 'RuanganController@update');

$router->get('gedung', 'BuildingController@index');
$router->get('gedung/{id}', 'BuildingController@show');
$router->post('gedung', 'BuildingController@store');
$router->put('gedung/{id}', 'BuildingController@update');

$router->get('perangkat', 'PerangkatController@index');
$router->get('perangkat/{id}', 'PerangkatController@show');
$router->post('perangkat', 'PerangkatController@store');
$router->put('perangkat/{id}', 'PerangkatController@update');

$router->get('notifikasi/insert', 'NotifikasiController@insert');
$router->get('notifikasi', 'NotifikasiController@index');
$router->get('notifikasi/{id}', 'NotifikasiController@show');
$router->post('notifikasi', 'NotifikasiController@store');

$router->get('evakuasi', 'EvakuasiController@index');
$router->get('evakuasi/{ruangan_id}', 'EvakuasiController@show');
$router->post('evakuasi', 'EvakuasiController@store');
$router->put('evakuasi/{id}', 'EvakuasiController@update');

