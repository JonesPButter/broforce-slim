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
            $token = $this->ci->get('auth')->createToken();

            $this->ci->get('userDAO')->create($request->getParam('username'), $request->getParam('email'),
                password_hash($request->getParam('password'), PASSWORD_DEFAULT), $token);

            $milliseconds = round(microtime(true) * 1000);
            $userTocken = $token . ".". $milliseconds;
            $user = $this->ci->get('userDAO')->getUserWithEmail($request->getParam('email'));
            $userId = $user->getId();
            $url = "https://broforce.informatik.haw-hamburg.de/verify.php?t=$userTocken&user=$userId";

            $this->ci->get('flash')->addMessage('info', 'Please verify your email address at '. $url);
            return $response->withRedirect($this->ci->get('router')->pathFor('register'));
        }
    }

    /**
     * This site shows up, when the user was successfully registered
     * TODO Should be only viewed by a user, if he was really successfully registered
     */
    public function success($request, $response)
    {
        return $this->ci->get('view')->render($response, 'registrationSuccess.twig');
    }
}