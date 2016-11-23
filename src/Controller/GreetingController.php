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
}