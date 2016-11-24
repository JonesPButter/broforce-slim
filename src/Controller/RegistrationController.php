<?php
namespace Source\Controller;
use Source\Models\DAOs\UserDAO;
use Respect\Validation\Validator as Validator;

class RegistrationController extends AbstractController
{

    /**
     * This is the index of the registration process,
     * which shows the registration form.
     */
    public function index($request, $response){
        return $this->ci->get('view')->render($response, 'register.twig');
    }


    /**
     * This function receives the data, typed in and submitted by the user
     * at the register.twig-view.
     */
    public function register($request, $response){
        $validation = $this->ci->get('validator')->validate($request,[
            'email' => Validator::noWhitespace()->notEmpty()->emailAvailable(),
            'username' => Validator::noWhitespace()->notEmpty()->alpha(),
            'password' => Validator::noWhitespace()->notEmpty(),
        ]);

        if($validation->failed()){
            return $response->withRedirect($this->ci->get('router')->pathFor('register'));
        } else{
            $this->ci->get('userDAO')->create($request->getParam('username'),$request->getParam('email'),
                                            password_hash($request->getParam('password'), PASSWORD_DEFAULT));
            $users = $this->ci->get('userDAO')->getAllUsers();
            var_dump($users); die();
            return $response->withRedirect($this->ci->get('router')->pathFor('register.success'));
        }
    }

    /**
     * This site shows up, when the user was successfully registered
     * TODO Should be only viewed by a user, if he was really successfully registered
     */
    public function success($request, $response){
        return $this->ci->get('view')->render($response, 'registrationSuccess.twig');
    }
}