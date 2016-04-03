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

    Route::post('register', ['uses'=>'API\UserController@doRegister']);
    Route::post('forgetpass', ['uses'=>'API\UserController@forgetPassword']);
    Route::get('activation/{key}', ['uses'=>'API\UserController@activateUser']);

    Route::group(['middleware'=>'oauth'], function(){

        Route::get('logout', ['uses'=>'API\UserController@logout']);
        Route::get('info', ['uses'=>'API\UserController@userInfo']);

        Route::group(['prefix' => 'users'], function(){

            Route::get('/', ['uses'=>'API\UserController@index']);
            Route::get('/{id}', ['uses'=>'API\UserController@show']);

        });

    });

});