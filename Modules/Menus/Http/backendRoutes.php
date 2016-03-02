<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/menus'], function (Router $router) {
    $router->bind('menuses', function ($id) {
        return app('Modules\Menus\Repositories\MenusRepository')->find($id);
    });
    get('menuses', ['as' => 'admin.menus.menus.index', 'uses' => 'MenusController@index']);
    get('menuses/{restaurant}/imenu', ['as' => 'admin.menus.menus.imenu', 'uses' => 'MenusController@imenu']);
    post('menuses/{restaurant}/smenu', ['as' => 'admin.menus.menus.smenu', 'uses' => 'MenusController@smenu']);
    get('menuses/create', ['as' => 'admin.menus.menus.create', 'uses' => 'MenusController@create']);
    post('menuses', ['as' => 'admin.menus.menus.store', 'uses' => 'MenusController@store']);
    get('menuses/{menuses}/edit', ['as' => 'admin.menus.menus.edit', 'uses' => 'MenusController@edit']);
    put('menuses/{menuses}/edit', ['as' => 'admin.menus.menus.update', 'uses' => 'MenusController@update']);
    delete('menuses/{menuses}', ['as' => 'admin.menus.menus.destroy', 'uses' => 'MenusController@destroy']);
// append

});
