<?php

/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 21.11.2016
 * Time: 13:36
 *
 * description:
 */

namespace Source\Controller;
use Slim\Container;

class GreetingController
{
    private $ci;
    //Constructor
    public function __construct(Container $ci) {
        $this->ci = $ci;
    }

    public function greet($request, $response, $args) {
        $response->getBody()->write("Hello, World!");
    }

    public function greetWithName($request, $response, $args){
        // Sample log message
        $this->ci->get('logger')->info("Slim-Skeleton '/greeting/[{name}]' route");

        // hier könnte man den COntainer zum args array dazu geben, damit wir
        $routeURL =  $this->ci->get('router')->pathFor('greet');
        // Routen rauskriegen: https://stackoverflow.com/questions/40505551/how-to-access-all-routes-from-slim-3-php-framework/40528450
        // Render index view
        return $this->ci->get('renderer')->render($response, 'index.phtml', [
            'url' => $routeURL
        ]);
    }
}