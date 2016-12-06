<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 23.11.2016
 * Time: 01:22
 */

namespace Source\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class PasswordLetterException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Password must include at least one uppercase and one lowercase letter!',
        ],
    ];
}