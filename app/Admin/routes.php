<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

//    $router->get('home', 'HomeController@index');
    $router->get('/', 'UserController@index');
    $router->resource('users', 'UserController')->only(['index', 'create', 'store', 'edit', 'update']);
    $router->resource('permissions', 'PermissionController')->except(['show']);
    $router->resource('records', 'RecordController')->only(['index']);
    $router->resource('salespeople', 'SalespersonController')->except('show');
    $router->resource('quns', 'QunController');
    $router->resource('videos', 'VideoController');
    $router->resource('articles', 'ArticleController');
    $router->resource('configs', 'ConfigController');
});
