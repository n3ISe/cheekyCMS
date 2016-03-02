<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/reportphoto'], function (Router $router) {
    $router->bind('reportphotos', function ($id) {
        return app('Modules\ReportPhoto\Repositories\ReportPhotoRepository')->find($id);
    });
    get('reportphotos', ['as' => 'admin.reportphoto.reportphoto.index', 'uses' => 'ReportPhotoController@index']);
    get('reportphotos/create', ['as' => 'admin.reportphoto.reportphoto.create', 'uses' => 'ReportPhotoController@create']);
    post('reportphotos', ['as' => 'admin.reportphoto.reportphoto.store', 'uses' => 'ReportPhotoController@store']);
    get('reportphotos/{reportphotos}/edit', ['as' => 'admin.reportphoto.reportphoto.edit', 'uses' => 'ReportPhotoController@edit']);
    put('reportphotos/{reportphotos}/edit', ['as' => 'admin.reportphoto.reportphoto.update', 'uses' => 'ReportPhotoController@update']);
    delete('reportphotos/{reportphotos}', ['as' => 'admin.reportphoto.reportphoto.destroy', 'uses' => 'ReportPhotoController@destroy']);
// append

});
