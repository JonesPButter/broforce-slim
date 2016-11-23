<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 22.11.2016
 * Time: 21:46
 */

namespace Source\Validation;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    protected $errors;

    public function validate($request, array $rules){
        // loop over rules and check if they are failing

        foreach($rules as $field => $rule){
            try {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch(NestedValidationException $e){
                $this->errors[$field] = $e->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;
        return $this;
    }

    public function failed(){
        return !empty($this->errors);
    }
}