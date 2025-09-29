<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    'cloud' => env('FILESYSTEM_CLOUD', 'r2'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'visibility' => 'public',
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

        'r2' => [
            'driver' => 's3',
            'key' => env('R2_ACCESS_KEY_ID',"29a0f4eaaba76cd5851a8ff09b8741e1"),
            'secret' => env('R2_SECRET_ACCESS_KEY',"815b485a5926851009e3657461fc06ece74c45a8f6f24e7eb1ee95cb3cbd8b7c"),
            'region' => env('R2_REGION', 'auto'),
            'bucket' => env('R2_BUCKET',"jptbd-bucket"),
            'endpoint' => env('R2_ENDPOINT',"https://a05c9807a71d5df599e7a3a4742d1e24.r2.cloudflarestorage.com"),
            'use_path_style_endpoint' => true,
            'url' => 'https://media.kaicombd.com',
        ],

        // 'r2' => [
        //     'driver' => 's3',
        //     'key' => env('R2_ACCESS_KEY_ID'),
        //     'secret' => env('R2_SECRET_ACCESS_KEY'),
        //     'region' => env('R2_REGION', 'auto'),
        //     'bucket' => env('R2_BUCKET'),
        //     'endpoint' => env('R2_ENDPOINT'),
        //     'use_path_style_endpoint' => true,
        // ],


    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
