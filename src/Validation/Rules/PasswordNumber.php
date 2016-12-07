<?php
/**
 * Created by PhpStorm.
 * User: ralf
 * Date: 06.12.16
 * Time: 12:52
 */

namespace Source\Validation\Rules;
use Respect\Validation\Rules\AbstractRule;

class PasswordNumber extends AbstractRule
{
    public function validate($input){
        return preg_match("#[0-9]+#", $input);
    }
}