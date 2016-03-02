<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/restaurant'], function (Router $router) {
    $router->bind('restaurants', function ($id) {
        return app('Modules\Restaurant\Repositories\RestaurantRepository')->find($id);
    });
    get('restaurants', ['as' => 'admin.restaurant.restaurant.index', 'uses' => 'RestaurantController@index']);
    get('restaurants/create', ['as' => 'admin.restaurant.restaurant.create', 'uses' => 'RestaurantController@create']);
    post('restaurants', ['as' => 'admin.restaurant.restaurant.store', 'uses' => 'RestaurantController@store']);
    get('restaurants/{restaurant}/edit', ['as' => 'admin.restaurant.restaurant.edit', 'uses' => 'RestaurantController@edit']);
    put('restaurants/{restaurant}/edit', ['as' => 'admin.restaurant.restaurant.update', 'uses' => 'RestaurantController@update']);
    delete('restaurants/{restaurant}', ['as' => 'admin.restaurant.restaurant.destroy', 'uses' => 'RestaurantController@destroy']);
    
// append

});
