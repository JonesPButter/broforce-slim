<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 23.11.2016
 * Time: 00:11
 */

namespace Source\Middleware;

/**
 * Class ValidationErrorsMiddleware
 * @package Source\Middleware
 *
 * Description:
 * The purpose of this middleware is to add errors which are saved in the SESSION-Variable
 * to the views environment.
 *
 * After that, the errors will be removed from the Session-Variable.
 */
class ValidationErrorsMiddleware extends Middleware
{
    public function __invoke($request, $response, $next){

        if(isset($_SESSION['errors'])){
            $this->container->get('view')->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
            unset($_SESSION['errors']);
        }
        $response = $next($request, $response);
        return $response;
    }
}