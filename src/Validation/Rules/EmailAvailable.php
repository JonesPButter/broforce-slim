<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 23.11.2016
 * Time: 01:17
 */

namespace Source\Validation\Rules;
use Respect\Validation\Rules\AbstractRule;
use Source\Models\DAOs\UserDAO;

class EmailAvailable extends AbstractRule
{
    private $dao;

    public function __construct(UserDAO $dao){
        $this->dao = $dao;
    }

    public function validate($input){
        return $this->dao->getUserWithEmail($input) === 0;
    }

}