<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/location'], function (Router $router) {
    $router->bind('locations', function ($id) {
        return app('Modules\Location\Repositories\LocationRepository')->find($id);
    });
    get('locations', ['as' => 'admin.location.location.index', 'uses' => 'LocationController@index']);
    get('locations/create', ['as' => 'admin.location.location.create', 'uses' => 'LocationController@create']);
    post('locations', ['as' => 'admin.location.location.store', 'uses' => 'LocationController@store']);
    get('locations/{locations}/edit', ['as' => 'admin.location.location.edit', 'uses' => 'LocationController@edit']);
    put('locations/{locations}/edit', ['as' => 'admin.location.location.update', 'uses' => 'LocationController@update']);
    delete('locations/{locations}', ['as' => 'admin.location.location.destroy', 'uses' => 'LocationController@destroy']);
// append

});
