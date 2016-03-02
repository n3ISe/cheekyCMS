<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/cuisinetype'], function (Router $router) {
    $router->bind('cuisinetypes', function ($id) {
        return app('Modules\CuisineType\Repositories\CuisineTypeRepository')->find($id);
    });
    get('cuisinetypes', ['as' => 'admin.cuisinetype.cuisinetype.index', 'uses' => 'CuisineTypeController@index']);
    get('cuisinetypes/create', ['as' => 'admin.cuisinetype.cuisinetype.create', 'uses' => 'CuisineTypeController@create']);
    post('cuisinetypes', ['as' => 'admin.cuisinetype.cuisinetype.store', 'uses' => 'CuisineTypeController@store']);
    get('cuisinetypes/{cuisinetypes}/edit', ['as' => 'admin.cuisinetype.cuisinetype.edit', 'uses' => 'CuisineTypeController@edit']);
    put('cuisinetypes/{cuisinetypes}/edit', ['as' => 'admin.cuisinetype.cuisinetype.update', 'uses' => 'CuisineTypeController@update']);
    delete('cuisinetypes/{cuisinetypes}', ['as' => 'admin.cuisinetype.cuisinetype.destroy', 'uses' => 'CuisineTypeController@destroy']);
// append

});
