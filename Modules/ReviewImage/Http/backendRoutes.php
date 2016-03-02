<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/reviewimage'], function (Router $router) {
    $router->bind('reviewimages', function ($id) {
        return app('Modules\ReviewImage\Repositories\ReviewImageRepository')->find($id);
    });
    get('reviewimages', ['as' => 'admin.reviewimage.reviewimage.index', 'uses' => 'ReviewImageController@index']);
    get('reviewimages/{restaurant}/image', ['as' => 'admin.reviewimage.reviewimage.image', 'uses' => 'ReviewImageController@image']);
    post('reviewimages/{restaurant}/simage', ['as' => 'admin.reviewimage.reviewimage.simage', 'uses' => 'ReviewImageController@simage']);
    get('reviewimages/create', ['as' => 'admin.reviewimage.reviewimage.create', 'uses' => 'ReviewImageController@create']);
    post('reviewimages', ['as' => 'admin.reviewimage.reviewimage.store', 'uses' => 'ReviewImageController@store']);
    get('reviewimages/{reviewimages}/edit', ['as' => 'admin.reviewimage.reviewimage.edit', 'uses' => 'ReviewImageController@edit']);
    put('reviewimages/{reviewimages}/edit', ['as' => 'admin.reviewimage.reviewimage.update', 'uses' => 'ReviewImageController@update']);
    delete('reviewimages/{reviewimages}', ['as' => 'admin.reviewimage.reviewimage.destroy', 'uses' => 'ReviewImageController@destroy']);
// append

});
