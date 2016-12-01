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
        return $this->ci->get('view')->render($response, 'home.twig');
    }
}