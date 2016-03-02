<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/category'], function (Router $router) {
    $router->bind('categories', function ($id) {
        return app('Modules\Category\Repositories\CategoryRepository')->find($id);
    });
    get('categories', ['as' => 'admin.category.category.index', 'uses' => 'CategoryController@index']);
    get('categories/create', ['as' => 'admin.category.category.create', 'uses' => 'CategoryController@create']);
    post('categories', ['as' => 'admin.category.category.store', 'uses' => 'CategoryController@store']);
    get('categories/{categories}/edit', ['as' => 'admin.category.category.edit', 'uses' => 'CategoryController@edit']);
    put('categories/{categories}/edit', ['as' => 'admin.category.category.update', 'uses' => 'CategoryController@update']);
    delete('categories/{categories}', ['as' => 'admin.category.category.destroy', 'uses' => 'CategoryController@destroy']);
// append

});
