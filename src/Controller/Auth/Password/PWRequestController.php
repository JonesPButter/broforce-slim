<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 06.12.2016
 * Time: 09:31
 */

namespace Source\Controller\Auth\Password;
use Respect\Validation\Validator;
use Source\Controller\AbstractController;

/**
 * Class PWRequestController
 * @package Source\Controller\Auth\Password
 *
 * Description: The PWRequestController handles the password request process.
 * Example: A user has forgotten his password. So what he does is, he clicks on the "forgot password" button and
 * after that, he will communicate with this controller.
 */
class PWRequestController extends AbstractController
{

    /*
     * Returns the forgotPW page
     */
    public function getForm($request, $response){
        return $this->ci->get('view')->render($response, 'forgotPW.twig');
    }

    /*
     * Sends the createNewPW link, if the given email was correct.
     */
    public function sendLink($request, $response){
        $email = $request->getParam('email');
        // Validate form-input
        $validation = $this->ci->get('validator')->validate($request,[
            'email' => Validator::noWhitespace()->notEmpty()->email(),
        ]);

        if(!$validation->failed()){
            $user = $this->ci->get('userDAO')->getUserWithEmail($email);
            if($user){
                $milliseconds = round(microtime(true) * 1000);
                $token = $this->ci->get('auth')->createToken() . "-". $milliseconds;
                $userId = $user->getId();
                $user->setToken($token);
                $this->ci->get('userDAO')->updateUser($user);
                $url = $this->ci->get('router')->pathFor('createNewPW',['userid'=>$userId, 'token'=>$token]);
                $this->ci->get('flash')->addMessage('info',
                    'Go ahead and change your password at https://broforce.informatik.haw-hamburg.de'. $url);
            } else{
                $this->ci->get('flash')->addMessage('error', 'The email address is unknown.');
            }
        }
        return $response->withRedirect($this->ci->get('router')->pathfor('login'));
    }

    /*
     * Returns the createNewPW Page if the given token and the userID are valid.
     */
    public function getCreateNewPWForm($request, $response){
        $userID = $request->getAttribute('route')->getArgument('userid');
        $token = $request->getAttribute('route')->getArgument('token');
        $user = $this->ci->get('userDAO')->getUserByID($userID);

        if($user){
            if(strcmp($token, $user->getToken()) === 0){
                $tokenTimeInMillis = floatval(explode("-", $token)[1]);
                $currentTimeInMillis = round(microtime(true) * 1000);
                if(($currentTimeInMillis - $tokenTimeInMillis) >= 1800000){
                    $this->ci->get('flash')->addMessage('error', 'The Token is not valid anymore.');
                } else{
                    return $this->ci->get('view')->render($response, 'createNewPW.twig', ['id'=>$userID, 'token'=>$token]);
                }
            }
        }
        return $response->withRedirect($this->ci->get('router')->pathFor('login'));
    }

    /*
     * Validates the new Password and saves it, if it matches all given rules.
     */
    public function createNewPW($request, $response){
        $userID = $request->getAttribute('route')->getArgument('userid');
        $token = $request->getAttribute('route')->getArgument('token');
        $user = $this->ci->get('userDAO')->getUserByID($userID);

        if($user){
            $validation = $this->ci->get('validator')->validate($request,[
                'password' => Validator::noWhitespace()->notEmpty()->passwordLength()->passwordLetter()->passwordNumber(),
            ]);

            if(!$validation->failed()){
                $user->setPassword(password_hash($request->getParam('password'), PASSWORD_DEFAULT));
                $user->setToken("");
                $this->ci->get('userDAO')->updateUser($user);
                $this->ci->get('flash')->addMessage('info', "The users password has been successfully changed.");
            } else{
                return $response->withRedirect($this->ci->get('router')->pathFor('createNewPW',['userid'=>$userID, 'token'=>$token]));
            }
        } else{
            $this->ci->get('flash')->addMessage('error', "Not allowed.");
        }
        return $response->withRedirect($this->ci->get('router')->pathFor('login'));
    }
}