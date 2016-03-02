<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/tag'], function (Router $router) {
    $router->bind('tags', function ($id) {
        return app('Modules\Tag\Repositories\TagRepository')->find($id);
    });
    get('tags', ['as' => 'admin.tag.tag.index', 'uses' => 'TagController@index']);
    get('tags/create', ['as' => 'admin.tag.tag.create', 'uses' => 'TagController@create']);
    post('tags', ['as' => 'admin.tag.tag.store', 'uses' => 'TagController@store']);
    get('tags/{tags}/edit', ['as' => 'admin.tag.tag.edit', 'uses' => 'TagController@edit']);
    put('tags/{tags}/edit', ['as' => 'admin.tag.tag.update', 'uses' => 'TagController@update']);
    delete('tags/{tags}', ['as' => 'admin.tag.tag.destroy', 'uses' => 'TagController@destroy']);
// append

});
