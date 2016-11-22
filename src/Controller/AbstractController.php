<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 22.11.2016
 * Time: 00:07
 */

namespace Source\Controller;
use Slim\Container;

class AbstractController
{
    protected $ci;

    //Constructor
    public function __construct(Container $ci) {
        $this->ci = $ci;
    }
}