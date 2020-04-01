<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {

    //Client Token Authentication
    $api->group(['middleware' => ['verifyClientToken']], function(Router $api) {
        $api->group(['prefix' => 'auth'], function(Router $api) {
            $api->post('user', 'App\Http\Controllers\Api\V1\AuthController@login');
        });
    });

    //Api Key Check
    $api->group(['middleware' => ['verifyApiKey']], function(Router $api) {
        $api->get('authenticate', 'App\Http\Controllers\Api\V1\AuthController@clientAuthenticate');
    });

    //User Authenticated Area
    $api->group(['middleware' => ['verifyUserToken', 'auth:api']], function(Router $api) {
        $api->group(['prefix' => 'auth'], function(Router $api) {
            $api->get('me', 'App\Http\Controllers\Api\V1\AuthController@user');
        });
    });

    //Open Routes
    $api->group(['prefix' => 'backend'], function(Router $api) {
        //Permission
        $api->group(['prefix' => 'permission'], function(Router $api) {
            $api->get('roles/{permissionId}', 'App\Http\Controllers\Api\V1\PermissionController@viewPermissionGroups');
        });

        //Role
        $api->group(['prefix' => 'roles', 'middleware' => ['verifyUserToken', 'auth:api']], function(Router $api) {
            $api->post('create', 'App\Http\Controllers\Api\V1\RoleController@store');
            $api->post('fetch/list', 'App\Http\Controllers\Api\V1\RoleController@show');
        });

        //Client
        $api->group(['prefix' => 'client'], function(Router $api) {
            $api->post('create', 'App\Http\Controllers\Api\V1\ClientController@store');
        });

        //User
        $api->group(['prefix' => 'user'], function(Router $api) {
            $api->post('create', 'App\Http\Controllers\Api\V1\UserController@store');
        });
    });
});
