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


class GreetingController extends AbstractController
{
    public function greet($request, $response, $args) {
        $response->getBody()->write("Hello, World!");
    }

    /*
     * Um die funktion wieder verwenden zu können muss slim/php-view wieder required werden
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
    */
}