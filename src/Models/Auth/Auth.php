<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 29.11.2016
 * Time: 14:00
 */

namespace Source\Models\Auth;


use Source\Models\DAOs\UserDAO;

class Auth
{

    protected $userDAO;

    //Constructor
    public function __construct(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }

    public function verify($email, $password){
        $user = $this->userDAO->getUserWithEmail($email);
        if(!$user){
            return false;
        }

        if(password_verify($password,$user->getPassword())){
            $_SESSION['user'] = $user->getId();
            return true;
        }
    }
}