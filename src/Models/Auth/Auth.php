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

        if(password_verify($password,$user->getPassword())&& $user->getVerified()){
            $_SESSION['user'] = $user->getId();
            return true;
        }
        return false;
    }

    public function isUserLoggedIn(){
        return isset($_SESSION['user']);
    }

    public function getUser(){
        if(isset($_SESSION['user'])){
            return $this->userDAO->getUserByID($_SESSION['user']);
        }
    }

    public function logout(){
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }
    }

    public function createTOKEN(){
        return bin2hex(openssl_random_pseudo_bytes(16));
    }
}