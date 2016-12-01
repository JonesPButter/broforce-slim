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
        return $this->ci->get('view')->render($response, 'changeData.twig');
    }

    public function changeData($request, $response){
        $name = $request->getParam('name');
        $familyname = $request->getParam('familyName');
        $email = $request->getParam('email');

        $user = $this->ci->get('userDAO')->getUserByID($_SESSION['user']);

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

        var_dump($this->ci->get('userDAO')->getUserByID($_SESSION['user']));
    }
}