<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 22.11.2016
 * Time: 00:06
 */

namespace Source\Controller;

class HomeController extends AbstractController
{
    public function index($request, $response, $args){

        //$response->getBody()->write("Hello, this is the HomeController speaking.");
        return $this->ci->get('view')->render($response, 'home.twig');
    }
}