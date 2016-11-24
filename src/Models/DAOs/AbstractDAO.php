<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 24.11.2016
 * Time: 12:16
 */

namespace Source\Models\DAOs;
use Slim\Container;

class AbstractDAO
{
    protected $container;
    protected $db_location;

    //Constructor
    public function __construct(Container $container, $db_location) {
        $this->container = $container;
        $this->db_location = $db_location;
    }
}