<?php
// "use"-imports for better readability
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Respect\Validation\Validator as RespectValidator;
use Slim\Flash\Messages;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Source\Middleware\OldInputMiddleware;
use Source\Middleware\ValidationErrorsMiddleware;
use Source\Models\Auth\Auth;
use Source\Models\DAOs\UserDAO;
use Source\Validation\Validator;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

// DIC configuration

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Logger($settings['name']);
    $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// userDAO
$container['userDAO'] = function ($c) {
    $settings = $c->get('settings');
    $userDAO = new UserDAO($c,$settings['userDbLocation']);
    return $userDAO;
};

// Auth-class
$container['auth'] = function($c){
    $auth = new Auth($c->get('userDAO'));
    return $auth;
};

// add Twig-Views to the application
$container['view'] = function($c){
    $settings = $c->get('settings')['renderer'];

    $view = new Twig( $settings['template_path'] , [
        'cache' => false,
    ]);

    $view->addExtension(new TwigExtension(
        $c->router,
        $c->request->getUri()
    ));

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $c->auth->isUserLoggedIn(),
        'user' => $c->auth->getUser(),
    ]);

    $view->getEnvironment()->addGlobal('flash',$c->get('flash'));
    return $view;
};

// Flash
$container['flash'] = function () {
    return new Messages();
};

// Repect Validator
$container['validator'] = function(){
    return new Validator;
};

$container['serializer'] = function(){
    $encoders = array(new JsonEncoder());
    $normalizers = array(new GetSetMethodNormalizer(), new ArrayDenormalizer());
    return new Serializer($normalizers, $encoders);
};


// Add Middleware
$app->add(new ValidationErrorsMiddleware($container));
$app->add(new OldInputMiddleware($container));

RespectValidator::with("Source\\Validation\\Rules\\");
