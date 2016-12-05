<?php
namespace Source\Controller;

use Respect\Validation\Validator as Validator;

class RegistrationController extends AbstractController
{

    /**
     * This is the index of the registration process,
     * which shows the registration form.
     */
    public function getRegistration($request, $response)
    {
        return $this->ci->get('view')->render($response, 'register.twig');
    }

    /**
     * This function receives the data, typed in and submitted by the user
     * at the register.twig-view.
     */
    public function postRegistration($request, $response)
    {
        $validation = $this->ci->get('validator')->validate($request, [
            'email' => Validator::noWhitespace()->notEmpty()->email()->emailAvailable($this->ci->get('userDAO')),
            'username' => Validator::noWhitespace()->notEmpty()->alpha()->usernameAvailable($this->ci->get('userDAO')),
            'password' => Validator::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()) {
            return $response->withRedirect($this->ci->get('router')->pathFor('register'));
        } else {
            $milliseconds = round(microtime(true) * 1000);
            $token = $this->ci->get('auth')->createToken() . "-". $milliseconds;

            $user = $this->ci->get('userDAO')->create($request->getParam('username'), $request->getParam('email'),
                password_hash($request->getParam('password'), PASSWORD_DEFAULT), $token);

            $userId = $user->getId();
            $url = $this->ci->get('router')->pathFor('verify',['userid'=>$userId, 'token'=>$token]);

            $this->ci->get('flash')->addMessage('info',
                'Please verify your email address at https://broforce.informatik.haw-hamburg.de'. $url);
            return $response->withRedirect($this->ci->get('router')->pathFor('register'));
        }
    }
}