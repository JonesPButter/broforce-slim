<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 21.11.2016
 * Time: 10:11
 *
 * description: This is where the initialization happens.
 *              A Slim App will be created, featuring dependencies, settings and routes.
 */

session_cache_limiter(false);
session_start();

// *********** Require Autoloading for making all classes available ***********
require __DIR__ . '/../vendor/autoload.php';

// *********** Instantiate the app ***********
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

$container = $app->getContainer();

// add Twig-Views to the application
$container['view'] = function($container){
    $view = new \Slim\Views\Twig( __DIR__ . '/../src/Views/' , [
        'cache' => false,
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};


// *********** Set up dependencies ***********
require __DIR__ . '/../src/dependencies.php';

// *********** Register middleware ***********
// require __DIR__ . '/../src/middleware.php'; // Not used right now

// *********** Register routes ***********
require __DIR__ . '/../src/routes.php';
