<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 29.11.2016
 * Time: 15:06
 */

namespace Source\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class usernameAvailableException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Username is already taken.',
        ],
    ];
}