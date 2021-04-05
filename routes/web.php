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

/* Maktab routers */
$router->get('/getids', 'AdminController@getIds');
$router->post('/usercreate', 'AdminController@usercreate');
$router->post('/photo', 'AdminController@photo');
$router->post('/useredit/{id}', 'AdminController@useredit');
$router->post('/userdelete/{id}', 'AdminController@userdelete');
$router->get('/getusers', 'AdminController@users');
$router->get('/getizoh', 'AdminController@getizoh');
$router->post('/izohcreate', 'AdminController@izohcreate');
$router->post('/izohedit/{id}', 'AdminController@izohedit');
$router->post('/izohdelete/{id}', 'AdminController@izohdelete');

$router->get('/getaparat', 'AdminController@getaparat');
$router->post('/aparatcreate', 'AdminController@aparatcreate');



$router->get('/getlogs', 'OtchotController@getlogs');
$router->post('/login', 'AdminController@login');
$router->post('/getlogsbydate', 'OtchotController@getLogsByDate');
$router->post('/getertabydate', 'OtchotController@getErtaByDate');
