<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 01.12.2016
 * Time: 16:57
 */

namespace Source\Middleware;


class AuthorizedMiddleware extends Middleware
{
    /*
     * Checks if the user is logged in
     */
    public function __invoke($request, $response, $next){

        if(!isset($_SESSION['user'])){
            return $response->withRedirect($this->container->get('router')->pathFor('logUserIn'));
        }
        $response = $next($request, $response);
        return $response;
    }
}