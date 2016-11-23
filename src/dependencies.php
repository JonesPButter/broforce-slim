<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// add Twig-Views to the application
$container['view'] = function($c){
    $settings = $c->get('settings')['renderer'];

    $view = new \Slim\Views\Twig( $settings['template_path'] , [
        'cache' => false,
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $c->router,
        $c->request->getUri()
    ));
    return $view;
};

// Flash
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

// Repect Validator
$container['validator'] = function(){
    return new Source\Validation\Validator;
};

// Illuminate Database
$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule) {
    return $capsule;
};

// Add Middleware
$app->add(new Source\Middleware\ValidationErrorsMiddleware($container));
$app->add(new Source\Middleware\OldInputMiddleware($container));