<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/reportreason'], function (Router $router) {
    $router->bind('reportreasons', function ($id) {
        return app('Modules\ReportReason\Repositories\ReportReasonRepository')->find($id);
    });
    get('reportreasons', ['as' => 'admin.reportreason.reportreason.index', 'uses' => 'ReportReasonController@index']);
    get('reportreasons/create', ['as' => 'admin.reportreason.reportreason.create', 'uses' => 'ReportReasonController@create']);
    post('reportreasons', ['as' => 'admin.reportreason.reportreason.store', 'uses' => 'ReportReasonController@store']);
    get('reportreasons/{reportreasons}/edit', ['as' => 'admin.reportreason.reportreason.edit', 'uses' => 'ReportReasonController@edit']);
    put('reportreasons/{reportreasons}/edit', ['as' => 'admin.reportreason.reportreason.update', 'uses' => 'ReportReasonController@update']);
    delete('reportreasons/{reportreasons}', ['as' => 'admin.reportreason.reportreason.destroy', 'uses' => 'ReportReasonController@destroy']);
// append

});
