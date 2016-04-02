<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 3:43 AM
 */

/* API Routes*/

Route::group(['prefix' => 'api/v1'], function(){

    Route::post('oauth/access_token', 'OAuthController@postAccessToken');

    Route::post('refresh-token', function() {
        return Response::json(Authorizer::issueAccessToken());
    });

    Route::post('register', ['uses'=>'app\API\Controllers\UserController@doRegister']);
    Route::post('forgetpass', ['uses'=>'app\API\Controllers\UserController@forgetPassword']);
    Route::get('activation/{key}', ['uses'=>'app\API\Controllers\UserController@activateUser']);

    Route::group(['before'=>'oauth'], function(){

        Route::get('logout', ['uses'=>'app\API\Controllers\UserController@logout']);
        Route::get('info', ['uses'=>'app\API\Controllers\UserController@userInfo']);

        Route::group(['prefix' => 'users'], function(){

            Route::get('/', ['uses'=>'app\API\Controllers\UserController@index']);
            Route::get('/{id}', ['uses'=>'app\API\Controllers\UserController@show']);

        });

    });

});