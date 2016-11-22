<?php
namespace Source\Controller;


class RegistrationController extends AbstractController
{

    public function index($request, $response, $args){
        //$response->getBody()->write("Registration-View in progress...");
        return $this->ci->get('view')->render($response, 'signin.twig');
    }
}