<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 20.12.2016
 * Time: 11:00
 */

namespace Source\Middleware;


class ClientCertificateMiddleware extends Middleware
{
    /*
     * Checks if the client has a valid certificate
     */
    public function __invoke($request, $response, $next){
        if($this->hasValidCert()){
            $email = $_SERVER['SSL_CLIENT_S_DN_Email'];
            $user = $this->container->get('userDAO')->getUserWithEmail($email);
            // user nicht vorhanden
            if($user === 0){
                return $response->withRedirect($this->container->get('router')->pathFor('home'));
            }
        } else{
            return $response->withRedirect($this->container->get('router')->pathFor('home'));
        }
        $response = $next($request, $response);
        return $response;
    }

    /**
     * Determines if the browser provided a valid SSL client certificate
     *
     * @return boolean True if the client cert is there and is valid
     */
    public function hasValidCert()
    {
        if (!isset($_SERVER['SSL_CLIENT_VERIFY'])
            || $_SERVER['SSL_CLIENT_VERIFY'] !== 'SUCCESS'
            || !isset($_SERVER['SSL_CLIENT_S_DN_Email'])
        ) {
            return false;
        }

        if ($_SERVER['SSL_CLIENT_V_REMAIN'] <= 0) {
            return false;
        }
        return true;
    }
}