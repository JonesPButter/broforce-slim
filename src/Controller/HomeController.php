<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 22.11.2016
 * Time: 00:06
 */

namespace Source\Controller;
use Source\Models\User;

class HomeController extends AbstractController
{
    public function index($request, $response, $args){

        //$user = User::where('email', 'broman@broforce.de')->first();
        //var_dump($user->password);

        //$response->getBody()->write("Hello, this is the HomeController speaking.");
        return $this->ci->get('view')->render($response, 'home.twig');
    }
}