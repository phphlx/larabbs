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
    $router->resource('versions', 'VersionController');
    // accounts 自定义路由必须放在 resource 之前，避免被当作 ID 参数
    $router->get('accounts/get-data', 'AccountController@getData')->name('accounts.get_data');
    $router->get('accounts/toggle_state/{id}', 'AccountController@toggleState')->name('accounts.toggle_state');
    $router->get('accounts/toggle_trend/{id}', 'AccountController@toggleTrend')->name('accounts.toggle_trend');
    $router->get('accounts/toggle_trade/{id}', 'AccountController@toggleTrade')->name('accounts.toggle_trade');
    $router->resource('accounts', 'AccountController')->except(['edit']);
    $router->resource('histories', 'HistoryController');
});

// API 路由组 - 用于外部调用，不需要 CSRF 和 Admin 认证
Route::group([
    'prefix'     => config('admin.route.prefix') . '/api',
    'namespace'  => config('admin.route.namespace'),
], function (Router $router) {
    $router->post('histories/create_update', 'HistoryController@createUpdate')->name('api.histories.create_update');
    $router->post('accounts/update_value', 'AccountController@updateValue')->name('api.accounts.update_value');
});
