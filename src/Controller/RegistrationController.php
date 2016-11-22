<?php
namespace Source\Controller;
use Source\Models\User;

class RegistrationController extends AbstractController
{

    public function index($request, $response, $args){
        //$response->getBody()->write("Registration-View in progress...");
        $messages = $this->ci->get('flash')->getMessages();
        $this->ci->get('view')->getEnvironment()->addGlobal('messages', $messages);
        return $this->ci->get('view')->render($response, 'register.twig');
    }


    public function register($request, $response, $args){
        $parsedBody = $request->getParsedBody();

        $name = $parsedBody['name'];
        $email = $parsedBody['email'];
        $password_one = $parsedBody['password_one'];
        $password_two = $parsedBody['password_two'];
        // Email Validation: && !filter_var($email, FILTER_VALIDATE_EMAIL)
        if($password_one == $password_two){
            $hashed_password = password_hash($password_one, PASSWORD_DEFAULT);
            $user = new User($name,$email,$hashed_password);
            $response->getBody()->write(var_dump($user));
        } else{
            $this->ci->get('flash')->addMessage('RegisterForm', 'Please fill in the whole form and check your passwords.');

            //$url = $this->router->pathFor('register', ['body' => $parsedBody]);
            //return $response->withStatus(302)->withHeader('Location', $url);
            $uri = $request->getUri()->withPath($this->ci->get('router')->pathFor('register'));
            return $response = $response->withRedirect($uri, 403);
        }
    }
}