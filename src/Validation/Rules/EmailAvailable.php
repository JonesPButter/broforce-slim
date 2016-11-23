<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 23.11.2016
 * Time: 01:17
 */

namespace Source\Validation\Rules;
use Respect\Validation\Rules\AbstractRule;
use Source\Models\User;

class EmailAvailable extends AbstractRule
{
    public function validate($input)
    {
        return User::where('email', $input)->count() ===0;
    }

}