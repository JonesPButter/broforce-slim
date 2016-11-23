<?php
namespace Source\Controller;
use Source\Models\User;
use Respect\Validation\Validator as Validator;

class RegistrationController extends AbstractController
{

    public function index($request, $response, $args){
        //$response->getBody()->write("Registration-View in progress...");
        //$messages = $this->ci->get('flash')->getMessages();
        //$this->ci->get('view')->getEnvironment()->addGlobal('messages', $messages);
        return $this->ci->get('view')->render($response, 'register.twig');
    }


    public function register($request, $response, $args){
        $validation = $this->ci->get('validator')->validate($request,[
            'email' => Validator::noWhitespace()->notEmpty()->emailAvailable(),
            'username' => Validator::noWhitespace()->notEmpty()->alpha(),
            'password' => Validator::noWhitespace()->notEmpty(),
        ]);

        if(!$validation->failed()){
            $user = User::create([
                'username' => $request->getParam('username'),
                'email' => $request->getParam('email'),
                'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
            ]);
            return $response->withRedirect($this->ci->get('router')->pathFor('register.success'));
        } else{
            //$this->ci->get('flash')->addMessage('RegisterForm', 'Please fill in the whole form and check your passwords.');

            return $response->withRedirect($this->ci->get('router')->pathFor('register'));
        }
    }

    public function success($request, $response, $args){
        //$response->getBody()->write("Hello");
        return $this->ci->get('view')->render($response, 'registrationSuccess.twig');
    }
}