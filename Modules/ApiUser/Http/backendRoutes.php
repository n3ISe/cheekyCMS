<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/apiuser'], function (Router $router) {
    $router->bind('apiusers', function ($id) {
        return app('Modules\ApiUser\Repositories\ApiUserRepository')->find($id);
    });
    get('apiusers', ['as' => 'admin.apiuser.apiuser.index', 'uses' => 'ApiUserController@index']);
    get('apiusers/create', ['as' => 'admin.apiuser.apiuser.create', 'uses' => 'ApiUserController@create']);
    post('apiusers', ['as' => 'admin.apiuser.apiuser.store', 'uses' => 'ApiUserController@store']);
    get('apiusers/{apiusers}/edit', ['as' => 'admin.apiuser.apiuser.edit', 'uses' => 'ApiUserController@edit']);
    put('apiusers/{apiusers}/edit', ['as' => 'admin.apiuser.apiuser.update', 'uses' => 'ApiUserController@update']);
    delete('apiusers/{apiusers}', ['as' => 'admin.apiuser.apiuser.destroy', 'uses' => 'ApiUserController@destroy']);
// append

});
