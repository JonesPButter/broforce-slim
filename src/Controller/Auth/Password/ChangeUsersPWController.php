<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 06.12.2016
 * Time: 08:58
 */

namespace Source\Controller\Auth\Password;
use Respect\Validation\Validator as Validator;
use Source\Controller\AbstractController;

class ChangeUsersPWController extends AbstractController
{

    public function getForm($request, $response){
        $userID = $request->getAttribute('route')->getArgument('id');
        return $this->ci->get('view')->render($response, 'changeUsersPW.twig', array("id" => $userID));
    }

    public function changePassword($request, $response){
        $userID = $request->getAttribute('route')->getArgument('id');
        // Validate form-input
        $validation = $this->ci->get('validator')->validate($request,[
            'admin_pw' => Validator::noWhitespace()->notEmpty(),
            'user_pw' => Validator::noWhitespace()->notEmpty()->passwordLength()->passwordLetter()->passwordNumber(),
        ]);

        if(!$validation->failed()){
            $admin = $this->ci->get('userDAO')->getUserByID($_SESSION['user']);
            $user = $this->ci->get('userDAO')->getUserByID($userID);
            if(password_verify($request->getParam('admin_pw'),$admin->getPassword())){
                $user->setPassword(password_hash($request->getParam('user_pw'), PASSWORD_DEFAULT));
                $this->ci->get('userDAO')->updateUser($user);
                $this->ci->get('flash')->addMessage('info', "The users password has been successfully changed.");
            }else{
                $this->ci->get('flash')->addMessage('error', "The Admin password wasn't correct.");
            }
        }
        return $response->withRedirect($this->ci->get('router')->pathfor('changeUsersPW', ['id'=>$userID]));
    }
}