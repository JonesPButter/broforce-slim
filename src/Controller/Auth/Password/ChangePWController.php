<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 30.11.2016
 * Time: 17:51
 */

namespace Source\Controller\Auth\Password;
use Respect\Validation\Validator as Validator;
use Source\Controller\AbstractController;

class ChangePWController extends AbstractController
{

    public function getForm($request, $response){
        return $this->ci->get('view')->render($response, 'changePassword.twig');
    }

    public function changePassword($request, $response){
        $userID = $_SESSION['user'];
        // Validate form-input
        $validation = $this->ci->get('validator')->validate($request,[
            'password_old' => Validator::noWhitespace()->notEmpty(),
            'password_new' => Validator::noWhitespace()->notEmpty()->passwordLength()->passwordLetter()->passwordNumber(),
        ]);

        if(!$validation->failed()){
            $user = $this->ci->get('userDAO')->getUserByID($userID);
            if(password_verify($request->getParam('password_old'),$user->getPassword())){
                $user->setPassword(password_hash($request->getParam('password_new'), PASSWORD_DEFAULT));
                $this->ci->get('userDAO')->updateUser($user);
                $this->ci->get('flash')->addMessage('info', "Your password has been successfully changed.");
            }else{
                $this->ci->get('flash')->addMessage('error', "Your old password wasn't correct.");
            }
        }
        return $response->withRedirect($this->ci->get('router')->pathfor('changePW'));
    }
}