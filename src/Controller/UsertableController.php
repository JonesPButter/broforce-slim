<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 01.12.2016
 * Time: 15:44
 */

namespace Source\Controller;


use Slim\Container;

class UsertableController extends AbstractController
{
    public function getTable($request,$response){
        return $this->ci->get('view')->render($response, 'usertable.twig');
    }

    public function deleteUser($request,$response){
        $userID = $request->getParam('id');
        $users = $this->ci->get('userDAO')->getTable();
        $newUsers = array();
        foreach ($users as $user) {
            $id = $user->getId();
            if ($id != $userID){
                $newUsers[] = $user;
            }
        }
        $this->ci->get('userDAO')->saveTable($newUsers);
        $this->ci->get('flash')->addMessage('info', 'User with ID "' . $userID . '" successfully deleted');
        return $response->withRedirect($this->ci->get('router')->pathFor('usertable'));
    }
}