<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 17.12.2016
 * Time: 21:34
 */

namespace Source\Controller\Auth;


use Source\Controller\AbstractController;

class ChangeUsersDataController extends AbstractController
{
    public function getForm($request, $response){
        $userID = $request->getAttribute('route')->getArgument('id');
        $user = $this->ci->get('userDAO')->getUserByID($userID);
        return $this->ci->get('view')->render($response, 'changeUserData.twig', array("user" => $user));
    }

    public function changeData($request, $response){
        $userID = $request->getAttribute('route')->getArgument('id');
        $name = $request->getParam('name');
        $familyname = $request->getParam('familyName');
        $email = $request->getParam('email');

        $user = $this->ci->get('userDAO')->getUserByID($userID);
        $user->setName($name);
        $user->setFamilyname($familyname);

        // die Email wird nur geändert, wenn sie nicht leer ist, es sich nicht um die alte Email handelt und
        // es keinen anderen user mit derselben Email gibt.
        if ($email != '' && $email != $user->getEmail() && ($this->ci->get('userDAO')->getUserWithEmail($email) === 0)){
            $user->setEmail($email);
            $milliseconds = round(microtime(true) * 1000);
            $token = $this->ci->get('auth')->createToken() . "-". $milliseconds;
            $user->setToken($token);
            $user->setVerified(false);
            $url = $this->ci->get('router')->pathFor('verify',['userid'=>$userID, 'token'=>$token]);
            $this->ci->get('flash')->addMessage('info',
                'Please verify your new email address before your next login at https://broforce.informatik.haw-hamburg.de'. $url);
        }
        $user->setUpdatedAt(date('Y/m/d H:i:s'));
        $this->ci->get('userDAO')->updateUser($user);
        $this->ci->get('flash')->addMessage('info', 'The data was successfully updated');
        return $response->withRedirect($this->ci->get('router')->pathFor('usertable'));
    }
}