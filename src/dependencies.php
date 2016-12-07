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

/*
 * DIC configuration
 * this container handles the dependency injection and has therefore knowledge about all
 * dependencies in this project.
 */
$container = $app->getContainer();

/*
 * Monolog-Logger - A simple Logging - Framework. log messages will be written in /logs/app.log
 */
$container['logger'] = function ($container) {
    $settings = $container->get('settings')['logger'];
    $logger = new Logger($settings['name']);
    $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

/*
 * UserDAO - The DAO that handles the database requests.
 */
$container['userDAO'] = function ($container) {
    $settings = $container->get('settings');
    $userDAO = new UserDAO($container,$settings['userDbLocation']);
    return $userDAO;
};

/*
 * Our own Auth-Class. - Validates user and creates the Session if a user is valid.
 */
$container['auth'] = function($container){
    $auth = new Auth($container->get('userDAO'));
    return $auth;
};

/*
 * Twig-View - A Framework for creating the frontend
 */
$container['view'] = function($container){
    $settings = $container->get('settings')['renderer'];

    $view = new Twig( $settings['template_path'] , [
        'cache' => false,
    ]);

    $view->addExtension(new TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    // adding some Environment variables, so that we can assign them in the views.
    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->isUserLoggedIn(),
        'user' => $container->auth->getUser(),
    ]);
    $view->getEnvironment()->addGlobal('flash',$container->get('flash'));
    $view->getEnvironment()->addGlobal('userTable', $container->get('userDAO')->getTable());
    return $view;
};

/*
 * Flash - A Framework for showing the user flash-messages
 */
$container['flash'] = function () {
    return new Messages();
};

/*
 * Respect Validator - A Framework for validating the input in a form
 */
$container['validator'] = function(){
    return new Validator;
};

// making own rules for the Validator available
RespectValidator::with("Source\\Validation\\Rules\\");

/*
 * Symfony-Serializer - A JSON (De-)Serializer
 */
$container['serializer'] = function(){
    $encoders = array(new JsonEncoder());
    $normalizers = array(new GetSetMethodNormalizer(), new ArrayDenormalizer());
    return new Serializer($normalizers, $encoders);
};


// Add Middleware

// Middleware for making the Errors in forms available in the views
$app->add(new ValidationErrorsMiddleware($container));
// Middleware for making the old input values in forms available in views (after a reload)
$app->add(new OldInputMiddleware($container));

// more Middleware for grouped routes are added in the routes.php file.


