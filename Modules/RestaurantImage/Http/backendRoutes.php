<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/restaurantimage'], function (Router $router) {
    $router->bind('restaurantimages', function ($id) {
        return app('Modules\RestaurantImage\Repositories\RestaurantImageRepository')->find($id);
    });
    get('restaurantimages', ['as' => 'admin.restaurantimage.restaurantimage.index', 'uses' => 'RestaurantImageController@index']);
    get('restaurantimages/{restaurant}/image', ['as' => 'admin.restaurantimage.restaurantimage.image', 'uses' => 'RestaurantImageController@image']);
    post('restaurantimage/{restaurant}/simage', ['as' => 'admin.restaurantimage.restaurantimage.simage', 'uses' => 'RestaurantImageController@simage']);
    get('restaurantimages/create', ['as' => 'admin.restaurantimage.restaurantimage.create', 'uses' => 'RestaurantImageController@create']);
    post('restaurantimages', ['as' => 'admin.restaurantimage.restaurantimage.store', 'uses' => 'RestaurantImageController@store']);
    get('restaurantimages/{restaurantimages}/edit', ['as' => 'admin.restaurantimage.restaurantimage.edit', 'uses' => 'RestaurantImageController@edit']);
    put('restaurantimages/{restaurantimages}/edit', ['as' => 'admin.restaurantimage.restaurantimage.update', 'uses' => 'RestaurantImageController@update']);
    delete('restaurantimages/{restaurantimages}', ['as' => 'admin.restaurantimage.restaurantimage.destroy', 'uses' => 'RestaurantImageController@destroy']);
// append

});
