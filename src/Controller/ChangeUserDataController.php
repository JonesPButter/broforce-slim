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

    }
}