<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 29.11.2016
 * Time: 14:26
 */

namespace Source\Controller;


use Respect\Validation\Validator;

class AuthController extends AbstractController
{

    /**
     * This is the index of the Login process,
     * which shows the Login form.
     */
    public function index($request, $response){
        return $this->ci->get('view')->render($response, 'logUserIn.twig');
    }


    /**
     * This function receives the data, typed in and submitted by the user
     * at the logUserIn.twig-view.
     */
    public function login($request, $response){
        $validation = $this->ci->get('validator')->validate($request, [
            'email' => Validator::noWhitespace()->notEmpty(),
            'password' => Validator::noWhitespace()->notEmpty(),
        ]);

        // if input is not complete -> redirect and show error messages
        if ($validation->failed()) {
            return $response->withRedirect($this->ci->get('router')->pathFor('logUserIn'));

        }

        // check if the user is in the database
        $verified = $this->ci->get('auth')->verify(
            $request->getParam('email'),
            $request->getParam('password')
        );
        if (!$verified) {
            $this->ci->get('flash')->addMessage('error-login', 'We couldn\'t log you in. Please check your input.');
            return $response->withRedirect($this->ci->get('router')->pathFor('logUserIn'));
        }
        return $response->withRedirect($this->ci->get('router')->pathFor('home'));
    }

    public function logout($request, $response){
        $this->ci->get('auth')->logout();
        return $response->withRedirect($this->ci->get('router')->pathFor('home'));
    }

}