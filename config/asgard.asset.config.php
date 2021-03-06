<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Choose which filesystem you wish to use to store the media
    |--------------------------------------------------------------------------
    | Choose one or more of the filesystems you configured
    | in app/config/filesystems.php
    | Supported: "local", "s3"
    */
    'filesystem' => 's3',
    /*
    |--------------------------------------------------------------------------
    | The path where the media files will be uploaded
    |--------------------------------------------------------------------------
    */
    'files-path' => config('filesystems.disks.s3.url').'/restaurant_assets_v2/',
    /*
    |--------------------------------------------------------------------------
    | Specify all the allowed file extensions a user can upload on the server
    |--------------------------------------------------------------------------
    */
    'allowed-types' => '.jpg,.png,.gif',
    /*
    |--------------------------------------------------------------------------
    | Determine the max file size upload rate
    | Defined in MB
    |--------------------------------------------------------------------------
    */
    'max-file-size' => '5',

    /*
    |--------------------------------------------------------------------------
    | Determine the max total media folder size
    |--------------------------------------------------------------------------
    | Expressed in bytes
    */
    'max-total-size' => 1000000000,
];
