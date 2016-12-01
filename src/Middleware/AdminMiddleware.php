<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 01.12.2016
 * Time: 16:03
 */

namespace Source\Middleware;


class AdminMiddleware extends Middleware
{
    /*
     * Checks if a user is admin
     */
    public function __invoke($request, $response, $next){
        $user = $this->container->get('userDAO')->getUserByID($_SESSION['user']);
        if($user->getRole() != "admin"){
            return $response->withRedirect($this->container->get('router')->pathFor('home'));
        }
        $response = $next($request, $response);
        return $response;
    }
}