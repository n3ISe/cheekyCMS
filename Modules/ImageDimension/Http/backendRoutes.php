<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/imagedimension'], function (Router $router) {
    $router->bind('imagedimensions', function ($id) {
        return app('Modules\ImageDimension\Repositories\ImageDimensionRepository')->find($id);
    });
    get('imagedimensions', ['as' => 'admin.imagedimension.imagedimension.index', 'uses' => 'ImageDimensionController@index']);
    get('imagedimensions/create', ['as' => 'admin.imagedimension.imagedimension.create', 'uses' => 'ImageDimensionController@create']);
    post('imagedimensions', ['as' => 'admin.imagedimension.imagedimension.store', 'uses' => 'ImageDimensionController@store']);
    get('imagedimensions/{imagedimensions}/edit', ['as' => 'admin.imagedimension.imagedimension.edit', 'uses' => 'ImageDimensionController@edit']);
    put('imagedimensions/{imagedimensions}/edit', ['as' => 'admin.imagedimension.imagedimension.update', 'uses' => 'ImageDimensionController@update']);
    delete('imagedimensions/{imagedimensions}', ['as' => 'admin.imagedimension.imagedimension.destroy', 'uses' => 'ImageDimensionController@destroy']);
// append

});
