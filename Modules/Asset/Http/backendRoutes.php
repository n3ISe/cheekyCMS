<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/asset'], function (Router $router) {
    $router->bind('assets', function ($id) {
        return app('Modules\Asset\Repositories\AssetRepository')->find($id);
    });
    get('assets', ['as' => 'admin.asset.asset.index', 'uses' => 'AssetController@index']);
    get('assets/{restaurant}/iasset', ['as' => 'admin.asset.asset.iasset', 'uses' => 'AssetController@iasset']);
    post('assets/{restaurant}/sasset', ['as' => 'admin.asset.asset.sasset', 'uses' => 'AssetController@sasset']);
    get('assets/create', ['as' => 'admin.asset.asset.create', 'uses' => 'AssetController@create']);
    post('assets', ['as' => 'admin.asset.asset.store', 'uses' => 'AssetController@store']);
    get('assets/{assets}/edit', ['as' => 'admin.asset.asset.edit', 'uses' => 'AssetController@edit']);
    put('assets/{assets}/edit', ['as' => 'admin.asset.asset.update', 'uses' => 'AssetController@update']);
    delete('assets/{assets}', ['as' => 'admin.asset.asset.destroy', 'uses' => 'AssetController@destroy']);
// append

});
