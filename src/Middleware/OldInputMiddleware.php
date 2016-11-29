<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 23.11.2016
 * Time: 00:11
 */

namespace Source\Middleware;


class OldInputMiddleware extends Middleware
{
    public function __invoke($request, $response, $next){

        if(isset($_SESSION['old'])){
            $this->container->get('view')->getEnvironment()->addGlobal('old', $_SESSION['old']);
        }
        $_SESSION['old'] = $request ->getParams();

        $response = $next($request, $response);
        return $response;
    }
}