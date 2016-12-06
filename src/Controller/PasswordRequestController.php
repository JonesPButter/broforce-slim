<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 06.12.2016
 * Time: 09:31
 */

namespace Source\Controller;
use Respect\Validation\Validator;

class PasswordRequestController extends AbstractController
{

    public function getForm($request, $response){
        return $this->ci->get('view')->render($response, 'forgotPW.twig');
    }

    public function sendPassword($request, $response){
        $email = $request->getParam('email');
        // Validate form-input
        $validation = $this->ci->get('validator')->validate($request,[
            'email' => Validator::noWhitespace()->notEmpty()->email(),
        ]);

        if(!$validation->failed()){
            $user = $this->ci->get('userDAO')->getUserWithEmail($email);
            if($user){
                $newPassword = uniqid(rand());
                $user->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));
                $this->ci->get('userDAO')->updateUser($user);
                return $response->withRedirect($this->ci->get('router')->pathFor('showNewPW', ['pw'=>$newPassword]));
            } else{
                $this->ci->get('flash')->addMessage('error', 'The email adress is unknown.');
            }
        }
        return $response->withRedirect($this->ci->get('router')->pathfor('logUserIn'));
    }

    public function showNewPW($request, $response){
        $pw = $request->getAttribute('route')->getArgument('pw');
        return $this->ci->get('view')->render($response, 'showNewPassword.twig', array("pw" => $pw));
    }

}