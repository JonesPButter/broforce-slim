<?php
/**
 * Created by PhpStorm.
 * User: ralf
 * Date: 01.12.16
 * Time: 13:55
 */

namespace Source\Controller;


class ChangeUserDataController extends AbstractController
{
    public function getForm($request, $response){
        $userID = $request->getAttribute('route')->getArgument('id');
        $user = $this->ci->get('userDAO')->getUserByID($userID);
        return $this->ci->get('view')->render($response, 'changeData.twig', array("user" => $user));
    }

    public function changeData($request, $response){
        $userID = $request->getAttribute('route')->getArgument('id');

        $name = $request->getParam('name');
        $familyname = $request->getParam('familyName');
        $email = $request->getParam('email');

        $user = $this->ci->get('userDAO')->getUserByID($userID);

        if ($name != ''){
            $user->setName($name);
        }
        if ($familyname != ''){
            $user->setFamilyname($familyname);
        }
        if ($email != ''){
            $user->setEmail($email);
        }

        $user->setUpdatedAt(date('Y/m/d H:i:s'));

        $this->ci->get('userDAO')->updateUser($user);
        $this->ci->get('flash')->addMessage('info', 'The data was successfully updated');
        return $response->withRedirect($this->ci->get('router')->pathFor('usertable'));
    }
}