<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/feedback'], function (Router $router) {
    $router->bind('feedbacks', function ($id) {
        return app('Modules\Feedback\Repositories\FeedbackRepository')->find($id);
    });
    get('feedbacks', ['as' => 'admin.feedback.feedback.index', 'uses' => 'FeedbackController@index']);
    get('feedbacks/create', ['as' => 'admin.feedback.feedback.create', 'uses' => 'FeedbackController@create']);
    post('feedbacks', ['as' => 'admin.feedback.feedback.store', 'uses' => 'FeedbackController@store']);
    get('feedbacks/{feedbacks}/edit', ['as' => 'admin.feedback.feedback.edit', 'uses' => 'FeedbackController@edit']);
    put('feedbacks/{feedbacks}/edit', ['as' => 'admin.feedback.feedback.update', 'uses' => 'FeedbackController@update']);
    delete('feedbacks/{feedbacks}', ['as' => 'admin.feedback.feedback.destroy', 'uses' => 'FeedbackController@destroy']);
// append

});
