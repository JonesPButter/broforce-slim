<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'userDbLocation' => __DIR__ . "/../database/user-db.json",
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../src/Views/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' =>__DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'broforce',
            'username' => 'root',
            'password' => 'start123',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]
    ],
];
