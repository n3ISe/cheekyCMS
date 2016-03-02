<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/review'], function (Router $router) {
    $router->bind('reviews', function ($id) {
        return app('Modules\Review\Repositories\ReviewRepository')->find($id);
    });
    get('reviews', ['as' => 'admin.review.review.index', 'uses' => 'ReviewController@index']);
    get('reviews/{restaurant}/ireview', ['as' => 'admin.review.review.ireview', 'uses' => 'ReviewController@ireview']);
    get('reviews/create', ['as' => 'admin.review.review.create', 'uses' => 'ReviewController@create']);
    post('reviews', ['as' => 'admin.review.review.store', 'uses' => 'ReviewController@store']);
    get('reviews/{reviews}/edit', ['as' => 'admin.review.review.edit', 'uses' => 'ReviewController@edit']);
    put('reviews/{reviews}/edit', ['as' => 'admin.review.review.update', 'uses' => 'ReviewController@update']);
    delete('reviews/{reviews}', ['as' => 'admin.review.review.destroy', 'uses' => 'ReviewController@destroy']);
    get('reviews/{reviews}', ['as' => 'admin.review.review.show', 'uses' => 'ReviewController@show']);
// append

});
