<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 24.11.2016
 * Time: 12:16
 */

namespace Source\Models\DAOs;
use Symfony\Component\Serializer\Serializer;

class AbstractDAO
{
    protected $serializer;
    protected $db_location;

    //Constructor
    public function __construct(Serializer $serializer, $db_location) {
        $this->serializer = $serializer;
        $this->db_location = $db_location;
    }
}