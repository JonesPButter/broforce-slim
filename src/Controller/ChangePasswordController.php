<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 30.11.2016
 * Time: 17:51
 */

namespace Source\Controller;


class ChangePasswordController extends AbstractController
{

    public function getForm($request, $response){
        return $this->ci->get('view')->render($response, 'changePassword.twig');
    }

    public function changePassword($request, $response){
        $password_old = $request->getParam('password_old');
        $password_new = $request->getParam('password_new');

        $user = $this->ci->get('userDAO')->getUserByID($_SESSION['user']);
        if(password_verify($password_old,$user->getPassword())){
            $user->setPassword(password_hash($password_new, PASSWORD_DEFAULT));
            $this->ci->get('userDAO')->updateUser($user);
            $this->ci->get('flash')->addMessage('info', "Your password has been successfully changed.");
        }else{
            $this->ci->get('flash')->addMessage('error', "Your old password wasn't correct.");
        }
        return $response->withRedirect($this->ci->get('router')->pathfor('changePW'));
    }
}